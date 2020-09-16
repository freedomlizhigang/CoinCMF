<?php

namespace App\Console\Commands;

use App\Modbus\PhpType;
use App\Modbus\ModbusMaster;
use Illuminate\Console\Command;
use ModbusTcpClient\Network\NonBlockingClient;
use ModbusTcpClient\Composer\Read\ReadRegistersBuilder;

class SwooleClientBus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole-client-bus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // Modbus master UDP
        $modbus = new ModbusMaster("192.168.72.6", "TCP", 502);
        // Read multiple registers
        try {
            // $recData1 = $modbus->writeSingleRegister(1, 0, [3]);
            // $recData2 = $modbus->writeSingleCoil(1, 1, [1]);
            // $recData1 = $modbus->readMultipleRegisters(1, 0, 1);
            $recData2 = $modbus->readMultipleRegisters(1, 3, 1);
        } catch (\Exception $e) {
            // Print error information if any
            dump($modbus);
            dd($e->getLine() . ':' . $e->getMessage());
            exit;
        }
        // Print data in string format
        // dd($recData1);
        // dump(PhpType::bytes2signedInt($recData1)); 
        dump(PhpType::bytes2signedInt($recData2)); 
    }
}
