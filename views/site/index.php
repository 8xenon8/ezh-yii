
<style>

    .grid-wrap {
        text-align: left;
        margin: auto;
    }

    .grid {
        /*width: 1000px;*/
        margin: auto;
        /*height: 400px;*/
        font-size: 0;
        text-align: center;
    }

    .grid-item {
        position: relative;
        display: inline-block;
        /*height: 265px;*/
        /*margin: 5px;*/
        /*background-size: 30%;*/
        overflow: hidden;
    }

    .grid-item .inner-wrap {
        transition-duration: 1.5s;
        background-size: fit;
        /*transition: background-size 2s ease-in;*/
        /*-moz-transition: background-size 2s ease-in;*/
        /*-ms-transition: background-size 2s ease-in;*/
        /*-o-transition: background-size 2s ease-in;*/
        /*-webkit-transition: background-size 2s ease-in;*/
    }

    .grid-item img {
        /*height: 265px;*/
        display: block;
    }

    .grid-item:hover .inner-wrap {
        transform: scale(1.1, 1.1);
    }

    .grid-item .inner-wrap a {
        width: 100%;
        height: 100%;
    }

    .block1 {
        /*width: 370px;*/
    }

    .block1 .inner-wrap {
        width: 100%;
        height: 100%;
        /*background: url('/img/index1.jpg') no-repeat center center;*/
        text-align: right;
    }

    .block2 {
        /*width: 255px;*/
    }

    .block2 .inner-wrap {
        width: 100%;
        height: 100%;
        /*background: url('/img/index2.jpg') no-repeat center center;*/
        text-align: right;
    }

    .block3 {
        /*width: 345px;*/
    }

    .block3 .inner-wrap {
        width: 100%;
        height: 100%;
        /*background: url('/img/index3.jpg') no-repeat center center;*/
        text-align: right;
    }

    .block4 {
        /*width: 255px;*/
    }

    .block4 .inner-wrap {
        width: 100%;
        height: 100%;
        /*background: url('/img/index4.jpg') no-repeat center center;*/
        text-align: right;
    }

    .block5 {
        /*width: 345px;*/
    }

    .block5 .inner-wrap {
        width: 100%;
        height: 100%;
        /*background: url('/img/index5.jpg') no-repeat center center;*/
        text-align: right;
    }

    .block6 {
        /*width: 370px;*/
    }

    .block6 .inner-wrap {
        width: 100%;
        height: 100%;
        /*background: url('/img/index6.jpg') no-repeat center center;*/
        text-align: right;
    }

    .grid-item-comment {
        position: absolute;
        font-size: 33px;
        color: #000;
        bottom: 0;
        width: 100%;
        text-align: right;
        background: rgba(255, 255, 255, 0.7);
        height: 47px;
        padding: 0px 15px;
        font-family: 'PH 400 Caps';
    }

    .fancybox-caption {
        text-align: center;
    }

    .fancybox-caption .tags {
        margin: auto;
    }


    @media all and (min-width: 1300px) and (max-width: 1524px) {
        html, body {
            min-height: 630px;
        }

        .grid-item img {
            margin: 0;
            width: 390px;
            /*max-height: 200px;*/
        }
    }

    @media all and (max-width: 1000px) {
        html, body
        {
            height: auto;
        }

        .content
        {
            margin: 10px auto;
        }

        .grid-item img
        {
            margin: 0;
            width: 350px;
        }
    }

</style>

<section class="grid-wrap">

    <section class="grid">
        <figure class="grid-item block1">
            <a href="/tags/картины">
                <figure class="inner-wrap">
                    <img src="/img/index1.jpg" />
                </figure>
                <div class="grid-item-comment">Картины</div>
            </a>
        </figure>
        <figure class="grid-item block5">
            <a href="/tags/иллюстрации">
                <figure class="inner-wrap">
                    <img src="/img/index5.jpg" />
                </figure>
                <div class="grid-item-comment">Иллюстрации</div>
            </a>
        </figure>
        <figure class="grid-item block3">
            <a href="/tags/роспись_стен">
                <figure class="inner-wrap">
                    <img src="/img/index4.jpg" />
                </figure>
                <div class="grid-item-comment">Роспись стен</div>
            </a>
        </figure>
        <figure class="grid-item block4">
            <a href="/tags/печатная_продукция">
                <figure class="inner-wrap">
                    <img src="/img/index3.jpg" />
                </figure>
                <div class="grid-item-comment">Печатная продукция</div>
            </a>
        </figure>
        <figure class="grid-item block2">
            <a href="/tags/хендмейд">
                <figure class="inner-wrap">
                    <img src="/img/index2.jpg" />
                </figure>
                <div class="grid-item-comment">Хендмейд</div>
            </a>
        </figure>
        <figure class="grid-item block6">
            <a href="/tags/выставки_и_события">
                <figure class="inner-wrap">
                    <img src="/img/index6.jpg" />
                </figure>
                <div class="grid-item-comment">Выставки и события</div>
            </a>
        </figure>
    </section>

</section>