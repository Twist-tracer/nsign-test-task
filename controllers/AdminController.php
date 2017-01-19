<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Search\IngredientsSearch;
use app\models\Ingredients;
use app\models\Search\DishesSearch;
use app\models\Dishes;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

class AdminController extends MainController
{
    public $layout = 'admin';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function () {
                    return Yii::$app->response->redirect(['site/login']);
                },
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate_ingredient()
    {
        $model = new Ingredients();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->save()) {
                    Yii::$app->session->setFlash('create-ingredient', [
                        'success' => TRUE,
                        'message' => 'Ингредиент '.$model->name.' успешно добавлен!'
                    ]);

                    return $this->redirect(['admin/create_ingredient']);
                } else {
                    $save_info = [
                        'success' => FALSE,
                        'message' => 'Произошла ошибка при добавлении ингредиента'
                    ];
                }
            }
        }

        if(empty($save_info)) {
            $save_info = Yii::$app->session->getFlash('create-ingredient');
        }

        return $this->render('create_ingredient', [
            'model' => $model,
            'save_info' => $save_info
        ]);
    }

    public function actionCreate_dish()
    {
        $dishes = new Dishes;

        $ingredients = Ingredients::find()->all();

        if(empty($ingredients)) {
            throw new BadRequestHttpException('Сначала добавьте ингредиенты');
        }

        $ingredients = Ingredients::getArray($ingredients);

        if ($dishes->load(Yii::$app->request->post())) {
            if($dishes->save()) {
                Yii::$app->session->setFlash('create-dish', [
                    'success' => TRUE,
                    'message' => 'Блюдо '.$dishes->name.' успешно добавлено!'
                ]);

                return $this->redirect(['admin/create_dish']);
            } else {
                $save_info = [
                    'success' => FALSE,
                    'message' => 'Произошла ошибка при добавлении блюда'
                ];
            }
        }

        if(empty($save_info)) {
            $save_info = Yii::$app->session->getFlash('create-dish');
        }

        return $this->render('create_dish', [
            'model' => $dishes,
            'ingredients' => [
                'list' => $ingredients,
                'checked' => !empty($dishes->rel_ingred_ids) ? $dishes->rel_ingred_ids : NULL,
            ],
            'save_info' => $save_info
        ]);
    }

    public function actionAll_ingredients()
    {
        $searchModel = new IngredientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('all_ingredients', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAll_dishes()
    {
        $searchModel = new DishesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('all_dishes', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate_ingredient()
    {
        $ingredient = Ingredients::findOne(Yii::$app->request->get('id'));

        if ($ingredient->load(Yii::$app->request->post())) {
            if ($ingredient->validate()) {
                if($ingredient->update()) {
                    Yii::$app->session->setFlash('update-ingredient', [
                        'success' => TRUE,
                        'message' => 'Успешно обновленно.'
                    ]);

                    return $this->redirect(['admin/update_ingredient', 'id' => $ingredient->id]);
                } else {
                    $save_info = [
                        'success' => FALSE,
                        'message' => 'Произошла ошибка при обновлении ингредиента!'
                    ];
                }
            }
        }

        if(empty($save_info)) {
            $save_info = Yii::$app->session->getFlash('update-ingredient');
        }

        return $this->render('update_ingredient', [
            'model' => $ingredient,
            'save_info' => $save_info
        ]);
    }

    public function actionUpdate_dish()
    {
        $ingredients = Ingredients::find()->all();
        if(empty($ingredients)) {
            throw new BadRequestHttpException('Сначала добавьте ингредиенты');
        }
        $ingredients = Ingredients::getArray($ingredients);

        $dish = new Dishes();
        $dish->id = Yii::$app->request->get('id');
        $dish = $dish->findOne(Yii::$app->request->get('id'));

        if ($dish->load(Yii::$app->request->post())) {
            if($dish->update()) {
                Yii::$app->session->setFlash('update-dish', [
                    'success' => TRUE,
                    'message' => 'Успешно обновленно.'
                ]);

                return $this->redirect(['admin/update_dish', 'id' => $dish->id]);
            } else {
                $save_info = [
                    'success' => FALSE,
                    'message' => 'Произошла ошибка при обновлении блюда!'
                ];
            }
        }

        if(empty($save_info)) {
            $save_info = Yii::$app->session->getFlash('update-dish');
        }

        return $this->render('update_dish', [
            'model' => $dish,
            'ingredients' => [
                'list' => $ingredients,
                'checked' => !empty($dish->rel_ingred_ids) ? $dish->rel_ingred_ids : NULL,
            ],
            'save_info' => $save_info
        ]);
    }

    public function actionDelete_ingredient()
    {
        $model = Ingredients::findOne(Yii::$app->request->get('id'));

        if(!$model->delete()) {
            throw new ServerErrorHttpException('Произошла ошибка при удалении');
        }

        return $this->goBack(Yii::$app->request->referrer);
    }

    public function actionDelete_dish()
    {
        $model = Dishes::findOne(Yii::$app->request->get('id'));

        if(!$model->delete()) {
            throw new ServerErrorHttpException('Произошла ошибка при удалении');
        }

        return $this->goBack(Yii::$app->request->referrer);
    }
}
