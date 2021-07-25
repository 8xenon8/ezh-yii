<?php

namespace app\services;

use app\models\Image;
use yii\web\UploadedFile;

class ImageService
{
	private $watermarkFilepath = __DIR__ . '/../web/img/watermark.png';
	private $uploadDir = __DIR__ . '/../web/img/upload/';

	public function processImage(UploadedFile $file) : Image
	{
	    $filename = $file->tempName;

		if (!file_exists($filename))
		{
			throw new \Exception("File does not exists");
		}

        $image = new \Imagick();
		$image->readImage($filename);

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
		$newName  = md5_file($filename);

		// Save original image
		$origName = $newName . "." . $image->getImageFormat();
		$previewName = 'pr_' . $origName;
		$thumbnailName = 'tn_' . $origName;

		$image->writeImage($this->uploadDir . $origName);

        /**
         * @var Image $imageAr
         */
        $imageAr = new Image();
        $imageAr->scenario = 'create';

		// Save preview image
        $image->scaleImage(300, 300, true);
        $image->writeImage($this->uploadDir . $previewName);
        $imageAr->preview_width = $image->getImageWidth();
        $imageAr->preview_height = $image->getImageHeight();

		// Save thumb image
        $image->scaleImage(150, 150, true);
        $image->writeImage($this->uploadDir . $thumbnailName);
        $imageAr->thumb_width = $image->getImageWidth();
        $imageAr->thumb_height = $image->getImageHeight();
		$imageAr->orig = $origName;
		$imageAr->orig_width = $image->getImageWidth();
		$imageAr->orig_height = $image->getImageHeight();
		$imageAr->preview = $previewName;
		$imageAr->thumb = $thumbnailName;

		return $imageAr;
	}

	public function deleteImageFiles(Image $image) : void
	{
		if (file_exists(\Yii::$app->params['uploadPath'] . $image->orig)) { unlink(\Yii::$app->params['uploadPath'] . $image->orig); }
		else { \Yii::warning("Missing original file for image $image->name ($image->id)"); }

		if (file_exists(\Yii::$app->params['uploadPath'] . $image->preview)) { unlink(\Yii::$app->params['uploadPath'] . $image->preview); }
		else { \Yii::warning("Missing preview file for image $image->name ($image->id)"); }

		if (file_exists(\Yii::$app->params['uploadPath'] . $image->thumb)) { unlink(\Yii::$app->params['uploadPath'] . $image->thumb); }
		else { \Yii::warning("Missing thumbnail file for image $image->name ($image->id)"); }
	}
}