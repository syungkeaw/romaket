<?php

namespace frontend\controllers;

use Yii;
use common\models\ShopItem;
use common\models\ShopItemSearch;
use common\models\Item;
use common\models\Shop;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ShopItemController implements the CRUD actions for ShopItem model.
 */
class MarketController extends Controller
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
     * Lists all ShopItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $items = Item::find()->all();

        $shopItem = ShopItem::find()->asArray()->all();
        $option = [];
        $option = array_merge($option, ArrayHelper::getColumn($shopItem, 'card_1'));
        $option = array_merge($option, ArrayHelper::getColumn($shopItem, 'card_2'));
        $option = array_merge($option, ArrayHelper::getColumn($shopItem, 'card_3'));
        $option = array_merge($option, ArrayHelper::getColumn($shopItem, 'card_4'));
        $option = array_filter($option);
        $option_item = Item::findAll(['source_id' => ['994', '995', '996', '997'] + $option]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'items' => $items,
            'option_item' => $option_item,
        ]);
    }

    /**
     * Displays a single ShopItem model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ShopItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShopItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ShopItem model.
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
     * Finds the ShopItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
