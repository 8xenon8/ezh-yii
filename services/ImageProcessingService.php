<?php

namespace app\services;

use \app\models\Image;

class ImageProcessingService
{
	private $watermarkFilepath = __DIR__ . '/../web/img/watermark.png';
	private $uploadDir = __DIR__ . '/../web/img/upload/';

	public function processImage($file) : Image
	{
		if (!file_exists($file))
		{
			throw new \Exception("File does not exists");
		}

        $image = new \Imagick();
		$image->readImage($file);

		// Create instance of the Watermark image
		$watermark = new \Imagick();
		$watermark->readImage($this->watermarkFilepath);

		// Get image aspect ratio
		// 
		// The start coordinates where the file should be printed
		// $x = 0;
		// $y = 0;

		// Draw watermark on the image file with the given coordinates
		// $image->compositeImage($watermark, \Imagick::COMPOSITE_OVER, $x, $y);

		// Generate new name by file hash
		$newname  = md5_file($file);

		// Save original image
		$origName = $newname . "." . $image->getImageFormat();
		$previewName = 'pr_' . $origName;
		$thumbnailName = 'tn_' . $origName;

		$image->writeImage($this->uploadDir . $origName);

		// Save preview image
		$preview = $image->clone();
		$preview->scaleImage(300, 300, true);
		$preview->writeImage($this->uploadDir . $previewName);

		// Save thumb image
		$thumbnail = $image->clone();
		$thumbnail->scaleImage(150, 150, true);
		$thumbnail->writeImage($this->uploadDir . $thumbnailName);

		/**
		 * @var \app\models\Image $imageAr
		 */
		$imageAr = new Image();
		$imageAr->orig = $origName;
		$imageAr->orig_width = $image->getImageWidth();
		$imageAr->orig_height = $image->getImageHeight();
		$imageAr->preview = $previewName;
		$imageAr->preview_width = $preview->getImageWidth();
		$imageAr->preview_height = $preview->getImageHeight();
		$imageAr->thumb = $thumbnailName;
		$imageAr->thumb_width = $thumbnail->getImageWidth();
		$imageAr->thumb_height = $thumbnail->getImageHeight();

		if (!$imageAr->save())
		{
			throw new \Exception(implode("\n", array_map(function($i) { return implode("\n", $i); }, $imageAr->getErrors())));
		}

		return $imageAr;
	}

	public function deleteImageFiles(\app\models\Image $image) : void
	{
		unlink(\Yii::$app->params['uploadPath'] . $image->orig);
		unlink(\Yii::$app->params['uploadPath'] . $image->preview);
		unlink(\Yii::$app->params['uploadPath'] . $image->thumb);
	}
}