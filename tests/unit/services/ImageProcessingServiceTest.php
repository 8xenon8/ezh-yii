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

	private $expectedOrigName = "4e1bb05c7b47a41d2dd98396ccd6f843.JPEG";
	private $expectedPreviewName = "pr_4e1bb05c7b47a41d2dd98396ccd6f843.JPEG";
	private $expectedThumbnailName = "tn_4e1bb05c7b47a41d2dd98396ccd6f843.JPEG";

	public function _before()
	{
		$this->clear();
	}

	public function _after()
	{
		$this->clear();
	}

	public function testProcessImage()
	{
		$service = new \app\services\ImageProcessingService();

		$this->assertFalse(file_exists($this->getUploadDir() . $this->expectedOrigName), "Ensure that original file does not exists");
		$this->assertFalse(file_exists($this->getUploadDir() . $this->expectedPreviewName), "Ensure that preview file does not exists");
		$this->assertFalse(file_exists($this->getUploadDir() . $this->expectedThumbnailName), "Ensure that thumb file does not exists");
        
        $this->imageAr = $service->processImage($this->filename);
		$this->assertEquals($this->imageAr->orig, $this->expectedOrigName);

		$this->assertEquals($this->imageAr->orig, $this->expectedOrigName, "Processed image name equals expected");
		$this->assertEquals($this->imageAr->preview, $this->expectedPreviewName, "Processed image name equals expected");
		$this->assertEquals($this->imageAr->thumb, $this->expectedThumbnailName, "Processed image name equals expected");

		$this->assertTrue(file_exists($this->getUploadDir() . $this->expectedOrigName), "Ensure that original file was created");
		$this->assertTrue(file_exists($this->getUploadDir() . $this->expectedPreviewName), "Ensure that preview file was created");
		$this->assertTrue(file_exists($this->getUploadDir() . $this->expectedThumbnailName), "Ensure that thumb file was created");
	}

	public function testDeleteImage()
	{
		$uploadPath = \Yii::$app->params['uploadPath'];

		$service = new \app\services\ImageProcessingService();

		$image = $service->processImage($this->filename);

		$this->assertTrue(file_exists($this->getUploadDir() . $image->orig));
		$this->assertTrue(file_exists($this->getUploadDir() . $image->preview));
		$this->assertTrue(file_exists($this->getUploadDir() . $image->thumb));

		$image->delete();

		$this->assertFalse(file_exists($this->getUploadDir() . $image->orig));
		$this->assertFalse(file_exists($this->getUploadDir() . $image->preview));
		$this->assertFalse(file_exists($this->getUploadDir() . $image->thumb));
	}

    protected function clear()
    {
        if (file_exists($this->getUploadDir() . $this->expectedOrigName)) { unlink($this->getUploadDir() . $this->expectedOrigName); }
        if (file_exists($this->getUploadDir() . $this->expectedPreviewName)) { unlink($this->getUploadDir() . $this->expectedPreviewName); }
        if (file_exists($this->getUploadDir() . $this->expectedThumbnailName))  { unlink($this->getUploadDir() . $this->expectedThumbnailName); } 
	}
	
	protected function getUploadDir()
	{
		return \Yii::$app->params['uploadPath'];
	}

}