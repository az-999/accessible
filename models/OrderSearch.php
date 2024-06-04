<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    public $statusName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'count', 'id_user', 'id_status'], 'integer'],
            [['name_client', 'timestamp', 'desmiss','statusName'], 'safe'],
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
        $query = Order::find();
        $query->joinWith(['status']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'timestamp' => $this->timestamp,
            'count' => $this->count,
            'id_user' => $this->id_user,
            'id_status' => $this->id_status,
        ]);

        $query->andFilterWhere(['like', 'name_client', $this->name_client])
            ->andFilterWhere(['like', 'desmiss', $this->desmiss]) 
            ->andFilterWhere(['like', 'status.name', $this->statusName]);

        return $dataProvider;
    }
    public function searchForUser($params,$id)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['id_user'=>$id]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'timestamp' => $this->timestamp,
            'count' => $this->count,
            //'id_user' => $this->id_user,
            'id_status' => $this->id_status,
        ]);

        $query->andFilterWhere(['like', 'name_client', $this->name_client])
            ->andFilterWhere(['like', 'desmiss', $this->desmiss]);

        $query->orderBy(['timestamp'=>SORT_DESC]);

        return $dataProvider;
    }
}
