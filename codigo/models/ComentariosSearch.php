<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comentario;

/**
 * ComentariosSearch represents the model behind the search form of `app\models\Comentario`.
 */
class ComentariosSearch extends Comentario
{
    public $nombre_articulo; // Nombre del artículo asociado
    public $nombre_usuario; // Nombre del usuario que hizo el comentario
    public $contenido;

    // Propiedades que corresponden con las columnas de la base de datos
    public $articulo_id;
    public $registro_id; 

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'articulo_id', 'registro_id'], 'integer'], // Agrega 'id' aquí
            [['contenido'], 'string'],
            [['nombre_articulo', 'nombre_usuario', 'fecha_primera_denuncia'], 'safe'],
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

    public function search($params)
    {
        $query = Comentario::find()
            ->alias('c')
            ->joinWith(['articulo a', 'registro r']); // Cambiar usuario por registro

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['c.id' => $this->id]);
        
        // Filtros para las columnas de la tabla "comentarios"
        $query->andFilterWhere(['c.articulo_id' => $this->articulo_id])
              ->andFilterWhere(['c.registro_id' => $this->registro_id]); 

        // Filtros para las tablas relacionadas "articulos" y "usuarios" (en este caso 'registro')
        $query->andFilterWhere(['like', 'a.nombre', $this->nombre_articulo])
              ->andFilterWhere(['like', 'r.nombre', $this->nombre_usuario]); 

        // Filtro para el contenido
        $query->andFilterWhere(['like', 'c.texto', $this->contenido]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'articulo_id' => 'Artículo',
            'registro_id' => 'Usuario', 
            'nombre_articulo' => 'Nombre del Artículo',
            'nombre_usuario' => 'Nombre del Usuario',
            'contenido' => 'Contenido',
            'fecha_primera_denuncia' => 'Fecha de la Primera Denuncia',
        ];
    }
}