<?php

/* @var $this yii\web\View */

$this->title = 'Панель Администратора';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-6">
                <h2>Ингредиенты</h2>

                <a href="<?=Yii::$app->urlManager->createUrl(['admin/all_ingredients'])?>">
                    <img src="images/ingredients.png" class="img-thumbnail" alt="Ингредиенты" width="100%">
                </a>

            </div>
            <div class="col-md-6">
                <h2>Блюда</h2>

                <a href="<?=Yii::$app->urlManager->createUrl(['admin/all_dishes'])?>">
                    <img src="images/dishes.jpg" class="img-thumbnail" alt="Блюда" width="100%">
                </a>
            </div>
        </div>

    </div>
</div>
