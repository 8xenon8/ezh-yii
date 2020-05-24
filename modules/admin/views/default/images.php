<?= \richardfan\sortable\SortableGridView::widget([
    'dataProvider' => $dataProvider,

    // you can choose how the URL look like,
    // but it must match the one you put in the array of controller's action()
    'sortUrl' => \yii\helpers\Url::to(['sortItem']),

    'columns' => [
        // Data Columns
    ],
]); ?>