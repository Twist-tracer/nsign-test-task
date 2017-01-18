<?php

use yii\db\Migration;

/**
 * Handles the creation of table `dishes`.
 */
class m170118_020952_create_dishes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(Yii::$app->db->tablePrefix.'dishes', [
            'id' => $this->primaryKey(11),
            'name' => $this->string(128)->notNull()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('dishes');
    }
}
