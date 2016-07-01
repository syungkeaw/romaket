<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\classes\RoHelper;
use common\models\Shop;
use kartik\dropdown\DropdownX;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJs("
$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
", View::POS_READY);


$maps = [
    1 => [
        'id' => '1',
        'name' => 'Morroc',
        'map' => 'morroc.jpg',
    ],
    2 => [
        'id' => '2',
        'name' => 'Prontera',
        'map' => 'prontera.jpg',
    ], 
];

$this->title = 'Shops';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="shop-index">
  <div class="row">  
        <div class="col-md-6">
            <p>
                <?= Html::a('Create Shop', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-md-6 text-right">
            <?= Html::a('<span class="glyphicon glyphicon-list-alt"></span> Table View', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>


    <div class="row">
        <?php foreach ($dataProvider->getModels() as $model) { ?>
                        
                        <div class="col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title ellipsis" style="max-width: 250px !important;">
                                        <?= '#'. $model->id ?> <?= $model->shop_name ?> <small><?= $maps[$model->map]['name'] ?> (<?= $model->location ?>)</small></h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <thead><tr><th>Items</th><th class="text-right">Price</th><th></th></tr></thead>
                                        <tbody>
                                        <?php foreach (range(0, 11) as $slot) { 
                                                $item_img = Yii::getAlias('@web'). '/images/item_slot.jpg';
                                                $item_name = '';
                                                $item_price = 0;
                                                if(isset($model->shopItems[$slot])){
                                                    $item_img = Yii::getAlias('@web'). '/images/items/small/' . $model->shopItems[$slot]->item->source_id .'.gif';
                                                    $item_name .= ($model->shopItems[$slot]->enhancement ? '+'. $model->shopItems[$slot]->enhancement  : '') .' ';
                                                    $item_name .= $model->shopItems[$slot]->item->nameSlot;
                                                    $item_price = number_format($model->shopItems[$slot]->price);
                                                }
                                        ?>
                                            <tr style="height:42px">
                                                <td><div class="ellipsis"><small><?= Html::img($item_img) .' '. $item_name ?></small></div></td>
                                                <td class="text-right"><small><?= $item_name ? $item_price. ' zeny' : '' ?></small></td>
                                                <td class="text-right">
                                                    <?php if(!empty($item_name)){ ?>
                                                    <div class="dropdown">
                                                    <?= Html::a('<span class="glyphicon glyphicon-option-horizontal"></span>', [''], ['data-toggle'=>'dropdown']) ?>
                                                    <?= DropdownX::widget([
                                                        'items' => [
                                                            ['label' => '100 reports'],
                                                            '<li class="divider"></li>',
                                                            ['label' => 'Open', 'url' => '#'],
                                                            ['label' => 'Close', 'url' => '#'],
                                                        ],
                                                    ]) ?>
                                                    </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']) ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-ban-circle"></span> Close', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-xs']) ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
    </div>
</div>