<?php

namespace office\tests\office;

use office\tests\ApiTester;

class HomeCest
{
    public function mainPage(ApiTester $i)
    {
        $i->sendGet('/');
        $i->seeResponseCodeIs(200);
        $i->seeResponseIsJson();
    }
}