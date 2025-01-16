<h1>Avisos Pendientes</h1>

<?php if (!empty($avisos)): ?>
    <ul>
        <?php foreach ($avisos as $aviso): ?>
            <li>
                <strong><?= $aviso->clase ?></strong>: <?= $aviso->texto ?>
                <br>
                Enviado por el usuario ID: <?= $aviso->usuario_origen_id ?>
                <br>
                <!-- Solo opción de eliminar el aviso, ya no hay opción de dar de baja -->
                <a href="<?= Yii::$app->urlManager->createUrl(['avisos/eliminar-aviso', 'id' => $aviso->id]) ?>" 
                   class="btn btn-danger"
                   onclick="return confirm('¿Estás seguro de que deseas eliminar este aviso?');">Eliminar aviso</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <br>
    <!-- Botón para limpiar todos los mensajes -->
    <a href="<?= Yii::$app->urlManager->createUrl(['avisos/limpiar-mensajes']) ?>" 
       class="btn btn-warning"
       onclick="return confirm('¿Estás seguro de que deseas eliminar todos los mensajes pendientes?');">
        Limpiar todos los mensajes
    </a>
<?php else: ?>
    <p>No hay avisos pendientes.</p>
<?php endif; ?>
