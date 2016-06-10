<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use frontend\assets\Select23Asset;

Select23Asset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Shop */
/* @var $form yii\widgets\ActiveForm */

$maps = [
    [
        'id' => '1',
        'name' => 'Morroc',
        'map' => 'morroc.jpg',
    ],
    [
        'id' => '2',
        'name' => 'Prontera',
        'map' => 'prontera.jpg',
    ], 
];

$datax = '';

// echo '<pre>', print_r(ArrayHelper::map($item_model, 'source_id', 'item_name')); die;
foreach(ArrayHelper::map($item_model, 'source_id', 'nameSlot') as $k => $x){
    $datax .= '{
              id: "'.$k.'",
              text: "'.$x.'"
            },';
}

$this->registerJs("
    $('#shop-map').change(function(){
        var map = $('.map-picker>img');
        map.attr('src', map.attr('src').replace(/map-[\d]/, 'map-' + $(this).val()));
        $('div.dot').remove();
        $('#shop-location').val('');
    });

    var size = 8;
    var origin = $('.map-picker').offset();
    $('.map-picker').click(function(e){
        $('div.dot').remove();
        $('body').append(
            $('<div class=\"dot\"></div>').css({
                position: 'absolute',
                top: (e.pageY-size/2) + 'px',
                left: (e.pageX-size/2) + 'px',
                width: size + 'px',
                height: size + 'px',
                background: 'red'
            })
        );

        var x = e.pageX - origin.left;
        var y = e.pageY - origin.top;

        $('#shop-location').val(x + ',' + y);

    });

    if($('#shop-location').val() !== ''){
        axis = $('#shop-location').val().split(',');
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

    var datax = [".$datax."];
    $('.select2ex').select2({
        data: datax,
        formatLoadMore   : 'Loading more...',
        formatResult: repoFormatResult,
        formatSelection: repoFormatSelection,
        escapeMarkup: function (m) { return m; },
        dropdownCssClass: 'bigdrop',
        query            : function (q) {
            var pageSize,
                results;
                pageSize = 20;
                results  = _.filter(this.data, function (e) {
                    var searchText = q.term;
                    if(searchText !== undefined){
                        searchText = searchText.toLowerCase();
                    }
                    return (searchText === '' || e.text.toLowerCase().indexOf(searchText) >= 0);
                });
            q.callback({
                results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
                more   : results.length >= q.page * pageSize
            });
        }
    });

    $('input.select2ex').filter(function() { return $(this).val(); }).each(function(){
        var default_value = $(this).val();
        var item = _.filter(datax, function (e) { return e.id == default_value; });
        $(this).parent().find('.select2-chosen').html(getSelectTemplate(item[0]));
    });

   function repoFormatResult(item) {
        return getSelectTemplate(item);
   }

   function repoFormatSelection(item) {
        return getSelectTemplate(item);
   }

   function getSelectTemplate(item) {
        var card = 'card';
        var item_img = item.text.toLowerCase().indexOf(card) > -1 ? card : item.id;
        return '<div class=\"span2\"><img src=\"http://imgs.ratemyserver.net/items/small/' + item_img + '.gif\" /> '+ item.text +'</div>';
   }

", View::POS_READY);

$this->registerCss("
.map-picker {
    height: 300px;
    width: 300px;
}
.map-picker>img {
    height: 100%;
    width: 100%;
}

.bigdrop.select2-container .select2-results {max-height: 300px;}
");
?>

<div class="shop-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($shop_model, 'shop_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($shop_model, 'character')->textInput(['maxlength' => true]) ?>
            <?= $form->field($shop_model, 'map')->dropDownList(ArrayHelper::map($maps, 'id', 'name')) ?>
            <?= $form->field($shop_model, 'location')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
        <div class="col-md-6 text-center">
            <div class="map-picker">
            <?= Html::img(Yii::$app->params['map_path'].'map-1x.jpg') ?>
            </div>
        </div>
    </div>

    <div class="row item">
        <div class="col-sm-6">Item Name</div>
        <div class="col-sm-3">Amount</div>
        <div class="col-sm-3">Price</div>
    </div>

    <?php
    $shop_item_model = is_array($shop_item_model) ? $shop_item_model : [$shop_item_model];
    for($slot = 0; $slot <= 11; $slot++){
    ?>
        <div class="row item">
            <div class="col-sm-6"> 
                <?= $form->field($shop_item_model[$slot], "[$slot]item_id")->hiddenInput(['class'=> 'select2ex', 'style' => 'width: 100%;'])->label(false) ?> 
            </div>
            <div class="col-sm-3"> <?= $form->field($shop_item_model[$slot], "[$slot]amount")->textInput()->label(false) ?> </div>
            <div class="col-sm-3"> <?= $form->field($shop_item_model[$slot], "[$slot]price")->textInput()->label(false) ?> </div>
        </div>
    <?php } ?>
    
    <div class="form-group">
        <?= Html::submitButton($shop_model->isNewRecord ? 'Open Shop' : 'Update', ['class' => $shop_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

