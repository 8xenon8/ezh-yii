<?php
/**
 * Created by PhpStorm.
 * User: Xenon
 * Date: 16.12.2019
 * Time: 4:43
 */

namespace app\modules\api\controllers;

use app\services\ImageProcessingService;
use yii\rest\Action;
use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use yii\rest\UpdateAction;
use yii\web\UploadedFile;
use app\models\Image;

require_once __DIR__ . '/actions/TagActions.php';

/**
 * Class ImageController
 * @package app\modules\api\controllers
 */
class ImageController extends ActiveController
{
    public $modelClass = \app\models\Image::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);

        $actions['toggleTag'] = [
            'class' => '\app\modules\api\controllers\ToggleTagAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

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

        foreach ($files as $file) {
            $service = new ImageProcessingService();
            $images[] = $service->processImage($file);
        }

        if (empty($images)) {
            \Yii::$app->response->setStatusCode(400);
        }

        return $images;
    }
}