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
use kartik\icons\Icon;

Icon::map($this);  
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body style="
/*    background: url('../images/background-ragnarok-online-2.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size:cover;*/
">
<div id="fb-root"></div>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Icon::show('cloud'). 'RO108',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        // ['label' => 'Home', 'url' => Yii::$app->homeUrl],
        ['label' => Icon::show('server'). 'Eden', 'url' => ['/eden/market'], 'options' => Yii::$app->request->get('server') == 'eden' ? ['class' => 'active'] : []],
        ['label' => Icon::show('server'). 'Thor', 'url' => ['/thor/market'], 'options' => Yii::$app->request->get('server') == 'thor' ? ['class' => 'active'] : []],
        ['label' => Icon::show('server'). 'Loki', 'url' => ['/loki/market'], 'options' => Yii::$app->request->get('server') == 'loki' ? ['class' => 'active'] : []],
        ['label' => Icon::show('user-plus'). Yii::t('app', 'Register'), 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Icon::show('sign-in'). Yii::t('app', 'Sign in'), 'url' => ['/user/security/login']];
        $menuItems[] = ['label' => Icon::show('facebook-square'). Yii::t('app', 'Facebook Login'), 'url' => ['/user/security/auth?authclient=facebook']];
    } else {
        $menuItems[] = ['label' => Icon::show('sign-out'). 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['/user/security/logout'], 'linkOptions' => ['data-confirm' => 'แน่ใจเหรอ?', 'data-method' => 'post']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
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

    <div class="container" style="background: #f1f1f1">
        <div class="row">
            <div class="col-md-offset-4 col-md-4">
                <div class="fb-page" data-href="https://www.facebook.com/ro108shop/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/ro108shop/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ro108shop/">RO108</a></blockquote></div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Ro 108 Beta <?= date('Y') ?></p>

        <p class="pull-right"><?= '' ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>