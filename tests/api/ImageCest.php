<?php

use app\models\Image;
use app\tests\fixtures\ImageFixture;
use app\tests\fixtures\TagFixture;

class ImageCest
{
    private $url = '/api/images';

    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'image' => [
                'class' => ImageFixture::className(),
                'dataFile' => codecept_data_dir() . 'image.php'
            ],
            'tag' => [
                'class' => TagFixture::className(),
                'dataFile' => codecept_data_dir() . 'tag.php'
            ]
        ]);
    }

    public function testIndex(ApiTester $I)
    {
        $I->sendGET("api/images?access-token=" . $this->getToken());
        $I->seeResponseContains("image1");
        $I->seeResponseContains("image2");
        $I->seeResponseContains("image3");
    }

    public function testPOST(ApiTester $I)
    {
        $I->sendPOST("/api/images?access-token=incorrecttoken", [], ['image' => codecept_data_dir() . '/testImage.jpg']);
        $I->seeResponseContains("invalid credentials");
        $I->seeResponseCodeIs(401);


        $I->sendPOST("/api/images?access-token=" . $this->getToken(), [], ['image' => codecept_data_dir() . '/testImage.jpg']);
        $I->dontSeeResponseContains("invalid credentials");
        $I->seeResponseCodeIs(200);

        $I->sendGET("/img/upload/4e1bb05c7b47a41d2dd98396ccd6f843.JPEG");
        $I->seeBinaryResponseEquals('a56eaba6f7c7305b8175ca3b2a1d305a', 'md5');
    }

    public function testPATCH(ApiTester $I)
    {
        $I->sendPATCH("/api/images/9999?access-token=" . $this->getToken(), ["id" => 4, "name" => "image4", "thumb" => "thumb"]);

        $I->sendPATCH("/api/images/1?access-token=" . $this->getToken(), ["id" => 4, "name" => "image4", "thumb" => "thumb"]);
        $I->seeResponseContainsJson(["name" => "image4"]);
        $I->dontSeeResponseContainsJson(["thumb" => "thumb"]);
        $I->dontSeeResponseContainsJson(["name" => "image1"]);
        $I->dontSeeResponseContainsJson(["id" => 4]);
    }

    public function testDELETE(ApiTester $I)
    {
        $I->seeRecord("\app\models\Image", ["id" => 1]);
        $I->sendDELETE("/api/images/1?access-token=" . $this->getToken());
        $I->dontSeeRecord("\app\models\Image", ["id" => 1]);
        $I->seeResponseCodeIs(204);

        $I->sendGET('/api/images?access-token=bIyzsKKBukkYDq8nPp5q3pfswrufYTOj');
        $I->dontSeeResponseContainsJson(["id" => 1, "name" => "image4"]);

        $I->sendDELETE("/api/images/9999?access-token=" . $this->getToken());
    }

    public function testBindTag(ApiTester $I)
    {
        $I->dontSeeInDatabase('image_has_tag', ['image_id' => 1, 'tag_id' => 1]);

        $I->sendPOST("/api/images/1/tags/tag1?access-token=" . $this->getToken());
        $I->seeInDatabase('image_has_tag', ['image_id' => 1, 'tag_id' => 1]);
        $I->seeResponseCodeIs(200);

        $I->sendPOST("/api/images/1/tags/notagwithsuchname?access-token=" . $this->getToken());
        $I->seeResponseCodeIs(404);

        $I->sendPOST("/api/images/999/tags?access-token=" . $this->getToken(), ['name' => 'tag1']);
        $I->seeResponseCodeIs(404);
    }

    public function testUnbindTag(ApiTester $I)
    {
        $I->seeInDatabase("image_has_tag", ['image_id' => 1, 'tag_id' => 1]);
        $I->sendDELETE("/api/images/1/tags/tag1?access-token=" . $this->getToken());
        $I->DontSeeInDatabase("image_has_tag", ['image_id' => 1, 'tag_id' => 1]);
        $I->seeResponseCodeIs(200);

        $I->sendDELETE("/api/images/1/tags/notagwithsuchname?access-token=" . $this->getToken());
        $I->seeResponseCodeIs(404);

        $I->sendDELETE("/api/images/999/tags/tag1?access-token=" . $this->getToken());
        $I->seeResponseCodeIs(404);
    }

    public function testFilesIsDeleted(ApiTester $I)
    {
        $I->sendPOST("/api/images?access-token=". $this->getToken(), [], ['image' => codecept_data_dir() . '/testImage.jpg']);
        $I->seeResponseCodeIs(200);

        $response = (json_decode($I->grabResponse()))[0];

        $imageId = $response->id;

        $I->sendDELETE("/api/images/$imageId?access-token=" . $this->getToken());

        $I->sendGET("/img/upload/" . $response->orig);
        $I->seeResponseCodeIs(404);

        $I->sendGET("/img/upload/" . $response->preview);
        $I->seeResponseCodeIs(404);

        $I->sendGET("/img/upload/" . $response->thumb);
        $I->seeResponseCodeIs(404);
    }

    private function getToken() : string
    {
        return \Yii::$app->params['accessToken'];
    }
}
