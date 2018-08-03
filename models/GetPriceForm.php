<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 03.08.2018
 * Time: 17:37
 */

namespace app\models;

use Yii;
use yii\base\Model;

class GetPriceForm extends Model
{
    public $goods_id;
    public $approach;
    public $date;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['goods_id', 'approach', 'date'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'approach' => 'Метод',
            'date' => 'Дата',
        ];
    }


}