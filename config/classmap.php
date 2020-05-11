<?php

$customClasses = [
	'app\services\ImageProcessingService' => 'services/ImageProcessingService'
];

Yii::$classMap = array_merge(Yii::$classMap, $customClasses);