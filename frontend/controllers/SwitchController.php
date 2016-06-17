<?php

namespace frontend\controllers;

use Yii;
use common\models\ShopItem;
use common\models\ShopItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * ShopItemController implements the CRUD actions for ShopItem model.
 */
class SwitchController extends Controller
{
    public function actionIndex()
    {
        $session = new Session;
        $session->open();
        $session->set('server', Yii::$app->request->get('server'));
        return $this->redirect(Yii::$app->request->referrer);
    }
}
