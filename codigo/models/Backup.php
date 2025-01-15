<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Backup extends ActiveRecord
{
    /**
     * Tabla de base de datos asociada al modelo
     */
    public static function tableName()
    {
        return 'backup';
    }

    /**
     * Reglas de validación
     */
    public function rules()
    {
        return [
            [['nombre_archivo', 'ruta_archivo', 'fecha_creacion', 'tamaño'], 'required'],
            [['fecha_creacion'], 'safe'],
            [['tamaño'], 'integer'],
            [['nombre_archivo'], 'string', 'max' => 255],
            [['ruta_archivo'], 'string', 'max' => 500],
        ];
    }

    /**
     * Crea un backup y registra la información en la tabla
     * @return bool
     */
    public static function createBackup()
    {
        $db = Yii::$app->db;
        $dsn = $db->dsn;

        preg_match('/host=([^;]*)/', $dsn, $host);
        preg_match('/dbname=([^;]*)/', $dsn, $dbname);

        $backupPath = Yii::getAlias('@app/backups');
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0777, true);
        }

        $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filePath = $backupPath . '/' . $fileName;

        $mysqldumpPath = 'C:\xampp\mysql\bin\mysqldump.exe'; // Cambiar según el entorno
        $command = "\"{$mysqldumpPath}\" --user={$db->username} --password={$db->password} --host={$host[1]} {$dbname[1]} > \"{$filePath}\"";

        exec($command, $output, $returnVar);

        if ($returnVar === 0 && file_exists($filePath)) {
            $backup = new self();
            $backup->nombre_archivo = $fileName;
            $backup->ruta_archivo = $filePath;
            $backup->fecha_creacion = date('Y-m-d H:i:s');
            $backup->tamaño = filesize($filePath);

            return $backup->save();
        }

        return false;
    }

    /**
     * Elimina un backup del sistema y la base de datos
     * @return bool
     */
    public function deleteBackup()
    {
        if (file_exists($this->ruta_archivo)) {
            unlink($this->ruta_archivo);
        }
        return $this->delete();
    }
}
