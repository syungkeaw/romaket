<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%shop_item}}".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $shop_id
 * @property integer $price
 * @property integer $amount
 * @property integer $created_at
 * @property integer $updated_at
 */
class ShopItem extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;   

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }   

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['shop_id'], 'required'],
            [['item_id', 'shop_id', 'price', 'amount', 'created_at', 'updated_at', 'card_1', 'card_2', 'card_3', 'card_4', 'very', 'element', 'enhancement'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['item_id', function ($attribute, $params) {
                if(!(empty($this->item_id) & empty($this->price) & empty($this->amount))){
                    if(empty($this->item_id)){
                        $this->addError('item_id', 'item is required.');
                    }                    

                    if(empty($this->price)){
                        $this->addError('price', 'price is required.');
                    }                    

                    if(empty($this->amount)){
                        $this->addError('amount', 'amount is required.');
                    }
                }
            }, 'skipOnEmpty'=> false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'shop_id' => 'Shop ID',
            'price' => 'Price',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), [
            'source_id' => 'item_id'
        ]);
    }

    public function getItemCard1()
    {
        return $this->hasOne(Item::className(), ['source_id' => 'card_1']);
    }

    public function getItemCard2()
    {
        return $this->hasOne(Item::className(), ['source_id' => 'card_2']);
    } 

    public function getItemCard3()
    {
        return $this->hasOne(Item::className(), ['source_id' => 'card_3']);
    }    

    public function getItemCard4()
    {
        return $this->hasOne(Item::className(), ['source_id' => 'card_4']);
    }

    public function getShop()
    {
        return $this->hasOne(Shop::className(), [
            'id' => 'shop_id'
        ]);
    }
}
