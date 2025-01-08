<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArticulosTienda;

/**
 * ArticulosTiendaSearch represents the model behind the search form of `app\models\ArticulosTienda`.
 */
class ArticulosTiendaSearch extends ArticulosTienda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'articulo_id', 'tienda_id', 'historico_id', 'oferta_id', 'suma_valoraciones', 'suma_votos', 'visible', 'cerrado', 'denuncias', 'bloqueado', 'cerrado_comentar', 'registro_id', 'comentario_id'], 'integer'],
            [['precio_actual'], 'number'],
            [['fecha_primera_denuncia', 'motivo_denuncia', 'fecha_bloqueo', 'motivo_bloqueo'], 'safe'],
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
        $query = ArticulosTienda::find();

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
            'precio_actual' => $this->precio_actual,
            'historico_id' => $this->historico_id,
            'oferta_id' => $this->oferta_id,
            'suma_valoraciones' => $this->suma_valoraciones,
            'suma_votos' => $this->suma_votos,
            'visible' => $this->visible,
            'cerrado' => $this->cerrado,
            'denuncias' => $this->denuncias,
            'fecha_primera_denuncia' => $this->fecha_primera_denuncia,
            'bloqueado' => $this->bloqueado,
            'fecha_bloqueo' => $this->fecha_bloqueo,
            'cerrado_comentar' => $this->cerrado_comentar,
            'registro_id' => $this->registro_id,
            'comentario_id' => $this->comentario_id,
        ]);

        $query->andFilterWhere(['like', 'motivo_denuncia', $this->motivo_denuncia])
            ->andFilterWhere(['like', 'motivo_bloqueo', $this->motivo_bloqueo]);

        return $dataProvider;
    }
}
