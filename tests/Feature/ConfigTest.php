<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfigTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $token = md5(md5('1-SMZ-admin'));
        $response = $this->withHeaders(['Authorization'=>$token])->json('get','/c-api/config/get');
        $res = $response->content();
        dd(json_decode($res));
    }
}