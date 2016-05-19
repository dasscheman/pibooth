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

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
        }
        return $this->render('login', [
            'model' => $model,
        ]);
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
                // file is uploaded successfully            
                Yii::$app->session->setFlash('uploadFormSubmitted');

                return $this->refresh();
                return $this->render('index');
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
    
    public function actionViewimages()
    {
        $files=\yii\helpers\FileHelper::findFiles('uploads/', ['only'=>['*.png','*.jpg']]);
        $model = array();
        if (isset($files[0])) {
            foreach ($files as $index => $file) {
                $model[] = ['img' => $file,];
            }
        } else {
            echo "There are no files available for download.";
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
