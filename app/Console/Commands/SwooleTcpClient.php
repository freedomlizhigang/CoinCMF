<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwooleTcpClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole-tcp-client {fd?}';

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
        $fd = $this->argument('fd');
        $client = new \Swoole\Client(SWOOLE_SOCK_TCP);
        if (!$client->connect('47.96.13.76', 9508, -1)) {
            exit("connect failed. Error: {$client->errCode}\n");
        }
        $msg_info = json_encode(['fd' => $fd])."\r\n";
        $client->send($msg_info);
        // echo $client->recv();
        $client->close();
    }
}
