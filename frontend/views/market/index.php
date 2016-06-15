<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\classes\ItemHelper;
use kartik\typeahead\Typeahead;
use yii\helpers\ArrayHelper;
use yii\web\View;
use common\models\Item;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ShopItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ro Market';
$elements = Item::getElements();
$very = Item::getVeries();
$label = [
    '',
    ['label' => 'danger', 'icon' => '994'],
    ['label' => 'info', 'icon' => '995'],
    ['label' => 'success', 'icon' => '996'],
    ['label' => 'default', 'icon' => '997'],
];


$this->registerJs("

", View::POS_READY);

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
                    $item = Html::img(Yii::$app->params['item_small_image_url'].
                        ItemHelper::getImgFileName($model->item)) .' '.
                        $model->item['nameSlot'];
                    return $item;
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

                ]),
                'headerOptions' => [
                    'class' => 'col-md-4'
                ],
            ],
            [
                'attribute' => 'enhancement',
                'label' => '+',
                'value' => function($model){
                    return $model->enhancement ? '+'.$model->enhancement : '';
                },
               'headerOptions' => [
                    'class' => 'col-md-1'
                ],
                'filter' => Html::dropDownList(
                    'ShopItemSearch[enhancement]',
                    $searchModel['enhancement'],
                    ['' => ''] + Item::getEnhancements(),
                    ['class' => 'form-control']
                ),
            ],
            [
                'attribute' => 'option',
                'label' => 'Option',
                'value' => function($model) use ($elements, $very, $items, $label){
                    $option = '';

                    foreach(range(1, 4) as $slot){
                        $option .= $model->{'card_'.$slot} ? '['. Html::img(Yii::$app->params['item_small_image_url']. 'card.gif') . $model->{'itemCard'.$slot}['item_name'] . ']<br>' : '';
                    }

                    $option .= $model->very ? ' '. $very[$model->very] : '';
                    $option .= $model->element ? 
                        Html::img(Yii::$app->params['item_small_image_url']. $label[$model->element]['icon']. '.gif').
                        ' <span class="label label-'. $label[$model->element]['label'] .'">'. $elements[$model->element].'</span>' : '';
                    return $option;
                },
                'headerOptions' => [
                    'class' => 'col-md-2'
                ],
                'format' => 'raw',
                'filter' => Select2::widget([
                    'name' => 'ShopItemSearch[option]',
                    'value' => $searchModel['option'],
                    'data' => ArrayHelper::map($option_item, 'source_id', 'nameSlot'),
                    'options' => ['placeholder' => 'Select a card or an element ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'templateResult' => new JsExpression('function format(item) {
                            return \'<img src="'. Yii::$app->params['item_small_image_url'] .'\' + (item.text.toLowerCase().indexOf(\'card\') > -1 ? \'card\' : item.id) + \'.gif"/> \' + item.text;
                        }'),
                        'escapeMarkup' => new JsExpression('function(m) { return m; }'),
                    ],
                ]),
            ],
            [
                'attribute' => 'price',
                'label' => 'Price (Zeny)',
                'value' => function($model){
                    return number_format($model->price);
                },
               'headerOptions' => [
                    'class' => 'col-md-2'
                ],
            ],
            [
                'attribute' => 'shop.character',
                'label' => 'Owner',
                'value' => function($model){
                    return '<div style="
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            max-width: 100px;" title="'. $model->shop->character .'">'. $model->shop->character. '</div>';
                },
                'format' => 'raw',
                'headerOptions' => [
                    'class' => 'col-md-1'
                ],
            ],
            [
                'attribute' => 'shop.shop_name',
                'label' => 'Shop',
                'value' => function($model){
                    return '<div style="
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            max-width: 100px;" title="'. $model->shop->shop_name .'">'. $model->shop->shop_name. '</div>';
                },
                'format' => 'raw',
                'headerOptions' => [
                    'class' => 'col-md-1',
                ],
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Latest',
                'format' => ['date', 'php:d M Y H:i:s'],
                'filter' => false,
                'headerOptions' => [
                    'class' => 'col-md-1'
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
