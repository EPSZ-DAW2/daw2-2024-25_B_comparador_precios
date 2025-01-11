<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RegistroLogsSearch representa el modelo detrás de la forma de búsqueda de `RegistroLogs`.
 */
class RegistroLogsSearch extends RegistroLogs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fecha_log', 'mensaje', 'nivel', 'usuario', 'accion'], 'safe'], // Incluir 'accion'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Crea un proveedor de datos con la consulta de búsqueda aplicada.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RegistroLogs::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Condiciones de filtrado
        $query->andFilterWhere([
            'id' => $this->id,
            'fecha_log' => $this->fecha_log,
        ]);

        $query->andFilterWhere(['like', 'mensaje', $this->mensaje])
              ->andFilterWhere(['like', 'nivel', $this->nivel])
              ->andFilterWhere(['like', 'usuario', $this->usuario])
              ->andFilterWhere(['like', 'accion', $this->accion]); // Filtrar por acción

        return $dataProvider;
    }
}
