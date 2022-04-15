<?php

namespace office\tests\api;

use common\fixtures\PostFixtures;

use common\fixtures\UserFixture;
use office\tests\ApiTester;

class PostCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
            'token' => [
                'class' => PostFixtures::class,
                'dataFile' => codecept_data_dir() . 'post.php'
            ]
        ]);
    }

    public function index(ApiTester $i)
    {
        $i->sendGet('/post');
        $i->seeResponseCodeIs(200);
        $i->seeResponseContainsJson([
            ['title' => 'First Post'],
            ['title' => 'Second Post'],
            ['title' => 'Third Post'],
        ]);
        $i->seeHttpHeader('X-Pagination-Total-Count', '3');
    }

    public function search(ApiTester $i)
    {
        $i->sendGet('/post?s[title]=First');
        $i->seeResponseCodeIs(200);
        $i->seeResponseContainsJson([
            'title' => 'First Post'
        ]);
        $i->dontSeeResponseContainsJson([
            'title' => 'Second Post'
        ]);
        $i->seeHttpHeader('X-Pagination-Total-Count', '1');
    }

    public function view(ApiTester $i)
    {
        $i->sendGet('/post/1');
        $i->seeResponseCodeIs(200);
        $i->seeResponseContainsJson([
            'title' => 'First Post'
        ]);
    }

    public function viewNotFound(ApiTester $i)
    {
        $i->sendGet('/post/15');
        $i->seeResponseCodeIs(404);
    }
    public function readonly(ApiTester $i)
    {
        $i->sendPatch('/post/15', [
            'title' => 'New'
        ]);
        $i->seeResponseCodeIs(405);
    }

}