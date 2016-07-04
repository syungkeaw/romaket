<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\classes\ItemHelper;
use common\models\Item;
use yii\web\View;

$label = [
    '',
    ['label' => 'danger', 'icon' => '994'],
    ['label' => 'info', 'icon' => '995'],
    ['label' => 'success', 'icon' => '996'],
    ['label' => 'default', 'icon' => '997'],
];
$elements = Item::getElements();
$very = Item::getVeries();

$this->registerJs("
    var size = 10;
    var origin = $('.map-picker').offset();
    var location = '".$model->shop['location']."';
    if(location !== ''){
        axis = location.split(',');
        $('body').append(
            $('<div class=\"dot\"></div>').css({
                position: 'absolute',
                top: (origin.top + parseInt(axis[1])) + 'px',
                left: (origin.left + parseInt(axis[0])) + 'px',
                width: size + 'px',
                height: size + 'px',
                background: 'red'
            })
        );
    }
", View::POS_READY);

$this->registerCss("
.wrap > .container {
    padding: 0px;
}
.map-picker {
    height: 400px;
    width: 400px;
}
.map-picker>img {
    height: 100%;
    width: 100%;
}
");

$this->title = $model->item->nameSlot;
?>
<div class="shop-item-view">

    <h3><?= 
    	Html::img(Yii::getAlias('@web'). '/images/items/large/'. ItemHelper::getImgFileName($model->item)). ' '.
    	($model->enhancement ? '+'. $model->enhancement.' ' : '').
    	Html::encode($this->title)
    ?></h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Price',
                'value' => '<h4>'.number_format($model->price).' zeny</h4>',
                'format' => 'raw',
            ],
            [
                'label' => 'Location',
                'value' => '<div class="map-picker">'.Html::img(Yii::getAlias('@web'). '/images/maps/'.$model->shop['map']. '.gif').'</div>',
                'format' => 'raw',
            ],
            [
                'label' => 'Cards',
                'value' => ($model->card_1 ? Html::img(Yii::getAlias('@web'). '/images/items/large/'.$model->itemCard1->source_id.'.gif') : ''). ' '.
                            ($model->card_2 ? Html::img(Yii::getAlias('@web'). '/images/items/large/'.$model->itemCard2->source_id.'.gif') : ''). ' '.
                            ($model->card_3 ? Html::img(Yii::getAlias('@web'). '/images/items/large/'.$model->itemCard3->source_id.'.gif') : ''). ' '.
                            ($model->card_4 ? Html::img(Yii::getAlias('@web'). '/images/items/large/'.$model->itemCard4->source_id.'.gif') : ''),
                'format' => 'raw',
            ],
            [
                'label' => 'Element',
                'value' => ($model->very ? $very[$model->very] : '').' '.($label[$model->element] ? Html::img(Yii::getAlias('@web'). '/images/items/small/'.$label[$model->element]['icon'].'.gif').' <span class="label label-'.$label[$model->element]['label'].'">' .$elements[$model->element]. '</span>' : ''),
                'format' => 'raw',
            ],
            'amount',
            'shop.shop_name',
            'shop.character',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
