<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Articulo;

/**
 * ArticulosSearch represents the model behind the search form of `app\models\Articulo`.
 */
class ArticulosSearch extends Articulo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'categoria_id', 'etiqueta_id', 'visible', 'cerrado', 'registro_id', 'articulo_tienda_id'], 'integer'],
            [['nombre', 'descripcion', 'imagen_principal', 'tipo_marcado'], 'safe'],
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
        $query = Articulo::find();

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
            'categoria_id' => $this->categoria_id,
            'etiqueta_id' => $this->etiqueta_id,
            'visible' => $this->visible,
            'cerrado' => $this->cerrado,
            'registro_id' => $this->registro_id,
            'articulo_tienda_id' => $this->articulo_tienda_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'imagen_principal', $this->imagen_principal])
            ->andFilterWhere(['like', 'tipo_marcado', $this->tipo_marcado]);

        return $dataProvider;
    }
}
