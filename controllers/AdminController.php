<?php

namespace app\controllers;

use app\models\Image;
use richardfan\sortable\SortableAction;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class AdminController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Image::find()->where(['publish' => true]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'order' => SORT_DESC
                ]
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $provider
        ]);
    }

    public function actions()
    {
        return [
            'sortItem' => [
                'class' => SortableAction::class,
                'activeRecordClassName' => Image::class,
                'orderColumn' => 'order',
            ],
        ];
    }

}
