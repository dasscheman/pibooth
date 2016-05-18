<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;

$this->title = 'View';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-upload">
    <h1><?= Html::encode($this->title) ?></h1>
        <p>
            Dit zijn alle foto's van het feest.
        </p>
<!--
        <div class="row">
            <div class="col-lg-5">-->
        <?php 
        \metalguardian\fotorama\Fotorama::setDefaults(
            [
                'nav' => 'thumbs',
                'startindex' => 2,
                'autoplay' => 2000,
                'shuffle' => true,
                'allowfullscreen' => true,
                'maxwidth' => '100%',
                'maxheight' => '100%',
                'spinner' => [
                    'lines' => 20,
                ],
                'loop' => true,
                'hash' => true,
            ]
        );
    
        echo \metalguardian\fotorama\Fotorama::widget(
            [
                'items' => $model,
                'options' => [
                    'nav' => 'thumbs',
                ]
            ]
        ); 
        ?>
<!--            </div>
        </div>-->
</div> 