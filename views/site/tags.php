<style>

    .grid {
        text-align: center;
        /*height: 600px;*/
        margin-left: 10px;
        transition-duration: 0.7s;
        transition-timing-function: linear;
    }

    .grid-item {
        /*display: block;*/
        margin: 8px;
        /*margin: 4px;*/
    }

    .grid-item img {
        width: 100%;
        height: 100%;
    }

    .grid-item figure {
        position: relative;
    }

    .tag {
        display: inline;
    }

    .tag label {
        padding: 5px;
        color: #fff;
        font-family: tahoma;
        font-weight: 100;
        margin: 0;
    }

    .tag label:hover {
        text-decoration: underline;
        cursor: pointer;
    }

    .tag.checked label {
        background: rgba(0, 0, 0, 0.7);
        text-decoration: underline;
    }

    .tag.inactive label {
        opacity: 0.3;
        text-decoration: none;
    }

    .tag input {
        display: none;
    }

    .tagBlock-wrap {
        position: fixed;
        width: 100%;
        transition-duration: 0.7s;
        z-index: 100;
        top: 100%;
        margin-top: -30px;
    }

    .tagBlock-button {
        display: block;
        margin: auto;
        width: 60px;
        height: 30px;
        background: rgba(0, 0, 0, 0.7);
        border-radius: 100px 100px 0 0;
        bottom: 0;
        cursor: pointer;
    }

    .tagBlock-content {
        padding: 20px;
        background: rgba(0, 0, 0, 0.7);
        width: 100%;
        text-align: center;
    }

    .tagBlock-wrap:hover {
    }

    @media all and (min-width: 1001px)
    {
        .grid-item img
        {
            /*width: 200px;*/
        }

        figure.laptop_preview
        {
            display: block;
        }

        figure.handheld_preview
        {
            display: none;
        }
    }

    @media all and (max-width: 1000px)
    {
        .content {
            margin: 10px 16px;
        }

        .grid-item {
            width: 20vw;
            margin: 0.5vw;
        }

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

        figure.laptop_preview
        {
            display: none;
        }

        figure.handheld_preview
        {
            display: block;
        }

        .footer-stub {
            height: 60px;
        }

        .showTags {
            font-size: 3vw;
        }
    }

    html, body
    {
        height: auto;
    }

    .fancybox-caption {
        border-top: none;
    }

    #spotlight
    {
        left: 0;
    }

</style>

<?php if (count($images) > 0) : ?>

    <div class="grid">
        <?php foreach ($images as $image) : ?>

            <div
                    class="grid-item not-loaded<?php foreach ($image->tags as $tag) :?> <?= transliterator_transliterate('Russian-Latin/BGN', $tag['name']); ?><?php endforeach; ?>"
                    style="width: <?php if ($image->orig_width >= $image->orig_height) : ?>400<?php else : ?>200<?php endif; ?>;"
                    data-src="/img/upload/<?= $image->preview; ?>"
                    data-width="<?= $image->preview_width; ?>"
                    data-height="<?= $image->preview_height; ?>"
                    data-id="<?= $image->id; ?>"
                    data-tags="<?= json_encode($image->tags); ?>"
                    data-description="<?= $image->description; ?>"
                    data-title="<?= $image->name; ?>"
            >
                <a class="spotlight" href="/img/upload/<?= $image->orig; ?>">
                    <figure class="laptop_preview"
                            style="width:<?= $image->preview_width; ?>px;height:<?= $image->preview_height; ?>px">
                    </figure>
                    <figure class="handheld_preview" style="width:20vw; height: <?= ($image->preview_height / $image->preview_width) * 100 / 5; ?>vw"></figure>
                </a>
            </div>

        <?php endforeach; ?>
    </div>

<?php endif; ?>



