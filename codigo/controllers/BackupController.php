<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Backup;
use app\models\Usuario; // Asegúrate de que el modelo Usuario esté correctamente importado

class BackupController extends Controller
{
    /**
     * Define el comportamiento de control de acceso para el controlador.
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Permitir acceso solo a usuarios autenticados
                        'matchCallback' => function ($rule, $action) {
                            // Comprobar si el usuario tiene el rol de administrador o superadministrador
                            return Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_ADMINISTRADOR) || 
                                   Usuario::tieneRol(Yii::$app->user->id, Usuario::ROL_SUPERADMINISTRADOR);
                        },
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('No tienes permiso para acceder a esta página.');
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'], // La acción delete solo puede ser invocada mediante POST
                ],
            ],
        ];
    }

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
        $currentTime = time();
        $daysLimit = 30; // Eliminar backups mayores a 30 días

        foreach ($backups as $backup) {
            $filePath = Yii::getAlias('@app/config/' . $backup->nombre_archivo); // Ruta en la carpeta config

            // Verifica si el archivo físico asociado al backup existe
            if (file_exists($filePath)) {
                $fileCreationTime = filemtime($filePath);
                $timeDifference = ($currentTime - $fileCreationTime) / (60 * 60 * 24); // Diferencia en días

                if ($timeDifference > $daysLimit) {
                    if (unlink($filePath)) {
                        if (!$backup->delete()) {
                            Yii::$app->session->addFlash('error', "Error al eliminar el registro del backup ID: {$backup->id}");
                        }
                    } else {
                        Yii::$app->session->addFlash('error', "No se pudo eliminar el archivo: {$filePath}");
                    }
                }
            } else {
                // El archivo no existe en el sistema, eliminar solo el registro en la base de datos
                if (!$backup->delete()) {
                    Yii::$app->session->addFlash('error', "No se pudo eliminar el registro del backup ID: {$backup->id}");
                }
            }
        }

        Yii::$app->session->setFlash('success', 'Backups antiguos limpiados exitosamente.');
        return $this->redirect(['index']);
    }
}
