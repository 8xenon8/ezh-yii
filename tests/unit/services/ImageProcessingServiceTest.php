<?php

namespace tests\unit\services;

use yii\web\UploadedFile;

class ImageProcessingServiceTest extends \Codeception\Test\Unit
{
	private $filename = "/files/imageProcessingServiceTestFile.jpg";
	private $uploadDir = __DIR__ . "/../../../web/img/upload/";

    /**
     * @var \app\models\Image $imageAr;
     */
    private $imageAr;

	private $expectedOrigName = "4e1bb05c7b47a41d2dd98396ccd6f843.JPEG";
	private $expectedPreviewName = "pr_4e1bb05c7b47a41d2dd98396ccd6f843.JPEG";
	private $expectedThumbnailName = "tn_4e1bb05c7b47a41d2dd98396ccd6f843.JPEG";

	protected function _before()
	{
        $this->clear();
	}

	public function testProcessImage()
	{
		$service = new \app\services\ImageProcessingService();
		$filename = __DIR__ . $this->filename;

		$this->assertFalse(file_exists($this->uploadDir . $this->expectedOrigName), "Ensure that original file does not exists");
		$this->assertFalse(file_exists($this->uploadDir . $this->expectedPreviewName), "Ensure that preview file does not exists");
		$this->assertFalse(file_exists($this->uploadDir . $this->expectedThumbnailName), "Ensure that thumb file does not exists");
        
        $this->imageAr = $service->processImage($filename);
		$this->assertEquals($this->imageAr->orig, $this->expectedOrigName);

		$this->assertTrue(file_exists($this->uploadDir . $this->expectedOrigName), "Ensure that original file was created");
		$this->assertTrue(file_exists($this->uploadDir . $this->expectedPreviewName), "Ensure that preview file was created");
		$this->assertTrue(file_exists($this->uploadDir . $this->expectedThumbnailName), "Ensure that thumb file was created");
	}

    protected function _after()
    {
        $this->clear();
    }

    protected function clear()
    {
        if (file_exists($this->uploadDir . $this->expectedOrigName)) { unlink($this->uploadDir . $this->expectedOrigName); }
        if (file_exists($this->uploadDir . $this->expectedPreviewName))  { unlink($this->uploadDir . $this->expectedPreviewName); }
        if (file_exists($this->uploadDir . $this->expectedThumbnailName))  { unlink($this->uploadDir . $this->expectedThumbnailName); }
    }

}