<script>

    var tagsTranslation = <?php
        $tagArray = [];
        foreach ($this->params['tags'] as $tag)
        {
            $tagArray[$tag['name']] = transliterator_transliterate('Russian-Latin/BGN', $tag['name']);
        }
        echo json_encode($tagArray);
        ?>;
    var selectorFromUri = readSelectorFromURI();

    selector = selectorFromUri ? '.' + selectorFromUri.map(function(i) { return transliterate(i); }).join('.') : '';

    function transliterate(word)
    {
        return tagsTranslation[word];
    }

    $('.grid-item').each(function(i, el) {
        let figure = $(el).find('figure:visible');
        let width = figure.attr('width');
        let height = figure.attr('height');
        let img = $(el).find('img');
        img.attr('width', width);
        img.attr('height', height);
    })

    function reassignSpotlight()
    {
        $('.spotlight').removeClass('spotlight');
        $(selector).addClass('spotlight');
        if (selector == '')
        {
            $('.grid-item a').addClass('spotlight');
        }
    }

    function rearrangeGrid()
    {
        reassignSpotlight();
        grid.isotope({filter: selector});
    }

    var tagsURI = decodeURIComponent(window.location.href).match(/\/tags\/[А-Яа-я,_]+/);
    if (tagsURI) {
        var tags = tagsURI[0].replace(/\/tags\//, '').split(',');
        var selector = '.' + tags.map(function(i) { return transliterate(i); }).join('.');
    } else {
        var selector = "";
    }

    function readSelectorFromURI()
    {
        var tagsURI = decodeURIComponent(window.location.href).match(/\/tags\/[А-Яа-я,_]+/);
        if (tagsURI) {
            var tags = tagsURI[0].replace(/\/tags\//, '').split(',');
        } else {
            var tags = [];
        }
        return tags.map(function(i) { return transliterate(i); });
    }

    var grid = $('.grid');

    reassignSpotlight();

    grid.isotope({
        layoutMode: 'packery',
        masonry: {
            gutter: 2,
            columnWidth: 50
        },
        filter: selector,
    });

    $(document).on('scroll', showVisibleImages)

    function showVisibleImages()
    {
        $('.grid-item.not-loaded:visible').each(function(i, el) {
            if (isOnScreen(el)) {
                var name = $(el).closest('.grid-item').data('title');
                var description = $(el).closest('.grid-item').data('description');
                var $img = $('<img src="' + $(el).data('src') + '" data-caption="' + description + '" title="' + name + '">');
                $img.on('load', function() {
                    $(this).animate({opacity: 1});
                    // $(this).closest('a').find('figure').remove();
                });
                $img.css({
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    opacity: 0
                });
                $(el).find('figure:visible').append($img);
                $(el).removeClass('not-loaded');
            }
        })
    }

    function isOnScreen(element)
    {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        $elem = $(element);
        var elemTop = $elem.offset().top;
        var elemBottom = elemTop + $elem.height();

        return ((elemTop <= docViewBottom) && (elemBottom >= docViewTop));
    }

    function getImageHtml(id, name, description, preview, original, tags, width, height)
    {
        return "<div data-width=\"" + width + "\" data-height=\"" + height + "\" data-src=\"" + preview + "\" class=\"grid-item not-loaded " + Object.values(tags).map(function(i) {return transliterate(i); }).join(' ') + "\" data-id=\"" + id + "\" fancybox data-tags=\"" + JSON.stringify(tags) + "\"><a href=\"/img/upload/" + original + "\" data-caption=\"getCaption( " + id + " )\" data-title=\"Title\"><figure style=\"width:" + width + "px; height:" + height + "px\"></figure></a></div>";
    }

    var addTag = function(tag) {
        var tagsURIMatch = decodeURIComponent(window.location.href).match(/\/tags\/[А-Яа-я,_]+/);
        if (tagsURIMatch) {
            var newTagURI = tagsURIMatch[0] + ',' + tag;
        } else {
            var newTagURI = '/tags/' + tag;
        }
        history.pushState(null, '', window.location.origin + newTagURI);
        selector += ('.' + transliterate(tag));
    }

    var removeTag = function(tag)
    {
        var tagsURI = decodeURIComponent(window.location.href).match(/\/tags\/[А-Яа-я,_]+/)[0];
        if (tagsURI) {
            var tags = tagsURI.replace('/tags/', '').split(',').filter(function(i) { return i != tag; });
            var newTagURI = '/tags/' + tags.join(',');
        } else {
            var newTagURI = '/tags/';
        }
        history.pushState(null, '', window.location.origin + newTagURI);
        selector = selector.replace('.' + transliterate(tag), '');
    }

    var toggleTag = function(tagId)
    {
        tagId = tagId.toString();
        if (selector.split('.').indexOf(transliterate(tagId)) == -1)
        {
            addTag(tagId);
        } else {
            removeTag(tagId);
        }
        return false;
    }

    $('body').on('click', '.tag', function(e) {
        toggleTag($(this).data('id'));
        $(this).toggleClass('selected');
        rearrangeGrid();
        return false;
    });

    $(document).ready(function() {
        showVisibleImages();
    });

    grid.on('arrangeComplete', function() {
        showVisibleImages();
    });

    window.onpopstate = function(event) {
        var selected = readSelectorFromURI();
        if (selected.length > 0) {
            grid.isotope({
                filter: '.' + readSelectorFromURI().join('.')
            });
        } else {
            grid.isotope({
                filter: ''
            });
        }

        $('.tags .tag').removeClass('selected');
        for (let i in selected)
        {
            $('.tag[data-filter=".' + selected[i] + '"]').addClass('selected');
        }
    };

    window.onresize = showVisibleImages();

</script>
