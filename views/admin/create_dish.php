<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\multiselect\MultiSelect;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Dishes */
/* @var $ingredients array */
/* @var $form ActiveForm */

$this->title = 'Добавить Блюдо';
?>
<div class="admin-create_dish">

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

        <?= $form->field($model, 'name') ?>

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
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admin-create_dish -->
