<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\UploadForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;

$this->title = 'Upload';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-uplaod">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('uploadFormSubmitted')): ?>

        <div class="alert alert-success">
            Dank voor het uploaden van je foto's.
        </div>

        <p>
            Je kunt de foto's <?= Html::a('hier', ['site/viewimages'], ['class' => 'profile-link']) ?> bekijken.
            Of je kunt <?= Html::a('hier', ['site/upload'], ['class' => 'profile-link']) ?> nog meer foto's toevoegen.
        </p>

    <?php else: ?>
        <p>
            Hier kun je 1 of meerdere foto's tegelijk uploaden.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php 
                    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                     <?=  $form->field($model, 'imageFiles[]')->widget(FileInput::classname(), [
                        'options' => ['multiple' => true, 'accept' => 'image/*', 'maxFileSize'=> 10280,],
                        'pluginOptions' => ['previewFileType' => 'image']
                    ]); ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    <?php endif; ?>
</div> 