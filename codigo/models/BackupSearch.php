<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class BackupSearch extends Backup
{
    /**
     * Reglas de validación para el modelo de búsqueda.
     */
    public function rules()
    {
        return [
            [['id', 'tamaño'], 'integer'],
            [['nombre_archivo', 'ruta_archivo', 'fecha_creacion'], 'safe'],
        ];
    }

    /**
     * Escenarios personalizados para el modelo de búsqueda.
     */
    public function scenarios()
    {
        // Omitimos la implementación del escenario base ya que no es necesario para el modelo de búsqueda.
        return Model::scenarios();
    }

    /**
     * Crea una instancia de ActiveDataProvider con la consulta de búsqueda aplicada.
     *
     * @param array $params Parámetros de búsqueda.
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Backup::find();

        // Agrega condiciones que siempre se aplican aquí.

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Descomentar la línea siguiente si no se desean resultados al no validar.
            // $query->where('0=1');
            return $dataProvider;
        }

        // Filtro de condiciones específicas
        $query->andFilterWhere([
            'id' => $this->id,
            'tamaño' => $this->tamaño,
            'fecha_creacion' => $this->fecha_creacion,
        ]);

        $query->andFilterWhere(['like', 'nombre_archivo', $this->nombre_archivo])
              ->andFilterWhere(['like', 'ruta_archivo', $this->ruta_archivo]);

        return $dataProvider;
    }
}
