<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "prices".
 *
 * @property int $id
 * @property int $goods_id
 * @property int $price
 * @property int $start_date
 * @property int $end_date
 *
 * @property string $str_start_date
 * @property string $str_end_date
 *
 * @property Goods $goods
 */
class Prices extends ActiveRecord
{

    public $str_start_date;
    public $str_end_date;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prices';
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // get dates in Unix timestamps for saving
        $this->start_date = ($this->str_start_date) ? strtotime($this->str_start_date) : 0;
        $this->end_date = ($this->str_end_date) ? strtotime($this->str_end_date) : 0;

        return true;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->str_start_date = ($this->start_date) ? date('d.m.Y', $this->start_date) : '';
        $this->str_end_date = ($this->end_date) ? date('d.m.Y', $this->end_date) : '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goods_id', 'price', 'str_start_date'], 'required'],
            [['goods_id', 'price', 'start_date', 'end_date'], 'integer'],
            [['str_end_date'], 'safe'],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::className(), 'targetAttribute' => ['goods_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'ID Товара',
            'price' => 'Цена',
            'start_date' => 'Начало периода',
            'end_date' => 'Конец периода',
            'str_start_date' => 'Начало периода',
            'str_end_date' => 'Конец периода',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ['id' => 'goods_id']);
    }
}
