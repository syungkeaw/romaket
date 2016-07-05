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
use kartik\icons\Icon;

Icon::map($this);  

$this->title = 'My Shop';
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
<div class="row">  
    <div class="col-md-6">
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Create Shop', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
    <div class="col-md-6 text-right">
        <?= Html::a('<span class="glyphicon glyphicon-shopping-cart"></span> Cart View', ['cart'], ['class' => 'btn btn-default']) ?>
    </div>
</div>


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
            ],
            [
                'attribute' => 'enhancement',
                'label' => 'Enhanced',
                'value' => function($model){
                    return $model->enhancement ? '+'.$model->enhancement : '';
                },
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
            ],
            [
                'attribute' => 'shop.shop_name',
                'label' => 'Shop',
                // 'filter' => Html::dropDownList(
                //     'ShopItemSearch[shop.shop_name]', 
                //     $searchModel['shop.shop_name'], 
                //     ['' => 'All'] + ArrayHelper::map(Shop::findAll(['created_by' => Yii::$app->user->identity->id]), 'shop_name', 'shop_name'), 
                //     ['class' => 'form-control']
                // ),
                'value' => function($model){
                    return '<div class="ellipsis" title="'. $model->shop->shop_name .'">'. $model->shop->shop_name. '</div>';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'price',
                'label' => 'Price (Zeny)',
                'value' => function($model){
                    return number_format($model->price);
                },
            ],  
            [
                'attribute' => 'shop.server',
                'filter' => Html::dropDownList('ShopItemSearch[shop.server]', $searchModel['shop.server'], ['' => 'All Server'] + Shop::$server, 
                ['class' => 'form-control']),
                'value' => function($model){
                    return Shop::$server[$model->shop['server']];
                },
            ],
            [
                'value' => function($model){
                    return $model->shop['status'] == 10 && $model['status'] == 10 ? 
                        '<span class="glyphicon glyphicon-ok text-green"></span>' : 
                        '<span class="glyphicon glyphicon-remove text-red"></span>';
                },
                'filter' => Html::dropDownList('ShopItemSearch[shop.status]', $searchModel['shop.status'], ['' => 'All','10' => 'O', '0' => 'C'], 
                ['class' => 'form-control']),
                'format' => 'raw',
            ],
            [
                'value' => function($model){
                    return Icon::show('thumbs-up'). ' '. $model->like. ' '. Icon::show('thumbs-down') .' ' .$model->report;
                },
                'format' => 'raw',
            ],
            [
                'value' => function($model){
                    $menu = Html::beginTag('div', ['class'=>'dropdown']);
                    $menu .= Html::a('<span class="glyphicon glyphicon-option-horizontal"></span>', [''], ['data-toggle'=>'dropdown']);
                    $menu .= DropdownX::widget([
                        'items' => [
                            ['label' => 'Edit Shop', 'url' => ['update', 'id' => $model->shop['id']]],
                            ($model->shop['status'] == 10 ? 
                                ['label' => 'Close Shop', 'url' => ['close', 'id' => $model->shop['id']]] :
                                ['label' => 'Open Shop', 'url' => ['open', 'id' => $model->shop['id']]])
                            ,
                            // ['label' => 'Delete Shop', 'url' => ['delete', 'id' => $model->shop['id']]],
                            '<li class="divider"></li>',
                            ($model['status'] == 10 ? 
                                ['label' => 'Close Item', 'url' => ['shop-item/close', 'id' => $model['id']]] :
                                ['label' => 'Open Item', 'url' => ['shop-item/open', 'id' => $model['id']]])
                        ],
                    ]); 
                    $menu .= Html::endTag('div');
                    return $menu;
                },
                'format' => 'raw',
                'headerOptions' => [
                    'style' => 'width:30px'
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>


