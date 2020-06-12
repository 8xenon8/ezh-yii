<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="utf-8">

    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->registerCsrfMetaTags() ?>
    <title>Nina Ezhik Website | <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- Favicon -->
    <link href="/img/favicon.png" rel="shortcut icon" type="image/vnd.microsoft.icon">

    <!-- Le styles -->
    <link type="text/css" rel="stylesheet" rel="/css/jquery.fancybox.css" />
    <link type="text/css" rel="stylesheet" rel="/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" rel="/css/bootstrap-theme.min.css" />
    <link type="text/css" rel="stylesheet" rel="/css/style.css" />

    <!--[if lt IE 9]><script type="text/javascript" src="/js/html5shiv.js"></script><![endif]-->
    <!--[if lt IE 9]><script type="text/javascript" src="/js/respond.min.js"></script><![endif]-->
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/angular.js"></script>
    <script type="text/javascript" src="/js/spotlight.cdn.js"></script>
    <script type="text/javascript" src="/js/isotope.pkgd.min.js"></script>
    <script type="text/javascript" src="/js/packery-mode.pkgd.js"></script>


    <style>
        @font-face {
            font-family: 'DendaNewLightC';
            src: url('/fonts/DendaNewLightC.eot');
            src: url('/fonts/DendaNewLightC.eot?#iefix') format('embedded-opentype'),
            url('/fonts/DendaNewLightC.woff') format('woff'),
            url('/fonts/DendaNewLightC.ttf') format('truetype');
            font-weight: 300;
            font-style: normal;
        }

        @font-face {
            font-family: 'Monly Lite';
            src: local('Monly Lite Light'), local('MonlyLite-Light'), url('/fonts/Monlylitelight.woff2') format('woff2'), url('/fonts/Monlylitelight.woff') format('woff'), url('/fonts/Monlylitelight.ttf') format('truetype');
            font-weight: 300;
            font-style: normal;
        }

        @font-face {
            font-family: 'Monly Lite';
            src: local('Monly Lite Bold'), url('/fonts/MonlyLite-Bold'), url('/fonts/Monlylitebold.woff2') format('woff2'), url('/fonts/Monlylitebold.woff') format('woff'), url('/fonts/Monlylitebold.ttf') format('truetype');
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: 'Monly Bold';
            src: url('/fonts/monly-free-bold.eot'); /* IE9 Compat Modes */
            src: url('/fonts/monly-free-bold.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('/fonts/monly-free-bold.woff2') format('woff2'), /* Super Modern Browsers */
            url('/fonts/monly-free-bold.woff') format('woff'), /* Pretty Modern Browsers */
            url('/fonts/monly-free-bold.ttf')  format('truetype'), /* Safari, Android, iOS */
            url('/fonts/monly-free-bold.svg#svgFontName') format('svg'); /* Legacy iOS */
        }

        @font-face {
            font-family: 'Monly Light';
            src: url('/fonts/monly-free-light.eot'); /* IE9 Compat Modes */
            src: url('/fonts/monly-free-light.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('/fonts/monly-free-light.woff2') format('woff2'), /* Super Modern Browsers */
            url('/fonts/monly-free-light.woff') format('woff'), /* Pretty Modern Browsers */
            url('/fonts/monly-free-light.ttf')  format('truetype'), /* Safari, Android, iOS */
            url('/fonts/monly-free-light.svg#svgFontName') format('svg'); /* Legacy iOS */
        }

        @font-face {
            font-family: 'Monly Serif Bold';
            src: url('/fonts/monly-free-bold.eot'); /* IE9 Compat Modes */
            src: url('/fonts/monly-free-bold.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('/fonts/monly-free-bold.woff2') format('woff2'), /* Super Modern Browsers */
            url('/fonts/monly-free-bold.woff') format('woff'), /* Pretty Modern Browsers */
            url('/fonts/monly-free-bold.ttf')  format('truetype'), /* Safari, Android, iOS */
            url('/fonts/monly-free-bold.svg#svgFontName') format('svg'); /* Legacy iOS */
        }

        @font-face {
            font-family: 'Monly Serif Light';
            src: url('/fonts/monly-free-light.eot'); /* IE9 Compat Modes */
            src: url('/fonts/monly-free-light.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('/fonts/monly-free-light.woff2') format('woff2'), /* Super Modern Browsers */
            url('/fonts/monly-free-light.woff') format('woff'), /* Pretty Modern Browsers */
            url('/fonts/monly-free-light.ttf')  format('truetype'), /* Safari, Android, iOS */
            url('/fonts/monly-free-light.svg#svgFontName') format('svg'); /* Legacy iOS */
        }

        @font-face {
            font-family: 'PH 400 Caps';
            src: url('/fonts/PH-400RegularCaps_1.eot');
            src: url('/fonts/PH-400RegularCaps_1.eot?#iefix') format('embedded-opentype'),
            url('/fonts/PH-400RegularCaps_1.woff') format('woff'),
            url('/fonts/PH-400RegularCaps_1.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        html {
            height: 100%;
            position: relative;
        }

        html,body {
            background: #fff;
            /*width: 1920px;*/
            margin: auto;
            /*width: 100%;*/
            min-height: 100%;
        }

        .logo {
            margin: 5px 30px;
            width: 343px;
            height: 125px;
            background: url(/img/logo.png) center center no-repeat;
            background-size: contain;
        }

        .menu {
            padding-top: 39px;
            background: url('/img/menu_underline.png') no-repeat bottom left;
        }

        .menu nav {
            display: inline-block;
            margin: 10px auto 8px;
        }

        .menu ul {
            list-style: none;
            padding: 0;
        }

        .menu ul.top_menu>li {
            float: left;
            margin: 0 2px;
            text-align: center;
        }

        .menu ul li a.inner {
            padding: 10px 10px;
            text-decoration: none;
            color: #000;
            border-radius: 100px;
            transition-duration: 0.3s;
            font-size: 16px;
        }

        .menu ul.submenu {
            display: none;
            position: absolute;
            padding-left: 10px;
            z-index: 100;
            height: 0px;
            transition-duration: 3.3s;
            overflow: hidden;
        }

        .menu ul.submenu li {
            text-align: left;
            display: block;
        }

        .menu ul.submenu li a {
            text-decoration: none;
            color: #000;
            font-size: 16px;
        }

        .menu ul li.expandable>div {
            margin-top: -10px;
            padding: 10px 10px;
            color: #000;
            border-radius: 100px;
            transition-duration: 0.3s;
            font-size: 16px;
        }

        .menu ul li.expandable:hover ul.submenu {
            display: block;
            height: auto;
        }

        .menu a.outer.vk {
            display: block;
            height: 25px;
            width: 25px;
            background: url('/img/vk.png') center center no-repeat;
            background-size: contain;
        }

        .menu a.outer.fb {
            display: block;
            height: 25px;
            width: 25px;
            background: url('/img/fb.png') center center no-repeat;
            background-size: contain;
        }

        .content {
            text-align: center;
            margin-left: -16px;
            margin-top: 4px;
        }

        .top-level-menu .second-level-menu
        {
            position: absolute;
            top: 40px;
            left: 0;
            width: 293px;
            list-style: none;
            padding-top: 51px;
            margin: 0 0 0 -1px;
            background: rgba(255, 255, 255, 0.8);
            display: none;
        }

        .second-level-menu > li > a {

        }

        .second-level-menu > li > a {
            color: #000;
            font-family: 'PH 400 Caps';
            font-size: 25px;
            margin: -10px 24px 18.7px 29px;
            font-weight: bold;
            letter-spacing: 2.5px;
            border-bottom: 1px solid #000;
            display: block;
            width: 234px;
            padding: 0 0 10px;
        }

        .second-level-menu > li > a:hover {
            text-decoration: none;
        }

        .second-level-menu > li:last-child > a {
            border: none;
        }

        .second-level-menu > li
        {
            text-align: right;
            position: relative;
            /*background: rgba(255, 255, 255, 0.56);*/
           /*padding: 7px;*/
        }

        /*.second-level-menu > li:hover { background: rgba(0, 0, 0, 0.7); }*/



        .top-level-menu
        {
            list-style: none;
            padding: 0;
            margin: 0;
            z-index: 100;
            position: relative;
            text-align: center;
        }

        /*.top-level-menu > li:hover { background: rgba(0, 0, 0, 0.1); }*/

        .top-level-menu li:hover > ul
        {
           /* On hover, display the next level's menu */
            display: inline;
        }

        /* Menu Link Styles */
        .top-level-menu li.outer:hover {
            background: none;
        }

        .top-level-menu > li > a /* Apply to all links inside the multi-level menu */
        {
            color: #000;
            font-size: 49px;
            text-decoration: none;
            /*padding: 0 47px;*/

            /* Make the link cover the entire list item-container */
            display: block;
            line-height: 30px;
            height: 35px;
        }

        footer {
            position: fixed;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            z-index: 100;
        }

        .social {
            position: absolute;
            left: 18px;
            overflow: hidden;
            padding-left: 20px;
        }

        .social_button {
            float: left;
            margin-right: 17px;
        }

        .social_button img {
            width: 48px;
            height: 48px;
        }

        footer .tags {
            padding: 15px 50px;
            /*transition-duration: 0.3s;*/
            position: relative;
            margin-left: 300px;
            /*right: 50px;*/
            /*bottom: 10px;*/
            /*box-shadow: 0px 0px 15px 15px rgba(255, 255, 255, 0.9);*/
            /*background: rgba(255, 255,*/
        }

        .taglist {
            display: none;
        }

        .showTags {
            font-family: 'DendaNewLightC';
            text-transform: uppercase;
            font-size: 23px;
            font-weight: bold;
            letter-spacing: 2.5px;
            text-align: right;
            cursor: pointer;
        }

        .showTags:hover {
            color: #ff0000;
        }

        .tags .tag, .content .tag {
            text-decoration: none;
            font-family: 'Myriad Pro';
            color: #000;
            font-size: 16px;
            margin: 0 0px 0px 2px;
            font-family: 'DendaNewLightC';
            border-radius: 20px;
            padding: 0px 8px;
            transition-duration: 0.3s;
            border: 2px solid transparent;
        }

        .tags .tag.selected, .content .tag.selected {
            background: #000;
            color: #fff;
        }

        .tags .tag:hover, .content .tag:hover {
            border: 2px solid black;
        }

        .tags .tag {
            float: right;
        }

        .content .tag {
            display: inline-block;
        }

        @media all and (min-width: 1525px) {
            html,body {
                width: 1525px;
                height: 900px;
            }

            body {
                /*min-height: 0;*/
            }

            .grid {
                width: 1525px;
            }

            .footer-stub {
                height: 85px;
            }

            .grid-item img {
                /*width: 487px;*/
            }

            .social {
                padding-left: 8px;
                bottom: 12px;
            }

            footer .tags {
                margin-left: 300px;
                /*bottom: 10px;*/
                float: right;
            }

            footer {
                position: fixed;
                bottom: 0;
                width: 1541px;
            }
        }

        @media all and (min-width: 1300px) and (max-width: 1524px) {
            html,body {
                width: 1300px;
                /*height: 600px;*/
            }

            .logo {
                margin: -20px 30px;
            }

            .menu {
                padding-top: 15px;
            }

            .content {
                margin-top: 4px;
            }

            .grid-item img {
                /* height: 265px; */
                /*width: 410px;*/
            }

            .footer-stub {
                height: 70px;
            }

            .menu {
                width: 900px;
            }

            footer .tags {
                margin-left: 300px;
                /*bottom: 10px;*/
                float: right;
            }

            .social {
                padding-left: 8px;
                bottom: 13px;
            }

            footer {
                position: fixed;
                bottom: 0;
                width: 1300px;
            }
        }

        @media all and (min-width: 1001px) and (max-width: 1299px) {
            html,body {
                width: 800px;
                position: relative;
            }

            .grid-item img {
                /*margin: -8% 0;*/
            }

            .grid-item img {
                /* height: 265px; */
                /*width: 550px;*/
            }

            .logo {
                float: none;
                margin: 5px auto 0;
            }

            .menu {
                padding-top: 0px;
                text-align: center;
                background: url(/img/menu_underline.png) no-repeat bottom center;
            }

            .top-level-menu > li > a {
                font-size: 45px;
            }

            footer {
                width: 100%;
                position: fixed;
                left: 0;
                background: rgba(255, 255, 255, 0.9);
            }

            .social_button {
                float: none;
                display: inline-block;
                margin: 0 5px;
            }

            .social_button img {
                width: 36px;
                height: 36px;
            }

            .social {
                position: absolute;
                left: 0px;
                overflow: hidden;
                padding-left: 0px;
                margin: 13px auto;
                text-align: center;
                padding-bottom: 70px;
                margin-left: 50px;
            }

            footer .tags {
                /*position: fixed;*/
                bottom: 0px;
                width: 100%;
                margin: auto;
                text-align: center;
                /*left: 50%;*/
                /*background: rgba(255, 255, 255, 0.9);*/
                /*margin-left: -400px;*/
            }

            .showTags {
                text-align: center;
            }

            .tags .tag {
                float: none;
            }
        }

        @media all and (max-width: 1000px)
        {
            html body nav .top-level-menu > li
            {
                position: relative;
                float: left;
                font-family: 'Monly Lite';
                border-right: 1px solid #000;
                margin: 10px 30px;
                font-size: 30px;
                border-right: none;
            }

            .logo
            {
                margin: auto;
                height: 125px;
                background: url(/img/logo.png) center center no-repeat;
                background-size: contain;
                text-align: center;
                width: 490px;
            }

            .menu
            {
                text-align: center;
            }
        }

        @media all and (max-width: 500px)
        {
            html body nav .top-level-menu > li
            {
                width: 100%;
                margin: 10px 0;
            }

            .logo
            {
                width: 350px;
                height: 95px;
            }

            .menu
            {
                padding-top: 0;
            }
        }

        @media all and (min-width: 1001px)
        {
            .top-level-menu>li:first-child {
                padding: 0 99px 0 47px;
            }

            .top-level-menu>li:nth-child(2) {
                padding: 0 98px 0 95px;
            }

            .top-level-menu>li:last-child {
                padding: 0 93px;
                border: none;
            }

            .top-level-menu > li
            {
                position: relative;
                float: left;
                font-family: 'Monly Lite';
                border-right: 1px solid #000;
            }

            .top-level-menu > li:last-child
            {
                position: relative;
                float: left;
                font-family: 'Monly Lite';
            }

            .top-level-menu > li.outer
            {
                position: relative;
                float: left;
                width: auto;
                background: none;
                padding: 2px;
            }

            .logo
            {
                float: right;
                /*margin: 5px 30px;*/
                width: 343px;
                height: 125px;
                background: url(/img/logo.png) center center no-repeat;
                background-size: contain;
            }

            .menu
            {
                text-align: left;
            }
        }

        @media all and (max-width: 1000px) {
            footer
            {
                position: fixed;
                width: 100%;
                background: rgba(255, 255, 255, 0.9);
            }

            footer .tags
            {
                color: #000;
                font-size: 22px;
                font-family: 'DendaNewLightC';
                border-radius: 20px;
                padding: 0px 8px;
                transition-duration: 0.3s;
                margin: 5px;
                border: 2px solid transparent;
            }

            footer .taglist {
                text-align: center;
            }

            .social
            {
                position: absolute;
                left: 25px;
                overflow: hidden;
                padding-left: 0px;
                margin: 10px auto;
                text-align: center;
                padding-bottom: 70px;
                top: 0px;
            }

            .social_button
            {
                display: inline-block;
                float: none;
            }

            .showTags
            {
                text-align: center;
                padding: 10px 0;
            }

            .tags .tag {
                float: none;
                font-size: 23px;
                margin: 20px 10px;
            }

            .footer-stub {
                height: 90px;
            }
        }

        @media all and (max-width: 1000px)
        {
            .social {
                left: 2vw;
                z-index: 100;
            }

            .social_button {
                margin-right: 1vw;
            }

            .social_button img {
                width: 7vw;
                height: 7vw;
            }

            .footer-stub {
                height: 60px;
            }

            .showTags {
                font-size: 3vw;
            }
        }
    </style>
</head>

<body>
<?php $this->beginBody() ?>

<header>
    <a href="/"><section class="logo"></section></a>
    <section class="menu">
        <nav>
            <ul class="top-level-menu">
                <li><a href="/">Главная</a></li>
                <li>
                    <a href="#">Изделия</a>
                    <ul class="second-level-menu">
                        <li><a href="/tags/картины">Картины</a></li>
                        <li><a href="/tags/иллюстрации">Иллюстрации</a></li>
                        <li><a href="/tags/роспись_стен">Роспись стен</a></li>
                        <li><a href="/tags/печатная_продукция">Печатная продукция</a></li>
                        <li><a href="/tags/хендмейд">Хендмейд</a></li>
                        <li><a href="/tags/выставки_и_события">Выставки и события</a></li>
                    </ul>
                </li>
                <li><a href="/about">Контакты</a></li>
            </ul>
        </nav>
    </section>

</header>

<br clear="both" />

<section class="content">
    <?php echo $content; ?>
</section>

<section class="footer-stub"></section>

<br clear="both" />

<footer>

    <section class="social">
        <figure class="social_button fb">
            <a class="fb-share" href="http://www.facebook.com/share.php?u=http%3A%2F%2Fnina-ezhik.ru&title=Nina%20Ezhik%20Website">
                <img src="/img/fb.png">
            </a>
        </figure>

        <figure class="social_button vk">
            <a class="vk-share" href="https://vk.com/share.php?url=http%3A%2F%2Fnina-ezhik.ru&title=Nina%20Ezhik%20Website&description=&image=http%3A%2F%2Fnina-ezhik.ru%2Fimg%2Findex1.jpg">
                <img src="/img/vk.png">
            </a>
        </figure>

        <figure class="social_button tw">
            <a class="twitter-share" href="https://twitter.com/intent/tweet?url=http%3A%2F%2Fnina-ezhik.ru&text=Nina%20Ezhik%20Website">
                <img src="/img/tw.png">
            </a>
            <script>

                var getWindowOptions = function() {
                    var width = 500;
                    var height = 350;
                    var left = (window.innerWidth / 2) - (width / 2);
                    var top = (window.innerHeight / 2) - (height / 2);

                    return [
                        'resizable,scrollbars,status',
                        'height=' + height,
                        'width=' + width,
                        'left=' + left,
                        'top=' + top,
                    ].join();

                };

                var twitterBtn = $('.twitter-share');

                twitterBtn.click(function(e) {
                    e.preventDefault();
                    var shareUrl = $(this).attr('href');
                    var win = window.open(shareUrl, 'ShareOnTwitter', getWindowOptions());
                    win.opener = null; // 2
                });

                var vkBtn = $('.vk-share');

                vkBtn.click(function(e) {
                    e.preventDefault();
                    var shareUrl = $(this).attr('href');
                    var win = window.open(shareUrl, 'ShareOnVk', getWindowOptions());
                    win.opener = null; // 2
                });

                var fbBtn = document.querySelector('.fb-share');

                fbBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var shareUrl = $(this).attr('href');
                    var win = window.open(shareUrl, 'ShareOnFb', getWindowOptions());
                    win.opener = null; // 2
                });

            </script>

        </figure>

    </section>

    <section class="tags">

        <p class="showTags">Показать тeги</p>
        <?php

        $uriParts = explode('/',$_SERVER['REQUEST_URI']);
        $selectedTags = array_map(function($i) { return urldecode($i); }, array_filter(explode(',', $uriParts[count($uriParts) - 1]), function($i) { return $i != ''; }));
        $selectedTags = $selectedTags ?: [];

        ?>

        <section class="taglist">

            <?php foreach ($this->params["tags"] as $tag) : ?>
                <?php if (in_array($tag['name'], $selectedTags)) : ?>
                    <?php $url = "/tags/" . implode(',', array_filter($selectedTags, function($i) use ($tag) { return $i != $tag['name']; })) ?>
                <?php else : ?>
                    <?php $url = "/tags/" . implode(',', array_merge($selectedTags, [$tag['name']]))?>
                <?php endif; ?>
                <a class="tag<?php if (in_array($tag['name'],  $selectedTags)) : ?> selected<?php endif; ?>" data-filter=".<?=transliterator_transliterate('Russian-Latin/BGN', $tag["name"]); ?>" data-id="<?= $tag['name']; ?>" href="<?= $url; ?>">#<?= $tag['name']; ?></a>
            <?php endforeach; ?>

        </section>

    </section>



</footer>



<script>
    let show = false;

    $('.tags .showTags').click(function() {

        if (show) {

            show = false;

            $(this).css({
                'transition-duration': '0.3s'
            });

            $('.taglist').slideToggle(200, function() {
                $('.showTags').css({
                    'transition-duration': '0s'
                });
            });

            $(this).html('Показать теги');

        } else {

            show = true;

            $(this).css({
                'transition-duration': '0.3s'
            });

            $('.taglist').slideToggle(200, function() {
                $('.showTags').css({
                    'transition-duration': '0s'
                });
            });

            $(this).html('Скрыть теги');

        }

    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>