<?php

use yii\db\Migration;

/**
 * Handles the creation of table `di_relations`.
 */
class m170118_022126_create_di_relations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(Yii::$app->db->tablePrefix.'di_relations', [
            'dish_id' => $this->integer(11)->notNull(),
            'ingredient_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('FK_dish_id', Yii::$app->db->tablePrefix.'di_relations', 'dish_id', Yii::$app->db->tablePrefix.'dishes', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('FK_ingredient_id', Yii::$app->db->tablePrefix.'di_relations', 'ingredient_id', 'ingredients', 'id', 'NO ACTION', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable(Yii::$app->db->tablePrefix.'di_relations');

        $this->dropForeignKey('FK_dish_id', Yii::$app->db->tablePrefix.'di_relations');
        $this->dropForeignKey('FK_ingredient_id', Yii::$app->db->tablePrefix.'di_relations');
    }
}
