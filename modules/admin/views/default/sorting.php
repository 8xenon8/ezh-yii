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
</style>


<div class="grid-sorting">
    <div class="sort-wrap">
        <?php

        foreach ($dataProvider->query->all()     as $index => $image)
        {
            ?>
            <figure data-id="<?= $image['id']; ?>"  data-order="<?= $image['order']; ?>" draggable="true" class="img-rounded" style="width: 150px; height: 150px; overflow: hidden; display: inline-block;">
                <img draggable="false" src="/img/upload/<?= $image['preview']; ?>" <?php if ($image['orig_height'] <= $image['orig_width']) {?>height="150" <?php } else { ?>width="150"<?php } ?>>
            </figure>
            <?
        }

        ?>
        <br clear="both">
    </div>
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

            var draggableOrder = $(dragSrcEl).closest('figure').data('order');
            var droppableOrder = $(this).data('order');

            var draggable = document.querySelector('figure[data-order="' + draggableOrder + '"]');
            var droppable = document.querySelector('figure[data-order="' + droppableOrder + '"]');

            if (draggableIndex > droppableIndex) {
                droppable.before(draggable);
                insertType = 0;
            } else {
                droppable.after(draggable);
                insertType = 1;
            }

            $.ajax({
                type: "PATCH",
                url: "/api/image/" + draggableId + "?access-token=<?= \Yii::$app->params['accessToken'] ?>",
                data: {
                    "insertable": draggableOrder,
                    "order": droppableOrder,
                    "insertType": insertType
                },
                success: function(data) {
                    // console.log(data);
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

</script>   
