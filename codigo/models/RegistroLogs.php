<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Este es el modelo para la tabla "registro_logs".
 *
 * @property int $id Identificador del registro
 * @property string $fecha_log Fecha y hora del log
 * @property string $mensaje Mensaje del log
 * @property string $nivel Nivel de severidad del log
 * @property string $usuario Usuario que generó el log
 * @property string $accion Acción registrada
 */
class RegistroLogs extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registro_logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_log', 'mensaje', 'nivel', 'usuario', 'accion'], 'required'], // 'accion' ahora es obligatorio
            [['fecha_log'], 'safe'],
            [['mensaje'], 'string', 'max' => 500],
            [['nivel'], 'in', 'range' => ['INFO', 'WARNING', 'ERROR', 'DEBUG']],
            [['usuario', 'accion'], 'string', 'max' => 500], // 'accion' tiene las mismas validaciones que 'usuario'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha_log' => 'Fecha del Log',
            'mensaje' => 'Mensaje',
            'nivel' => 'Nivel',
            'usuario' => 'Usuario',
            'accion' => 'Acción',
        ];
    }

    /**
     * Sobrescribir beforeSave para manejar valores por defecto.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord && empty($this->usuario)) {
                $this->usuario = Yii::$app->user->isGuest ? 'Sistema' : Yii::$app->user->identity->username;
            }
            return true;
        }
        return false;
    }
}
