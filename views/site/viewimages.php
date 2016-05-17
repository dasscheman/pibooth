<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\UploadForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'View';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-uplaod">
    <h1><?= Html::encode($this->title) ?></h1>
<?php
$img = Url::to('@web/uploads//').$img_obj['AVATAR'];                 
$image = '<img src="'.$img.'" width="600" />';  
?>

 <img src="<?= Yii::$app->request->baseUrl . '/web/uploads/' . $model->profile_photo ?>" class=" img-responsive" >  
<?php echo Html::img('@web/img/icon.png', ['class' => 'pull-left img-responsive']); ?>

 <div>