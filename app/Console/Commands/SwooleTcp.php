<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwooleTcp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole-tcp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试树莓派的tcp连接模式';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //创建Server对象，监听 127.0.0.1:9501端口
        $serv = new \Swoole\Server("127.0.0.1", 9501);
        $serv->set(array(
            'package_max_length' => '8192',
            'open_eof_split'     => true,
            'package_eof'        => "\r\n"
        ));
        //监听连接进入事件
        $serv->on('Connect', function ($serv, $fd) {
            echo "Client: Connect.\n" . $fd;
            $serv->send($fd, "client");
        });

        //监听数据接收事件
        $serv->on('Receive', function ($serv, $fd, $from_id, $data) {
            // echo "#### onReceive ####" . PHP_EOL;
            // $data = $this->bytesToStr($data);
            var_dump($data);
            $json = json_decode($data,true);
            var_dump($json);
            if (isset($json['fd'])) {
                // $serv->send($fd, "Server: " . $data . "to:" . $fd . '-' . $from_id);
                $fd = $json['fd'];
            }
            $serv->send($fd, "Server: " . $data."to:".$fd.'-'. $from_id);
        });

        //监听连接关闭事件
        $serv->on('Close', function ($serv, $fd) {
            echo $fd."##Client: Close.\n";
        });

        //启动服务器
        $serv->start(); 
    }
}
