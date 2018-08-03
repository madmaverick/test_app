<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name
 * @property string $default_price
 * @property int created_at
 * @property int updated_at
 *
 * @property Periods[] $periods
 */
class Goods extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 300],
            [['default_price', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function behaviors(){
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID Товара',
            'name' => 'Название товара',
            'default_price' => 'Цена по умолчанию',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Prices::className(), ['goods_id' => 'id']);
    }

    /**
     * Find prices by date and get length periods
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param string $date
     * @return mixed
     */
    private function findPriceByDate($date){
        $date = $date ? strtotime($date) : null;
        $query = Prices::find();
        $query->filterWhere(['goods_id' => $this->id])
            ->andFilterWhere(['<=', 'start_date', $date])
            ->andFilterWhere(['or',['>=', 'end_date', $date],['end_date'=>0]]);
        $prices = $query->asArray(true)->all();

        if(!$prices){
            return false;
        }

        foreach($prices as $i => $price){
                $arrPrices['length_period_prices'][$i] = abs($price['start_date'] - ($price['end_date'] ? $price['end_date'] : $date))/60/60/24;
                $prices[$i]['days'] = $arrPrices['length_period_prices'][$i];
                $arrPrices['start_date_prices'][$i] = $price['start_date'];
        }
        $arrPrices['prices'] = $prices;
        return $arrPrices;
    }

    /**
     * Get price by 2 approaches
     * first approach get a shorter period price
     * second approach get a period price with later start date
     * @param string $date
     * @param integer $approach
     * @return mixed
     */
    public function getPriceByDate($date, $approach){
        $prices = $this->findPriceByDate($date);

        if(!$prices){
            return false;
        }

        switch($approach){
            case 1: array_multisort($prices['length_period_prices'], SORT_ASC, $prices['start_date_prices'], SORT_DESC, $prices['prices']);
                break;
            case 2: array_multisort($prices['start_date_prices'], SORT_DESC, $prices['length_period_prices'], SORT_ASC, $prices['prices']);
                break;
            default: array_multisort($prices['length_period_prices'], SORT_ASC, $prices['start_date_prices'], SORT_DESC, $prices['prices']);
        }

        $resultPrice = $prices['prices'][0];
        return $resultPrice['price'];
    }

    /**
     * Get schedule of change prices by 2 approaches
     * first approach get a shorter period price
     * second approach get a period price with later start date
     * @param integer $approach
     * @return array
     */
    public function getScheduleOfChangePrice($approach){
        $prices = $this->getPrices()->asArray(true)->all();

        if(!$prices){
            //if goods doesn't have prices yet return default price
            return [['date' => date('d.m.Y', $this->created_at),'price' => $this->default_price]];
        }

        for($i=0,$j=0; $i < count($prices); $i++,$j++){
            $dates[$j] = $prices[$i]['start_date'];
            if($prices[$i]['end_date'] > 0){
                $j++;
                //get next day after end period
                $dates[$j] = $prices[$i]['end_date'] + 60*60*24;
            }
        }

        //get unique dates array and sort it
        $dates = array_unique($dates);
        sort($dates);

        //get schedule
        $scheduleOfChangePrices = [];
        for($i=0,$j=0; $i < count($dates); $i++){
            $dates[$i] = date('d.m.Y', $dates[$i]);
            $price = $this->getPriceByDate($dates[$i], $approach);
            $price = $price ? $price : $this->default_price;
            if($i == 0 || $i > 0 && $price != $scheduleOfChangePrices[$j-1]['price']){
                $scheduleOfChangePrices[$j]['date'] = $dates[$i];
                $scheduleOfChangePrices[$j]['price'] = $price;
                $j++;
            }
        }

        return $scheduleOfChangePrices;
    }

}
