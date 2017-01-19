<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
use dosamigos\multiselect\MultiSelect;

/* @var $this yii\web\View */
/* @var $model app\models\Ingredients */
/* @var $ingredients array */
/* @var $form ActiveForm */

$this->title = 'Редактирование Блюда';
?>
<div class="admin-update_dish">

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

        <?php
        $mult_options = [
            "options" => ['multiple'=>"multiple"], // for the actual multiselect
            'data' => $ingredients['list'], // data as array
        ];

        if(!empty($ingredients['checked'])) {
            $mult_options += ['value' => $ingredients['checked']];
        }
        ?>

        <?= $form->field($model, 'rel_ingred_ids', [
            'template' => '{label}<br>{input}{error}{hint}'
        ])->label('Ингредиенты')->widget(MultiSelect::className(), $mult_options) ?>

        <div class="form-group">
            <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admin-create_ingredient -->
