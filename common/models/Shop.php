<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%shop}}".
 *
 * @property integer $id
 * @property string $shop_name
 * @property integer $map
 * @property string $location
 * @property string $character
 * @property integer $not_found_count
 * @property integer $status
 * @property integer $server
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 */
class Shop extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;   

    public static $server = [
        1 => 'Eden',
        // 2 => 'Thor',
        // 3 => 'Loki',
    ];

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }   

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_name', 'map'], 'required'],
            [['not_found_count', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at', 'server'], 'integer'],
            [['shop_name', 'location', 'character', 'map'], 'string', 'max' => 50],
            [['information'], 'string', 'max' => 255],
            ['not_found_count', 'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            // ['location', 'required', 'message' => 'Location cannot be blank. Please click position in the map below.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_name' => 'Shop Name',
            'map' => 'Map',
            'location' => 'Location',
            'character' => 'Character',
            'not_found_count' => 'Not Found Count',
            'status' => 'Status',
            'server' => 'Server',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'information' => 'Information',
        ];
    }

    public function getShopItems()
    {
        return $this->hasMany(ShopItem::className(), [
            'shop_id' => 'id'
        ]);
    }

    public function getItems()
    {
        return $this->hasMany(Item::className(), [
            'source_id' => 'item_id'
        ])->via('shopItems');
    }
}
