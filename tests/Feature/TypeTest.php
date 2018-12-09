<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $token = md5(md5('1-SMZ-admin'));
        // 列表
        $response = $this->withHeaders(['Authorization'=>$token])->json('get','/c-api/type/list');
        // 单条
        // $response = $this->withHeaders(['Authorization'=>$token])->json('post','/c-api/type/detail',['type_id'=>2]);
        $res = $response->content();
        dd(json_decode($res));
    }
}
