<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Backup;

class BackupController extends Controller
{
    /**
     * Página principal: Lista backups y ofrece opciones de gestión
     */
    public function actionIndex()
    {
        $backups = Backup::find()->orderBy(['fecha_creacion' => SORT_DESC])->all();
        return $this->render('index', ['backups' => $backups]);
    }

    /**
     * Crea un nuevo backup
     */
    public function actionCreate()
    {
        if (Backup::createBackup()) {
            Yii::$app->session->setFlash('success', 'Backup creado exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Error al crear el backup.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Descarga un backup
     * @param int $id
     */
    public function actionDownload($id)
    {
        $backup = Backup::findOne($id);
        if ($backup && file_exists($backup->ruta_archivo)) {
            return Yii::$app->response->sendFile($backup->ruta_archivo);
        }

        Yii::$app->session->setFlash('error', 'El archivo de backup no existe.');
        return $this->redirect(['index']);
    }

    /**
     * Elimina un backup
     * @param int $id
     */
    public function actionDelete($id)
    {
        $backup = Backup::findOne($id);
        if ($backup && $backup->deleteBackup()) {
            Yii::$app->session->setFlash('success', 'Backup eliminado exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Error al eliminar el backup.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Limpia backups antiguos manteniendo solo los más recientes
     */
    public function actionClean()
    {
        $backups = Backup::find()->all();
        foreach ($backups as $backup) {
            // Verifica si el archivo físico asociado al backup existe
            if (file_exists($backup->ruta_archivo)) {
                // Obtiene la fecha de creación del archivo
                $fileCreationTime = filemtime($backup->ruta_archivo);
                $currentTime = time();
                $timeDifference = ($currentTime - $fileCreationTime) / (60 * 60 * 24); // Diferencia en días

                // Si el archivo tiene más de 30 días, eliminarlo
                if ($timeDifference > 30) {
                    unlink($backup->ruta_archivo);
                    $backup->delete();
                }
            } else {
                // Si el archivo no existe en el sistema, eliminar solo el registro en la base de datos
                $backup->delete();
            }
        }

        Yii::$app->session->setFlash('success', 'Backups antiguos limpiados exitosamente.');
        return $this->redirect(['index']);
    }

}
