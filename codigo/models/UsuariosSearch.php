<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * UsuariosSearch represents the model behind the search form of `app\models\Usuario`.
 */
class UsuariosSearch extends Usuario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'region_id', 'registro_confirmado', 'accesos_fallidos', 'bloqueado'], 'integer'],
            [['email', 'password', 'nick', 'nombre', 'apellidos', 'direccion', 'telefono', 'fecha_nacimiento', 'fecha_registro', 'fecha_acceso', 'fecha_bloqueo', 'motivo_bloqueo'], 'safe'],
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
        $query = Usuario::find();

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
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'fecha_registro' => $this->fecha_registro,
            'registro_confirmado' => $this->registro_confirmado,
            'fecha_acceso' => $this->fecha_acceso,
            'accesos_fallidos' => $this->accesos_fallidos,
            'bloqueado' => $this->bloqueado,
            'fecha_bloqueo' => $this->fecha_bloqueo,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'nick', $this->nick])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'motivo_bloqueo', $this->motivo_bloqueo]);

        return $dataProvider;
    }
}
