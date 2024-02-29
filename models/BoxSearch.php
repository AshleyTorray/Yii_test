<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Box;

/**
 * BoxSearch represents the model behind the search form of `app\models\Box`.
 */
class BoxSearch extends Box
{
    /**
     * {@inheritdoc}
     */
    public $date_from;
    public $date_to;
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['weight', 'width', 'length', 'height'], 'number'],
            [['reference', 'created_at', 'updated_at'], 'safe'],
            [['from_date', 'to_date'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Box::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            if (!empty($this->date_from)) {
                $query->andWhere(['>=', 'created_at', $this->date_from]);
            }
            if (!empty($this->date_to)) {
                $to_date = new \DateTime($this->date_to);
                $to_date->setTime(23, 59, 59);
    
                $query->andWhere(['<=', 'created_at', $to_date->format('Y-m-d H:i:s')]);
            }
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'weight' => $this->weight,
            'width' => $this->width,
            'length' => $this->length,
            'height' => $this->height,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'reference', $this->reference]);
        $query->andFilterWhere(['>=', 'created_at', $this->date_from])
            ->andFilterWhere(['<=', 'created_at', $this->date_to]);

        return $dataProvider;
    }
}
