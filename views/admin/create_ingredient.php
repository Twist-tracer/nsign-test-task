<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Ingredients */
/* @var $form ActiveForm */

$this->title = 'Добавить Ингридиент';
?>
<div class="admin-create_ingredient">

    <?php if(!empty($save_info)) {?>
        <?php if($save_info['success']) {?>
            <?=Alert::widget([
                'options' => [
                    'class' => 'alert-success',
                ],
                'body' => $save_info['message'],
            ])?>
        <?php } else {?>
            <?=Alert::widget([
                'options' => [
                    'class' => 'alert-error',
                ],
                'body' => $save_info['message'],
            ])?>
        <?php } ?>
    <?php } ?>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->label('Название ингредиента') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admin-create_ingredient -->
