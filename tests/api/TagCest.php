<?php

use app\tests\fixtures\TagFixture;

class TagCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'tag' => [
                'class' => TagFixture::className(),
                'dataFile' => codecept_data_dir() . 'tag.php'
            ]
        ]);
    }

    // tests
    public function testCreate(ApiTester $I)
    {
        $I->dontSeeRecord('\app\models\Tag', ['name' => 'newtag']);
        $I->sendPOST("/api/tags/newtag?access-token=" . $this->getToken());
        $I->seeRecord('\app\models\Tag', ['name' => 'newtag']);
        $I->seeResponseCodeIs(200);
    }

    public function testDelete(ApiTester $I)
    {
        $I->seeRecord('\app\models\Tag', ['name' => 'tag1']);
        $I->sendDELETE("/api/tags/tag1?access-token=" . $this->getToken(), );
        $I->dontSeeRecord('\app\models\Tag', ['name' => 'tag1']);
        $I->seeResponseCodeIs(204);

        $I->sendDELETE("/api/tags/notagwithsuchname?access-token=" . $this->getToken());
        $I->seeResponseCodeIs(404);
    }

    private function getToken() : string
    {
        return \Yii::$app->params['accessToken'];
    }
}
