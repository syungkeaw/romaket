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
use yii\helpers\Url;
use kartik\icons\Icon;

Icon::map($this);  

/* @var $this yii\web\View */
/* @var $searchModel common\models\ShopItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ro108 ซื้อขาย item';
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
    function popupwindow(url, title, w, h) {
        wLeft = window.screenLeft ? window.screenLeft : window.screenX;
        wTop = window.screenTop ? window.screenTop : window.screenY;

        var left = wLeft + (window.innerWidth / 2) - (w / 2);
        var top = wTop + (window.innerHeight / 2) - (h / 2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }
", View::POS_HEAD);

$this->registerJs("
    $(document).on('pjax:send', function() {
        $('#loading').show();
    });
    $(document).on('pjax:complete', function() {
      $('#loading').hide();
    });
", View::POS_READY);

$this->registerCss("
    #loading{
        position: fixed;
        left: 50%;
        top: 50%;
        background-color: white;
        z-index: 100;
        display:none;
    }
");


echo Html::a(Icon::show('shopping-cart'). 'My Shop', [Yii::$app->request->get('server').'/shop'], ['class' => 'btn btn-success']);
?>
<div id="loading"><img src="../images/loading.gif" /></div>
<div class="shop-item-index">
<?php Pjax::begin(); ?>
<h3><?= $server ?> <small><?= Html::a('<span class="glyphicon glyphicon-refresh"></span> Clear', ['']) ?></small></h3>

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
                        Html::a($model->item['nameSlot'], '#', [
                            'class' => 'modalButton',
                            'data-toggle' => 'modal',
                            'data-target' => '#detailModal',
                            'onClick' => '$("#detailModal iframe").attr("src", "'. Url::to(['market/detail', 'id' => $model->id]) .'");',
                        ]);
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
                'attribute' => 'shop.character',
                'label' => 'Owner',
                'value' => function($model){
                    return '<div class="ellipsis" title="'. $model->shop->character .'">'. $model->shop->character. '</div>';
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
                    return '<div class="ellipsis" title="'. $model->shop->shop_name .'">'. $model->shop->shop_name. '</div>';
                },
                'format' => 'raw',
                'headerOptions' => [
                    'class' => 'col-md-1',
                ],
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Latest',
                'format' => ['date', 'php:d-H:i'],
                'filter' => false,
                'headerOptions' => [
                    'class' => 'col-md-1'
                ],
            ],
            [
                'value' => function($model){
                    if(Yii::$app->user->isGuest) return '';

                    $menu = Html::beginTag('div', ['class'=>'dropdown']);
                    $menu .= Html::a('<span class="glyphicon glyphicon-option-horizontal"></span>', [''], ['data-toggle'=>'dropdown']);
                    $menu .= DropdownX::widget([
                        'items' => [
                            ['label' => Icon::show('thumbs-down'). 'Report', 'url' => ['feedback', 'id' => $model->id, 'feedback_id' => 1]],
                            ['label' => Icon::show('thumbs-up'). 'Like', 'url' => ['feedback', 'id' => $model->id, 'feedback_id' => 2]],
                            // '<li class="divider"></li>',
                        ],
                        'encodeLabels' => false,
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
<script type="text/javascript">
    function iframeLoaded() {
        var iFrameID = document.getElementById('iframeDetail');
        if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            iFrameID.height = "";
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
        }   
    }
</script>   
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel">
  <div class="modal-dialog" role="document" style="width:50%;min-width: 750px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <iframe id="iframeDetail" frameborder="0" style="width:100%;" onload="iframeLoaded()"></iframe>
        </div>
    </div>
  </div>
</div>


