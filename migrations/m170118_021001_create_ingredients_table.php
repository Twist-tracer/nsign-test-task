<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ingredients`.
 */
class m170118_021001_create_ingredients_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(Yii::$app->db->tablePrefix.'ingredients', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(128)->notNull()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ingredients');
    }
}
