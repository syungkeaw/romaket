<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\classes\RoHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body style="
    background: url('../images/background-ragnarok-online-2.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size:cover;
">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'RO108',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        // ['label' => 'Home', 'url' => Yii::$app->homeUrl],
        ['label' => 'Eden', 'url' => ['/market/eden']],
        // ['label' => 'Thor', 'url' => ['/market/thor']],
        // ['label' => 'Loki', 'url' => ['/market/loki']],
        ['label' => 'My Shop', 'url' => ['/shop/index'], 'visible' => !Yii::$app->user->isGuest],
        // ['label' => 'Setting', 'url' => ['/shop/index'], 'visible' => !Yii::$app->user->isGuest],
        ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Sign in', 'url' => ['/user/security/login']];
    } else {
        $menuItems[] = ['label' => 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['/user/security/logout'], 'linkOptions' => ['data-method' => 'post']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container" style="background: #fff">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Ro Item Beta <?= date('Y') ?></p>

        <p class="pull-right"><?= '' ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
