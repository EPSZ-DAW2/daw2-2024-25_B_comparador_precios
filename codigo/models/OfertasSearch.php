<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ofertas;

/**
 * OfertasSearch represents the model behind the search form of `app\models\Ofertas`.
 */
class OfertasSearch extends Ofertas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'articulo_id', 'tienda_id', 'registro_id'], 'integer'],
            [['fecha_inicio', 'fecha_fin', 'notas'], 'safe'],
            [['precio_oferta', 'precio_og'], 'number'],
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
        $query = Ofertas::find();

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
            'articulo_id' => $this->articulo_id,
            'tienda_id' => $this->tienda_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'precio_oferta' => $this->precio_oferta,
            'precio_og' => $this->precio_og,
            'registro_id' => $this->registro_id,
        ]);

        $query->andFilterWhere(['like', 'notas', $this->notas]);

        return $dataProvider;
    }
}
