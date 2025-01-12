<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Moderador;

/**
 * ModeradoresSearch representa el modelo detrás de la forma de búsqueda de `Moderador`.
 */
class ModeradoresSearch extends Moderador
{
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'region_id'], 'integer'],
            [['nombre', 'nif', 'direccion', 'telefono'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // Omitir escenarios de Model por defecto()
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Moderador::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Descomentar esta línea si no desea devolver ningún registro cuando la validación falla
            // $query->where('0=1');
            return $dataProvider;
        }

        // Condiciones de filtrado
        $query->andFilterWhere([
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
            'region_id' => $this->region_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
              ->andFilterWhere(['like', 'nif', $this->nif])
              ->andFilterWhere(['like', 'direccion', $this->direccion])
              ->andFilterWhere(['like', 'telefono', $this->telefono]);

        return $dataProvider;
    }
}
