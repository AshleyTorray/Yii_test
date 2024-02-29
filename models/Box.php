<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "box".
 *
 * @property int $id
 * @property float $weight
 * @property float $width
 * @property float $length
 * @property float $height
 * @property string $reference
 * @property int $status
 
 */
class Box extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const STATUS_PREPARED = 0;
    const STATUS_SHIPPED = 1;
    const STATUS_AT_WAREHOUSE = 2; 
    const STATUS_EXPECTED = 3;
    const STATUS_RECEIVED = 4;
    public static function tableName()
    {
        return 'box';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['weight', 'width', 'length', 'height', 'reference'], 'required'],
            [['weight', 'width', 'length', 'height'], 'number'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['reference'], 'string', 'max' => 255],
            [['reference'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'weight' => 'Weight',
            'width' => 'Width',
            'length' => 'Length',
            'height' => 'Height',
            'reference' => 'Reference',
            'status' => 'Status',
            'created_at' => 'Date',
            'updated_at' => 'Updated At',
        ];
    }
    public static function getStatusOptions()
    {
        return [
            self::STATUS_PREPARED => 'Prepared',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_AT_WAREHOUSE => 'At Warehouse',
            self::STATUS_EXPECTED => 'Expected',
            self::STATUS_RECEIVED => 'Received',
        ];
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['box_id' => 'id']);
    }

    // public function beforeSave($insert){
    //     if(parent::beforeSave($insert))
    //     {
    //         if($this->status !== self::STATUS_PREPARED)
    //         {
    //             $this->weight = $this->calculateWeight();
    //         }
    //         return true;
    //     }
    //     return false;
    // }

    // public function afterSave($insert, $changedAttributes)
    // {
    //     parent::afterSave($insert, $changedAttributes);

    //     $this->updateTotalAmountAndMismatchStatus();
    // }

    // protected function calculateWeight()
    // {
    //     return $this->length * $this->width * $this->height;
    // }

    // protected function updateTotalAmountAndMismatchStatus()
    // {
    //     $this->total_amount = $this->calculateTotalAmount();
    //     $this->has_mismatch = ($this->shipped_qty !== $this->received_qty);
    //     $this->save(false);
    // }

    // protected function calculateTotalAmount()
    // {
    //     return 0;
    // }

}
