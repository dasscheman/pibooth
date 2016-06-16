<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadForm;
use yii\web\UploadedFile;

use app\components\AccessRule;
use app\models\User;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['index', 'upload', 'viewimages'],
                'rules' => [
                    [
                        'actions' => ['upload', 'viewimages' ],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            User::ROLE_USER,
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    
    
    
    
    
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
          return $this->render('login', [
              'model' => $model,
          ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
                //$model->resize();
                //$model->rotate();
                // file is uploaded successfully            
                Yii::$app->session->setFlash('uploadFormSubmitted');

                return $this->refresh();
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
    
    public function actionViewimages()
    {
        $files = array();
        
        $files=\yii\helpers\FileHelper::findFiles('uploads/', ['only'=>['*.png','*.jpg','*.jpeg']]);
        $model = array();
        if (isset($files[0])) {
            foreach ($files as $index => $file) {
              	// returns array if image file is readable      
                $exif = @exif_read_data($file, 0, true);
                $timestamp = null;
                if($exif) {
                    // prioritize the available datetimes
                    if(isset($exif['EXIF']['DateTimeOriginal'])) {
                      $timestamp = $exif['EXIF']['DateTimeOriginal'];
                      //$timestamp = str_replace(array(':', ' '), '', $exif['EXIF']['DateTimeOriginal']);
                    }
                    elseif(isset($exif['EXIF']['DateTimeDigitized'])) {
                      $timestamp = $exif['EXIF']['DateTimeDigitized'];
                      //$timestamp = str_replace(array(':', ' '), '', $exif['EXIF']['DateTimeDigitized']);
                    }
                    elseif(isset($exif['IFD0']['DateTime'])) {
                      $timestamp = $exif['IFD0']['DateTime'];
                      //$timestamp = str_replace(array(':', ' '), '', $exif['IFD0']['DateTime']);
                    }
                    elseif(isset($exif['FILE']['FileDateTime'])) {
                      $timestamp = $exif['FILE']['FileDateTime'];
                      //$timestamp = date('YmdHis', $exif['FILE']['FileDateTime']);
                    }

                    // bad timestamp
                    if($timestamp == '00000000000000') {
                        $timestamp = date('YmdHis', filemtime($file));
                    }
                }
                $tempFiles[basename($file)] = $timestamp;
            }
        } else {
            echo "There are no files available for download.";
        }
        //var_dump($tempFiles); exit;
        asort($tempFiles);
        
        foreach ($tempFiles as $key => $value) {
            $model[] = ['img' => 'uploads/small/' . $key, 'caption' => $value];
        }

        // Hier geven we de autoplay tijd mee.
        // Ik doe dat hier omdat de page refresh time gekoppeld is aan de 
        // autoplay time. Op deze manier wordt er pas een refresh gedaan als 
        // alle foto's getoont zijn. Nieuwe foto's worden dan dus pas getoont 
        // als het rondje afgemaakt is.
        $time['autoplay'] = 2000;
        $time['refresh'] = $time['autoplay'] * count($files);
        
        return $this->render('viewimages', ['model' => $model, 'time' => $time]);
    }
}
