<?php

use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\Ingredients;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider app\models\Dishes */
/* @var $form ActiveForm */

$this->title = 'Ингридиенты';
?>
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'tableOptions' => [
            'class' => 'table table-bordered table-hover',
            'role' => 'grid',
        ],

        'columns' => [
            [
                'attribute' => 'id',
                'label' => (new Ingredients)->getAttributeLabel('id'),
            ],
            [
                'attribute' => 'name',
                'label' => (new Ingredients)->getAttributeLabel('name'),
            ],
            [
                'header' => 'Действия',
                'headerOptions' => ['style' => 'width:10%;'],
                'contentOptions' => ['style' => 'text-align: center;'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'urlCreator' => function($action, $model) {
                    return Yii::$app->urlManager->createUrl(['admin/'.$action.'_ingredient', 'id' => $model->id]);
                }
            ],
        ],
    ]) ?>
</div>