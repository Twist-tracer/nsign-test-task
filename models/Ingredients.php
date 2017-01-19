<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%ingredients}}".
 *
 * @property integer $id
 * @property string $name
 */
class Ingredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ingredients}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Заполните поле'],
            [['name'], 'string', 'max' => 128],
            [['name'], 'unique', 'message' => 'Ингредиент {value} уже добавлен'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название ингредиента',
        ];
    }

    public static function getArray($ingredients) {
        $array = [];
        if(is_array($ingredients)) {
            foreach($ingredients as $ingredient) {
                $array[$ingredient->id] = $ingredient->name;
            }
        } else {
            $array[$ingredients->id] = $ingredients->name;
        }

        return $array;
    }

    public function beforeDelete()
    {
        $return = TRUE;
        if(DiRelations::find()->where('ingredient_id ='. $this->id)->count() > 0) {
            if(!DiRelations::deleteAll('ingredient_id ='. $this->id)) {
                $return = FALSE;
            }
        }
        return $return;
    }

}
