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
    public $clasificacion_tienda; // Clasificación de la tienda asociada
    public $denuncias; // Atributo virtual para denuncias de la tienda

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion'], 'string'],
            [['categoria_id', 'etiqueta_id', 'clasificacion_tienda', 'denuncias', 'id'], 'integer'], // Asegúrate de incluir el id
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
        $query = Articulo::find()
            ->alias('a') // Alias para la tabla artículos
            ->joinWith(['tienda t']); // Alias para la tabla tiendas

        // Crear el DataProvider
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Si la validación falla, no retorna resultados
            $query->where('0=1');
            return $dataProvider;
        }

        // Filtros para las columnas de la tabla "articulos"
        $query->andFilterWhere([
            'a.id' => $this->id, // Filtro por id
            'a.categoria_id' => $this->categoria_id,
            'a.etiqueta_id' => $this->etiqueta_id,
        ]);

        // Filtros para las columnas de la tabla "tiendas" (usando alias "t")
        $query->andFilterWhere(['t.clasificacion_id' => $this->clasificacion_tienda]);

        // Filtros para las columnas con búsqueda de texto
        $query->andFilterWhere(['like', 'a.nombre', $this->nombre])
            ->andFilterWhere(['like', 'a.descripcion', $this->descripcion]);

        // Filtro para las denuncias de la tienda asociada
        $query->andFilterWhere(['t.denuncias' => $this->denuncias]);

        return $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'categoria_id' => 'Categoría',
            'etiqueta_id' => 'Etiqueta',
            'clasificacion_tienda' => 'Clasificación de la Tienda',
            'denuncias' => 'Denuncias de la Tienda', // Etiqueta para el campo de denuncias
            'id' => 'ID', // Asegúrate de que el id tenga una etiqueta en el modelo
        ];
    }
}
