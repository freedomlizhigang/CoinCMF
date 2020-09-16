<?php

namespace App\Console\Commands\Swoole;

use Illuminate\Console\Command;

class SwooleClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole-client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Swoole Tcp客户端';

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
        dd(1);
        $client = new \Swoole\Client(SWOOLE_SOCK_TCP);
        $client->set(array(
            'package_max_length' => '8192',
            'open_eof_split'     => true,
            'package_eof'        => "\r\n"
        ));
        if (!$client->connect('47.96.13.76', 9509, -1)) {
            dd("connect failed. Error: {$client->errCode}\n");
        }
        // Log::info('发送参数' . json_encode(["fd" => $fd, "type" => 2, "sn" => $sn, "pin" => $pin]));
        $msg_info = base_convert("40002", 10, 16);
        $res      = $client->send($msg_info);
        // Log::info(json_encode($res));
        dump($res);
        dump(base_convert($res, 16, 10));
        $client->close();
    }
}
