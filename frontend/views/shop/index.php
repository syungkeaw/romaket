<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\classes\ItemHelper;
use common\classes\RoHelper;
use kartik\typeahead\Typeahead;
use yii\helpers\ArrayHelper;
use yii\web\View;
use common\models\Item;
use common\models\Shop;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\dropdown\DropdownX;

$this->title = 'Shops';
$this->params['breadcrumbs'][] = $this->title;

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

<p>
    <?= Html::a('Create Shop', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'item.item_name',
                'label' => 'Items',
                'value' => function($model){
                    $item = Html::img(Yii::getAlias('@web'). '/images/items/small/'.
                        ItemHelper::getImgFileName($model->item)) .' '.
                        $model->item['nameSlot'];
                    return $item;
                },
                'format' => 'raw',
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
                'label' => 'Enhanced',
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
                        $option .= $model->{'card_'.$slot} ? '['. Html::img(Yii::getAlias('@web'). '/images/items/small/'. 'card.gif') . $model->{'itemCard'.$slot}['item_name'] . ']<br>' : '';
                    }

                    $option .= $model->very ? ' '. $very[$model->very] : '';
                    $option .= $model->element ? 
                        Html::img(Yii::getAlias('@web'). '/images/items/small/'. $label[$model->element]['icon']. '.gif').
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
                            return \'<img src="'. Yii::getAlias('@web'). '/images/items/small/' .'\' + (item.text.toLowerCase().indexOf(\'card\') > -1 ? \'card\' : item.id) + \'.gif"/> \' + item.text;
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
                'attribute' => 'shop.shop_name',
                'label' => 'Shop',
                'value' => function($model){
                    return '<div class="ellipsis" title="'. $model->shop->shop_name .'">'. $model->shop->shop_name. '</div>';
                },
                'format' => 'raw',
                'headerOptions' => [
                    'class' => 'col-md-1',
                ],
            ],
            [
                'attribute' => 'shop.server',
                'filter' => Html::dropDownList('ShopItemSearch[shop.server]', $searchModel['shop.server'], ['' => 'All Server'] + Shop::$server, 
                ['class' => 'form-control']),
                'value' => function($model){
                    return Shop::$server[$model->shop['server']];
                },
                'headerOptions' => [
                    'class' => 'col-md-1',
                ],
            ],
            [
                'value' => function($model){
                    $menu = Html::beginTag('div', ['class'=>'dropdown']);
                    $menu .= Html::a('<span class="glyphicon glyphicon-option-horizontal"></span>', [''], ['data-toggle'=>'dropdown']);
                    $menu .= DropdownX::widget([
                        'items' => [
                            ['label' => 'Edit Shop', 'url' => ['update', 'id' => $model->shop['id']]],
                            ['label' => 'Close Shop', 'url' => '#'],
                            ['label' => 'Delete Shop', 'url' => '#'],
                            '<li class="divider"></li>',
                            ['label' => 'Close Item', 'url' => '#'],
                        ],
                    ]); 
                    $menu .= Html::endTag('div');
                    return $menu;
                },
                'format' => 'raw',
                'headerOptions' => [
                    'class' => 'col-md-1'
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>


