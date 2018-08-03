<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prices;

/**
 * PricesSearch represents the model behind the search form of `app\models\Prices`.
 */
class PricesSearch extends Prices
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'goods_id', 'price', 'start_date', 'end_date'], 'integer'],
            [['str_start_date', 'str_end_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param int $goods_id
     *
     * @return ActiveDataProvider
     */
    public function search($params, $goods_id)
    {
        $query = Prices::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'goods_id' => $goods_id,
            'price' => $this->price,
        ]);
        $query->andFilterWhere(['>=', 'start_date', $this->str_start_date ? strtotime($this->str_start_date) : null])
            ->andFilterWhere(['<=', 'end_date', $this->str_end_date ? strtotime($this->str_end_date) : null]);

        return $dataProvider;
    }
}
