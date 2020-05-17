<?php

namespace tests\unit\services;

use \app\models\Image;

class ImageProcessingServiceTest extends \Codeception\Test\Unit
{
	private $filename = __DIR__ . "/files/imageProcessingServiceTestFile.jpg";

    /**
     * @var \app\models\Image $imageAr;
     */
	private $imageAr;
	private $uploadDir;

	private $expectedOrigName = "4e1bb05c7b47a41d2dd98396ccd6f843.JPEG";
	private $expectedPreviewName = "pr_4e1bb05c7b47a41d2dd98396ccd6f843.JPEG";
	private $expectedThumbnailName = "tn_4e1bb05c7b47a41d2dd98396ccd6f843.JPEG";

	public function testProcessImage()
	{
		$this->uploadDir = \Yii::$app->params['uploadPath'];

		$this->clear();

		$service = new \app\services\ImageProcessingService();
		$filename = $this->filename;

		$this->assertFalse(file_exists($this->uploadDir . $this->expectedOrigName), "Ensure that original file does not exists");
		$this->assertFalse(file_exists($this->uploadDir . $this->expectedPreviewName), "Ensure that preview file does not exists");
		$this->assertFalse(file_exists($this->uploadDir . $this->expectedThumbnailName), "Ensure that thumb file does not exists");
        
        $this->imageAr = $service->processImage($filename);
		$this->assertEquals($this->imageAr->orig, $this->expectedOrigName);

		$this->assertEquals($this->imageAr->orig, $this->expectedOrigName, "Processed image name equals expected");
		$this->assertEquals($this->imageAr->preview, $this->expectedPreviewName, "Processed image name equals expected");
		$this->assertEquals($this->imageAr->thumb, $this->expectedThumbnailName, "Processed image name equals expected");

		$this->assertTrue(file_exists($this->uploadDir . $this->expectedOrigName), "Ensure that original file was created");
		$this->assertTrue(file_exists($this->uploadDir . $this->expectedPreviewName), "Ensure that preview file was created");
		$this->assertTrue(file_exists($this->uploadDir . $this->expectedThumbnailName), "Ensure that thumb file was created");
		
        $this->clear();
	}

    protected function clear()
    {
        if (file_exists($this->uploadDir . $this->expectedOrigName)) { unlink($this->uploadDir . $this->expectedOrigName); }
        if (file_exists($this->uploadDir . $this->expectedPreviewName)) { unlink($this->uploadDir . $this->expectedPreviewName); }
        if (file_exists($this->uploadDir . $this->expectedThumbnailName))  { unlink($this->uploadDir . $this->expectedThumbnailName); } 
    }

}