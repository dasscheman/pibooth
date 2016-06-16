<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\UploadForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;

$this->title = 'Upload';
?>

<div class="site-upload">
    <div class="jumbotron">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php
        if (Yii::$app->session->hasFlash('uploadFormSubmitted')) { ?>

          <div class="alert alert-success">
              Dank voor het uploaden van je foto's.
          </div>

          <p>
              Je kunt de foto's <?= Html::a('hier', ['site/viewimages'], ['class' => 'profile-link']) ?> bekijken.
              Of je kunt <?= Html::a('hier', ['site/upload'], ['class' => 'profile-link']) ?> nog meer foto's toevoegen.
          </p>

        <?php } else { ?>
          <p>
            Je kunt 1 of meerdere foto's selecteren (max 8M per foto, 10 foto's per keer). 
          </p>
          <?php
          $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
          echo $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), [
              'options' => ['multiple' => true, 'accept' => 'image/*', 'maxFileSize'=> 10280,],
              'pluginOptions' => [
                  'previewFileType' => 'image',
                  'showCaption' => false,
                  'showRemove' => true,
                  'showUpload' => true,
                  'browseClass' => 'btn btn-primary btn-block',
                  'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                  'browseLabel' =>  'Select Photo'
              ]
          ]);
          ActiveForm::end();
        } ?>

    </div> 
</div> 