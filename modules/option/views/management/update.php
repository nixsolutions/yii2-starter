<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\option\models\Option */

$optionName = "$model->namespace $model->key";
$this->title = Yii::t('option', 'Update {modelClass}: ', [
        'modelClass' => 'Option',
    ]) . $optionName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('option', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => $optionName,
    'url' => ['view', 'namespace' => $model->namespace, 'key' => $model->key],
];
$this->params['breadcrumbs'][] = Yii::t('option', 'Update');
?>
<div class="option-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
