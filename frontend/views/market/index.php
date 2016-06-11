<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\classes\ItemHelper;
use kartik\typeahead\Typeahead;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ShopItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="shop-item-index">
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'item.item_name',
                'label' => 'Items',
                'value' => function($model){
                    return Html::img(Yii::$app->params['item_small_image_url'].
                        ItemHelper::getImgFileName($model->item)) .' '.
                        $model->item['nameSlot'];
                },
                'format' => 'html',
                'filter' => Typeahead::widget([
                    'name' => 'ShopItemSearch[item.item_name]',
                    'value' => $searchModel['item.item_name'],
                    'dataset' => [
                        [
                            'local' => ArrayHelper::getColumn($items, 'item_name'),
                            'limit' => 10,
                        ],
                    ],
                    'pluginOptions' => ['highlight' => true],
                    'pluginEvents' => [
                        "typeahead:change" => "function() { $(this).change() }",
                        "typeahead:select" => "function() { $(this).change() }",
                    ],

                ])
            ],
            [
                'attribute' => 'price',
                'label' => 'Price (Zeny)',
                'value' => function($model){
                    return number_format($model->price);
                },
            ],
            [
                'attribute' => 'amount',
                'label' => 'Amount',
                'value' => function($model){
                    return number_format($model->amount);
                },
            ],
            [
                'attribute' => 'shop.shop_name',
                'label' => 'Shop',
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Latest',
                'format' => ['date', 'php:d M Y H:i:s'],
                'filter' => false,
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
