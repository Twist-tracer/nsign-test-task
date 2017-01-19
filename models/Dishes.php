<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%dishes}}".
 *
 * @property integer $id
 * @property string $name
 */
class Dishes extends \yii\db\ActiveRecord
{
    private static $with = [];

    public $rel_ingred_ids;
    public $ingredients;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dishes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rel_ingred_ids'], 'required', 'message' => 'Заполните поле'],
            [['name'], 'string', 'max' => 128],
            [['name'], 'unique', 'message' => 'Ингредиент {value} уже добавлен'],
            [['rel_ingred_ids'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function afterFind()
    {
        $this->set_ingred_ids();

        if(in_array('ingredients', self::$with)) {
            $this->ingredients = $this->get_ingredients();
        }
    }

    private function set_ingred_ids() {
        $rel_ingredients = DiRelations::find()->select('ingredient_id')->where('dish_id = :dish_id', ['dish_id' => $this->id])->all();
        $ingredients = [];

        foreach($rel_ingredients as $ingredient) {
            $ingredients[] = $ingredient->ingredient_id;
        }

        $this->rel_ingred_ids = $ingredients;
    }

    private function get_ingredients() {
        $ingredients = Ingredients::findAll($this->rel_ingred_ids);
        return Ingredients::getArray($ingredients);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $return = TRUE;

        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if(parent::save($runValidation, $attributeNames)) {
                    $rel = new DiRelations();
                    $rows = [];

                    foreach($this->rel_ingred_ids as $ingredient) {
                        $rel->dish_id = $this->id;
                        $rel->ingredient_id = $ingredient;

                        if(!$rel->validate()) {
                            $return = FALSE;
                            break;
                        }

                        $rows[] = $rel->attributes;
                    }

                    if($return) {
                        Yii::$app->db->createCommand()->batchInsert(DiRelations::tableName(), $rel->attributes(), $rows)->execute();
                    }
                } else {
                    $return = FALSE;
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
            }

            if($return) {
                $transaction->commit();
            }
        } else {
            $return = FALSE;
        }

        return $return;
    }

    public function update($runValidation = true, $attributeNames = null)
    {
        $return = TRUE;

        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if(parent::save($runValidation, $attributeNames)) {
                    if(!empty($this->getDirtyAttributes())) {
                        if(!parent::update($runValidation, $attributeNames)) {
                            $return = FALSE;
                        }
                    }

                    if($return) {
                        $rel = new DiRelations();
                        $rows = [];

                        if(DiRelations::find()->where('dish_id = '.$this->id)->count() > 0) {
                            if(!DiRelations::deleteAll('dish_id = '.$this->id)) {
                                $return = FALSE;
                            }
                        }

                        if($return) {
                            foreach($this->rel_ingred_ids as $ingredient) {
                                $rel->dish_id = $this->id;
                                $rel->ingredient_id = $ingredient;

                                if(!$rel->validate()) {
                                    $return = FALSE;
                                    break;
                                }

                                $rows[] = $rel->attributes;
                            }

                            Yii::$app->db->createCommand()->batchInsert(DiRelations::tableName(), $rel->attributes(), $rows)->execute();
                        }
                    }
                } else {
                    $return = FALSE;
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
            }

        } else {
            $return = FALSE;
        }

        return $return;
    }

    public function beforeDelete()
    {
        $return = TRUE;
        if(DiRelations::find()->where('dish_id ='. $this->id)->count() > 0) {
            if(!DiRelations::deleteAll('dish_id ='. $this->id)) {
                $return = FALSE;
            }
        }
        return $return;
    }

    public static function get_with(array $params) {
        self::$with = $params;
        return new self;
    }
}
