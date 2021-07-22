<?php

namespace app\modules\api;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

//    /**
//     * {@inheritdoc}
//     */
//    public function init()
//    {
//        parent::init();
//
//        \Yii::configure($this, [
//            'components' => [
//                'response' => [
//                    'class' => 'yii\web\Response',
//                    'on beforeSend' => function ($event) {
//                        $response = $event->sender;
//                        if ($response->data !== null && Yii::$app->request->get('suppress_response_code')) {
//                            $response->data = [
//                                'success' => $response->isSuccessful,
//                                'data' => $response->data,
//                            ];
//                            $response->statusCode = 200;
//                        }
//                    },
//                ],
//            ],
//        ]);
//    }

    public function afterAction($action, $result)
    {


        return parent::afterAction($action, $result);
    }
}
