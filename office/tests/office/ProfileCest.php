<?php

namespace office\tests\api;

use common\fixtures\TokenFixtures;
use common\fixtures\UserFixture;
use office\tests\ApiTester;

class ProfileCest
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
    public function access(ApiTester $i)
    {
        $i->sendGet('/profile');
        $i->seeResponseCodeIs(401);
    }

    public function authenticated(ApiTester $i)
    {
        $i->amBearerAuthenticated('token-correct');
        $i->sendGet('/profile');
        $i->seeResponseCodeIs(200);
        $i->seeResponseContainsJson([
            'id' => 1,
            'username' => 'erau',
            'email' => 'sfriesen@jenkins.info',
        ]);
    }

    public function expired(ApiTester $i)
    {
        $i->amBearerAuthenticated('token-expired');
        $i->sendGet('/profile');
        $i->seeResponseCodeIs(401);
    }
}