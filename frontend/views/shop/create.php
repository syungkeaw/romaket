<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Shop */

$this->title = 'Create Shop';
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'shop_model' => $shop_model,
        'shop_item_model' => $shop_item_model,
        'item_model' => $item_model,
    ]) ?>

</div>
