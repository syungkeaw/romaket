<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\classes\ItemHelper;
use yii\web\View;

$this->registerCss("
.wrap > .container {
    padding: 0px;
}
");

$this->title = $model->item->nameSlot;
?>
<div class="shop-item-view">

    <h1><?= 
    	Html::img(Yii::getAlias('@web'). '/images/items/large/'. ItemHelper::getImgFileName($model->item)). ' '.
    	($model->enhancement ? '+'. $model->enhancement.' ' : '').
    	Html::encode($this->title)
    ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'price',
            'amount',
            'created_at',
            'updated_at',
            'shop.shop_name',
        ],
    ]) ?>

</div>
