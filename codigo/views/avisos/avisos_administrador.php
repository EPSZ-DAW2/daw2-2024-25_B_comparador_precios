<div class="avisos-administrador">
    <h1 class="avisos-titulo">Avisos Pendientes</h1>

    <!-- Botón para limpiar todos los mensajes al principio -->
    <a href="<?= Yii::$app->urlManager->createUrl(['avisos/limpiar-mensajes']) ?>" 
       class="btn btn-warning"
       onclick="return confirm('¿Estás seguro de que deseas eliminar todos los mensajes pendientes?');">
        Limpiar todos los mensajes
    </a>

    <?php if (!empty($avisos)): ?>
        <ul class="avisos-lista">
            <?php foreach ($avisos as $aviso): ?>
                <li class="avisos-item">
                    <strong class="avisos-clase"><?= $aviso->clase ?></strong>: 
                    <span class="avisos-texto"><?= $aviso->texto ?></span>
                    <span class="avisos-usuario">(Usuario ID: <?= $aviso->usuario_origen_id ?>)</span>
                    <a href="<?= Yii::$app->urlManager->createUrl(['avisos/eliminar-aviso', 'id' => $aviso->id]) ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('¿Estás seguro de que deseas eliminar este aviso?');">
                        Eliminar aviso
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="avisos-sin-mensajes">No hay avisos pendientes.</p>
    <?php endif; ?>
</div>
