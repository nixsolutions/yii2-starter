<?php

use app\modules\feedback\models\Feedback;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\feedback\models\Feedback */

$this->title = Yii::t('feedback', 'Update {modelClass}: ', [
    'modelClass' => 'Feedback',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('feedback', 'Feedbacks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('feedback', 'Update');
?>
<div class="feedback-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="feedback-form">

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

        <?= $form->field($model, 'status')->dropDownList([
            Feedback::STATUS_NEW => ucfirst(Feedback::STATUS_NEW),
            Feedback::STATUS_ANSWERED => ucfirst(Feedback::STATUS_ANSWERED),
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('feedback', 'Update'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
