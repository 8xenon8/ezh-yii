<script src="/js/jquery.min.js"></script>

<style>
    .img-rounded
    {
        position: relative;
    }

    .grid-sorting
    {
        text-align: left;
        transition-duration: 0.3s;
    }

    .grid-sorting figure
    {
        transition-duration: 0.3s;
        float: left;
        margin: 5px;
    }

    .droppableBefore:before
    {
        position: absolute;
        content: "";
        width: 1px;
        height: 100%;
        border: 3px solid red;
        border-radius: 3px;
        left: 0;
        top: 0;
    }

    .droppableAfter:after
    {
        position: absolute;
        content: "";
        width: 1px;
        height: 100%;
        border: 3px solid red;
        border-radius: 3px;
        right: 0;
        top: 0;
    }

    #edit-image-tab
    {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 500px;
        background: white;
        padding: 30px;
        margin-bottom: 0;
    }

    #edit-image-tab {
        display: none;
    }

    #image_wrapper {
        text-align: center;
    }
</style>


<div class="grid-sorting">
    <div class="sort-wrap">
        <?php foreach ($dataProvider->query->all() as $index => $image) : ?>
            <figure data-id="<?= $image['id']; ?>"  data-order="<?= $image['order']; ?>" draggable="true" class="img-rounded" style="width: 150px; height: 150px; overflow: hidden; display: inline-block;">
                <img draggable="false" src="/img/upload/<?= $image['preview']; ?>" <?php if ($image['orig_height'] <= $image['orig_width']) : ?>height="150" <?php else : ?>width="150"<?php endif; ?>>
            </figure>
        <?php endforeach; ?>
        <br clear="both">
    </div>
</div>

<div id="edit-image-tab" class="panel panel-default">
    <div class="col-md-1"></div>
    <div class="col-md-3">
        <div id="image_wrapper"></div>
    </div>
        <div class="col-md-4">
            <form role="form">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label for="description">Comment:</label>
                    <textarea class="form-control" rows="10" id="description"></textarea>
                </div>
                <div class="form-group float-left">
                    <label>
                        <input type="checkbox" name="publish" id="publish"> Is published
                    </label>
                </div>
                <div class="form-group float-right">
                    <input type="submit" class="btn btn-success" value="Submit"/>
                    <input id="close-edit-tab" style="float: right" type="button" class="btn btn-danger" value="Close"/>
                </div>
            </form>
        </div>
    <div class="col-md-2"></div>
</div>

<script>
    var dragSrcEl = null;
    var draggableId = null;

    function handleDragStart(e) {
        dragSrcEl = this;
        draggableId = this.getAttribute('data-id');

        this.classList.add('dragElem');
    }
    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault();
        }
        this.classList.add('over');
        this.classList.remove('dragElem');

        return false;
    }

    function handleDragEnter(e) {
        $('.droppableBefore').removeClass('droppableBefore');
        $('.droppableAfter').removeClass('droppableAfter');

        var stub = $('.drag-stub')[0] ? $('.drag-stub') : $('<figure data-id="-1" draggable="true" class="img-rounded drag-stub" style="width: 150px; height: 150px; overflow: hidden; display: inline-block;">');

        var draggableIndex = $(dragSrcEl).closest('figure').index();
        var droppableIndex = $(this).index();

        if (draggableIndex == droppableIndex)
        {
            return;
        }

        if (draggableIndex > droppableIndex) {
            $(this).addClass('droppableBefore');

        } else if (draggableIndex < droppableIndex) {
            $(this).addClass('droppableAfter');
        }
    }

    function handleDragLeave(e) {
        $('.droppableBefore').removeClass('droppableBefore');
        $('.droppableAfter').removeClass('droppableAfter');
        this.classList.remove('over');
    }

    function handleDrop(e) {

        if (e.stopPropagation) {
            e.stopPropagation();
        }

        if (dragSrcEl != this) {

            var insertType;

            var draggableId = $(dragSrcEl).closest('figure').data('id');

            var draggableIndex = $(dragSrcEl).closest('figure').index();
            var droppableIndex = $(this).index();

            var draggable = document.querySelector('figure[data-order="' + (draggableIndex + 1) + '"]');
            var droppable = document.querySelector('figure[data-order="' + (droppableIndex + 1) + '"]');

            if (draggableIndex > droppableIndex) {
                droppable.before(draggable);
                insertType = 0;
            } else {
                droppable.after(draggable);
                insertType = 1;
            }

            $.ajax({
                type: "PATCH",
                url: "/api/images/" + draggableId + "?access-token=<?= \Yii::$app->params['accessToken'] ?>",
                data: {
                    "insertable": draggableIndex + 1,
                    "order": droppableIndex + 1,
                    "insertType": insertType
                },
                success: function(data) {
                    let order = 1;

                    $('figure.img-rounded').each(function(i, e) {
                        $(this).attr('data-order', order++);
                    });
                },
            });
        }
        this.classList.remove('over');
        return false;
    }

    function handleDragEnd(e) {
        this.classList.remove('over');
        $('.droppableBefore').removeClass('droppableBefore');
        $('.droppableAfter').removeClass('droppableAfter');
        $('.drag-stub, .movingStub').remove();
    }

    function addDnDHandlers(elem) {
        elem.addEventListener('dragstart', handleDragStart, false);
        elem.addEventListener('dragenter', handleDragEnter, false)
        elem.addEventListener('dragover', handleDragOver, false);
        elem.addEventListener('dragleave', handleDragLeave, false);
        elem.addEventListener('drop', handleDrop, false);
        elem.addEventListener('dragend', handleDragEnd, false);
    }

    var cols = document.querySelectorAll('.grid-sorting figure');
    [].forEach.call(cols, addDnDHandlers);

    $('.img-rounded').dblclick(getImageData);

    function getImageData() {
        var id = $(this).data('id');

        console.log(id);

        showLoader();

        $.ajax({
            type: "GET",
            url: "/api/images/" + id + "?access-token=<?= \Yii::$app->params['accessToken'] ?>",
            success: function(data) {
                hydrateEditTab(data);
                $('#edit-image-tab').show();
            },
            failure: function(data) {
                PNotify.error("Can't load data for image #" + id);
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function showLoader() {
        $('#loader').show();
    }

    function hideLoader() {
        $('#loader').hide();
    }

    function hydrateEditTab(data) {
        $('#edit-image-tab #image_wrapper').html('');
        var img = $('<img src="/img/upload/' + data.preview + '" width="' + data.preview_width + '" height="' + data.preview_height + '">');
        $('#edit-image-tab #image_wrapper').append(img);

        $('#edit-image-tab #name').val(data.name ? data.name : '');
        $('#edit-image-tab #description').val(data.description ? data.description : '');

        if (data.publish) {
            $('#edit-image-tab #publish').attr('checked', 'checked');
        }
    }

    $('#close-edit-tab').click(function() {
        $('#edit-image-tab').hide();
    })
</script>