<?php

namespace office\tests\api;

use office\tests\ApiTester;
use common\fixtures\TokenFixtures;
use common\fixtures\UserFixture;

class AuthCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
            'token' => [
                'class' => TokenFixtures::class,
                'dataFile' => codecept_data_dir() . 'token.php'
            ]
        ]);
    }

    public function badMethod(ApiTester $I)
    {
        $I->sendGet('/auth');
        $I->seeResponseCodeIs(405);
        $I->seeResponseIsJson();
    }

    public function wrongCredentials(ApiTester $i)
    {
        $i->sendPost('/auth', [
            'username' => 'erau',
            'password' => 'wrong-pass',
        ]);
        $i->seeResponseCodeIs(422);
        $i->seeResponseContainsJson([
            'field' => 'password',
            'message' => 'Incorrect username or password.',
        ]);
    }

    public function success(ApiTester $i)
    {
        $i->sendPost('/auth',[
            'username' => 'erau',
            'password' => '12345678',
        ]);
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsJson();
        $i->seeResponseJsonMatchesJsonPath('$.token');
        $i->seeResponseJsonMatchesJsonPath('$.expired');
    }
}