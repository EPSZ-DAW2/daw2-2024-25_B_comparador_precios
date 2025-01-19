<?php

use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;

AppAsset::register($this);

//$this->registerCssFile('@web/css/mantenimiento.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/site.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/header.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/footer.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/buscador.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/tiendasarticulos.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/perfil.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/formulario.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/tablas.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/politicasavisos.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/areasusuarios.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/avisos.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('@web/css/menuver.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css');

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);



?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?php include __DIR__ . '/header.php'; ?>

<main id="main" class="flex-shrink-0 espacio-principal" role="main">
    <div class="container">
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <?php include __DIR__ . '/footer.php'; ?>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
