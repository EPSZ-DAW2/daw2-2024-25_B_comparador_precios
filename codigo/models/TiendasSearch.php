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
            [['id', 'region_id', 'clasificacion_id', 'etiquetas_id', 'suma_valoraciones', 'suma_votos', 'visible', 'cerrada', 'denuncias', 'bloqueada', 'comentarios_id', 'cerrado_comentar', 'propietario_usuario_id', 'seguimiento_id', 'registro_id', 'articulo_tienda_id'], 'integer'],
            [['nombre', 'descripcion', 'lugar', 'url', 'direccion', 'telefono', 'imagen_principal', 'fecha_primera_denuncia', 'motivo_denuncia', 'fecha_bloqueo', 'motivo_bloqueo'], 'safe'],
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
            'region_id' => $this->region_id,
            'clasificacion_id' => $this->clasificacion_id,
            'etiquetas_id' => $this->etiquetas_id,
            'suma_valoraciones' => $this->suma_valoraciones,
            'suma_votos' => $this->suma_votos,
            'visible' => $this->visible,
            'cerrada' => $this->cerrada,
            'denuncias' => $this->denuncias,
            'fecha_primera_denuncia' => $this->fecha_primera_denuncia,
            'bloqueada' => $this->bloqueada,
            'fecha_bloqueo' => $this->fecha_bloqueo,
            'comentarios_id' => $this->comentarios_id,
            'cerrado_comentar' => $this->cerrado_comentar,
            'propietario_usuario_id' => $this->propietario_usuario_id,
            'seguimiento_id' => $this->seguimiento_id,
            'registro_id' => $this->registro_id,
            'articulo_tienda_id' => $this->articulo_tienda_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'lugar', $this->lugar])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'imagen_principal', $this->imagen_principal])
            ->andFilterWhere(['like', 'motivo_denuncia', $this->motivo_denuncia])
            ->andFilterWhere(['like', 'motivo_bloqueo', $this->motivo_bloqueo]);

        return $dataProvider;
    }
}
