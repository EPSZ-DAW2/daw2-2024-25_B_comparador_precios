<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tienda;

/**
 * TiendasSearch represents the model behind the search form of app\models\Tienda.
 */
class TiendasSearch extends Tienda
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nombre', 'lugar', 'descripcion', 'url', 'direccion', 'telefono', 'motivo_denuncia', 'motivo_bloqueo'], 'safe'], 
            [['clasificacion_id', 'etiquetas_id', 'suma_valoraciones', 'suma_votos', 'denuncias', 'visible', 'cerrada'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // Saltamos la implementación de escenarios del modelo base
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

        // Cargamos los parámetros de búsqueda
        $this->load($params);

        // Si no se valida, devolvemos todos los resultados
        if (!$this->validate()) {
            return new ActiveDataProvider([
                'query' => $query,
            ]);
        }

        // Si se proporcionó un `id` y es numérico, realizamos una búsqueda exacta
        if ($this->id) {
            $query->andFilterWhere(['id' => $this->id]);
        }

        // Configuración de las condiciones para otros filtros
        $query->andFilterWhere([
            'clasificacion_id' => $this->clasificacion_id,
            'etiquetas_id' => $this->etiquetas_id,
            'suma_valoraciones' => $this->suma_valoraciones,
            'suma_votos' => $this->suma_votos,
            'denuncias' => $this->denuncias,
            'visible' => $this->visible,
            'cerrada' => $this->cerrada,
        ]);

        // Filtros de texto para otros campos
        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'lugar', $this->lugar])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'motivo_denuncia', $this->motivo_denuncia])
            ->andFilterWhere(['like', 'motivo_bloqueo', $this->motivo_bloqueo]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * Definimos etiquetas personalizadas para los campos
     */
    public function attributeLabels()
    {
        return [
            'clasificacion_id' => 'Clasificación',
            'etiquetas_id' => 'Etiqueta',
            'nombre' => 'Nombre',
            'lugar' => 'Lugar',
            'descripcion' => 'Descripción',
            'url' => 'URL',
            'direccion' => 'Dirección',
            'telefono' => 'Teléfono',
            'suma_valoraciones' => 'Suma de Valoraciones',
            'suma_votos' => 'Suma de Votos',
            'denuncias' => 'Denuncias',
            'visible' => 'Visible',
            'cerrada' => 'Cerrada',
            'motivo_denuncia' => 'Motivo de Denuncia',
            'motivo_bloqueo' => 'Motivo de Bloqueo',
        ];
    }
}
