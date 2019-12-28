<?php
/**
 * Created by PhpStorm.
 * User: Xenon
 * Date: 16.12.2019
 * Time: 4:43
 */

namespace app\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * Class ImageController
 * @package app\modules\api\controllers
 */
class ImageController extends ActiveController
{
    public $modelClass = 'app\models\Image';

    public function actions()
    {
        return [];
    }

    protected function verbs(){
        return [
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH','POST'],
            'delete' => ['DELETE'],
            'view' => ['GET'],
            'index'=>['GET'],
        ];
    }

    public function actionCreate()
    {
        die('213');
    }
}