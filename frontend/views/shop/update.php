<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Shop */

$this->title = 'Update Shop: ' . $shop_model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $shop_model->id, 'url' => ['view', 'id' => $shop_model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shop-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'shop_model' => $shop_model,
        'shop_item_model' => $shop_item_model,
        'item_model' => $item_model,
    ]) ?>

</div>
