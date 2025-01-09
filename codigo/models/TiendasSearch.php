<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tienda;

/**
 * TiendasSearch represents the model behind the search form of `app\models\Tienda`.
 */
class TiendasSearch extends Tienda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'lugar'], 'string'],
            [['clasificacion_id', 'etiquetas_id'], 'integer'],
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
        $query = Tienda::find();

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
            'clasificacion_id' => $this->clasificacion_id,
            'etiquetas_id' => $this->etiquetas_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
              ->andFilterWhere(['like', 'lugar', $this->lugar]);

        return $dataProvider;
    }
	
	public function attributeLabels()
{
    return [
        'clasificacion_id' => 'Clasificación',
        'etiquetas_id' => 'Etiqueta',
    ];
}

	
}
