<?php

namespace app\modules\api;

use yii\web\Response;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        \Yii::$app->setComponents([
            'response' => [
                'class'=>'yii\web\Response',
                'format' =>  Response::FORMAT_JSON,
                'formatters' => [
                    Response::FORMAT_JSON => [
                        'class' => 'yii\web\JsonResponseFormatter',
                        'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                        //'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                    ],
                ],
            ],
        ]);

        \Yii::$app->response->on(Response::EVENT_BEFORE_SEND, function ($event) {
            $response = $event->sender;
            if ($response->statusCode == 204)
            {
                $response->setStatusCode($response->isSuccessful ? 200 : 500);
            }
            $response->data = [
                'success' => $response->isSuccessful,
                'data' => $response->data
            ];
        });
    }
}
