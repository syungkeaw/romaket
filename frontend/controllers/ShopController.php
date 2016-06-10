<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use common\models\Shop;
use common\models\ShopSearch;
use common\models\ShopItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class ShopController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Shop models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shop model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $shopItems = ShopItem::find()->where(['shop_id' => $id, 'status' => ShopItem::STATUS_ACTIVE])->all();
        if(empty($shopItems)){
            $shopItems = new ShopItem();
            $shopItems = [$shopItems];
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'shopItems' => $shopItems,
        ]);
    }

    /**
     * Creates a new Shop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $item_model = Item::find()->all();
        $shop_model = new Shop();
        for($slot = 0; $slot <= 11; $slot++){
            $shop_item_model[$slot] = new ShopItem();
        }

        $this->saveShop($shop_model, $shop_item_model);

        return $this->render('create', [
            'shop_model' => $shop_model,
            'shop_item_model' => $shop_item_model,
            'item_model' => $item_model,
        ]);
    }

    /**
     * Updates an existing Shop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $item_model = Item::find()->all();
        $shop_model = $this->findModel($id);
        $shop_item_model = ShopItem::findAll(['shop_id' => $id]);

        for($slot = count($shop_item_model); $slot <= 11; $slot++){
            $shop_item_model[$slot] = new ShopItem();
        }

        foreach ($shop_item_model as $key => $model)
            $shop_item_model_old[$key] = clone $model;

        $this->saveShop($shop_model, $shop_item_model, $shop_item_model_old);
        
        return $this->render('update', [
            'shop_model' => $shop_model,
            'shop_item_model' => $shop_item_model,
            'item_model' => $item_model,
        ]);
    }

    /**
     * Deletes an existing Shop model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Shop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shop::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function saveShop($shop_model, $shop_item_model, $shop_item_model_old = null)
    {
        if ($shop_model->load(Yii::$app->request->post()) && $shop_model->validate()) {
            if (Model::loadMultiple($shop_item_model, Yii::$app->request->post()) && Model::validateMultiple($shop_item_model)) {
                if($shop_model->save()){
                    foreach ($shop_item_model as $key => $model) {
                        if(is_null($shop_item_model_old)|| ($shop_item_model_old[$key]->item_id != $model->item_id
                                                        || $shop_item_model_old[$key]->amount != $model->amount
                                                        || $shop_item_model_old[$key]->price != $model->price))
                        {
                            if($model->item_id) {
                                $model->shop_id = $shop_model->id;
                                $model->save();
                            }
                        }

                    }
                }
                return $this->redirect(['view', 'id' => $shop_model->id]);
            }
        } 
    }
}
