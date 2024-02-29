<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $title
 * @property string $SKU
 * @property int $shippedQty
 * @property int $receivedQty
 * @property float $price
 * @property int $box_id
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'SKU', 'price'], 'required'],
            [['shippedQty', 'receivedQty', 'box_id'], 'integer'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'SKU'], 'string', 'max' => 255],
            [['SKU'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'SKU' => 'Sku',
            'shippedQty' => 'Shipped Qty',
            'receivedQty' => 'Received Qty',
            'price' => 'Price',
            'box_id' => 'Box ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
