<?php
/**
 * Created by PhpStorm.
 * User: Xenon
 * Date: 16.12.2019
 * Time: 4:43
 */

namespace app\modules\api\controllers;

use app\services\ImageService;
use yii\rest\Action;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use yii\rest\UpdateAction;
use yii\web\UploadedFile;
use app\models\Image;

/**
 * Class ImageController
 * @package app\modules\api\controllers
 */
class ImageController extends ActiveController
{
    public $modelClass = Image::class;
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);

        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                QueryParamAuth::className(),
            ],
            'except' => ['index']
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $files = UploadedFile::getInstancesByName("image");
        $images = [];

        $order = Image::find()->count() + 1;

        foreach ($files as $file) {
            $service = new ImageService();
            $image = $service->processImage($file);

            $image->order = $order;

            if (!$image->save())
            {
                throw new \Exception(implode("\n", array_map(function($i) { return implode("\n", $i); }, $image->getErrors())));
            }

            $order++;

            $images[] = $image;
        }

        if (empty($images)) {
            \Yii::$app->response->setStatusCode(400);
        }

        return $images;
    }
}