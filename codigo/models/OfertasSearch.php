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
	public $nombre_articulo;
	public $descripcion_articulo;
	public $categoria_id;
	public $etiqueta_id;
	public $clasificacion_tienda;
	public $region_id;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_articulo', 'descripcion_articulo'], 'string'],
            [['categoria_id', 'etiqueta_id', 'clasificacion_tienda', 'region_id'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe'], // Fechas
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
		$query = Ofertas::find()
            ->alias('o') // Alias para la tabla ofertas
			->joinWith([
				'articulo a',
				'articulo.etiquetas e',
				'articulo.categoria c',
				'tienda t',
				'tienda.clasificacion cl',
				'tienda.region r',
			]);
	
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
            'o.fecha_inicio' => $this->fecha_inicio,
            'o.fecha_fin' => $this->fecha_fin,
        ]);

        $query->andFilterWhere(['like', 'a.nombre', $this->nombre_articulo])
            ->andFilterWhere(['like', 'a.descripcion', $this->descripcion_articulo])
            ->andFilterWhere(['a.categoria_id' => $this->categoria_id]);

        $query->andFilterWhere(['e.id' => $this->etiqueta_id]);

        $query->andFilterWhere(['t.clasificacion_id' => $this->clasificacion_tienda])
            ->andFilterWhere(['r.id' => $this->region_id]);

        return $dataProvider;
    }
	
	public function attributeLabels()
    {
        return [
            'nombre_articulo' => 'Nombre del Artículo',
            'descripcion_articulo' => 'Descripción del Artículo',
            'categoria_id' => 'Categoría',
            'etiqueta_id' => 'Etiqueta',
            'clasificacion_tienda' => 'Clasificación de la Tienda',
            'region_id' => 'Región',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
        ];
    }

}
