<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii\widgets\Pjax;

$refresh  = $time['refresh'];

$script = <<< JS
$(document).ready(function() {
	setInterval(function(){ $("#beschikbaar").click(); }, $refresh);
});
JS;
$this->registerJs($script);

$this->title = 'Foto overzicht';
?>

<div class="site-view">
    <div class="jumbotron">
      <h1><?= Html::encode($this->title) ?></h1>
          <?php 
          \metalguardian\fotorama\Fotorama::setDefaults([
              'nav' => 'thumbs',
              'startindex' => 0,
              'autoplay' => $time['autoplay'],
              'shuffle' => true,
              'allowfullscreen' => true,
              'width' => '100%',
              'maxwidth' => '100%',
              'height' => '100%',
              'maxheight' => '100%',
              'spinner' => [
                  'lines' => 20,
              ],
              'loop' => true,
              'hash' => true,
          ]);

          Pjax::begin();			
          echo Html::a("Nieuwe foto's ophalen",
            ['site/viewimages'],
            ['class' => 'btn btn-lg btn-primary', 'id' => 'beschikbaar']); 

          echo \metalguardian\fotorama\Fotorama::widget([
              'items' => $model,
              'options' => [
                  'nav' => 'thumbs',
              ]
          ]); 
          Pjax::end(); ?>

              </div>
          </div>
</div> 