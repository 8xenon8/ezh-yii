<?php
/**
 * Created by PhpStorm.
 * User: Xenon
 * Date: 16.12.2019
 * Time: 5:01
 */

namespace app\modules\api\controllers;


use yii\rest\ActiveController;

class TagController extends ActiveController
{
    public $modelClass = 'app\models\Tag';
}