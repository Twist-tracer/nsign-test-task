<?php

/* @var $this yii\web\View */
/* @var $dishes app\models\Dishes */
/* @var $pagination */

use yii\widgets\LinkPager;

$this->title = 'Меню';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Наше меню</h1>
    </div>

    <div class="body-content">
        <table class="table table-bordered table-responsive">
            <thead>
                <th>
                    Название блюда
                </th>
                <th>
                    Ингредиенты
                </th>
            </thead>
            <tbody>
                <?php foreach($dishes as $dish) {?>

                    <tr>
                        <td><?=$dish->name?></td>
                        <td>
                            <?php if(!empty($dish->ingredients)) {?>
                                <?=implode(', ', $dish->ingredients)?>
                            <?php } else {?>
                                <?='На данный момент интгридентов к этому блюду нет.'?>
                            <?php }?>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>

        </table>

        <div class="pafination">
            <?= LinkPager::widget([
                'pagination' => $pagination,
            ])?>
        </div>

    </div>
</div>
