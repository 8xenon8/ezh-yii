<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode('Control panel') ?></title>
    <?php $this->head() ?>

    <script type="text/javascript" src="/node_modules/@pnotify/core/dist/PNotify.js"></script>
    <link href="/node_modules/@pnotify/core/dist/PNotify.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/node_modules/@pnotify/mobile/dist/PNotifyMobile.js"></script>
    <link href="/node_modules/@pnotify/mobile/dist/PNotifyMobile.css" rel="stylesheet" type="text/css" />
    <link href="/node_modules/@pnotify/core/dist/BrightTheme.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        PNotify.defaultModules.set(PNotifyMobile, {});
    </script>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $items = [];
    if (Yii::$app->user->isGuest) {
        $items[] = ['label' => 'Login', 'url' => ['/admin/login']];
    } else {
        $items[] = ['label' => 'Images', 'url' => ['/admin/images']];
        $items[] = ['label' => 'Tags', 'url' => ['/admin/tags']];
        $items[] = ['label' => 'Sorting', 'url' => ['/admin/sorting']];
        $items[] = '<li>'
            . Html::beginForm(['/admin/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
