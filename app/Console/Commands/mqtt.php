<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class SubscribeToTopic extends Command
{
    private $database;

    // public function __construct()
    // {
    //     $this->database = \App\Services\FirebaseService::connect();
    // }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe To MQTT topic';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->database = \App\Services\FirebaseService::connect();
        $mqtt = MQTT::connection();
        $mqtt->subscribe('joy/test', function(string $topic, string $message) {
            $this->database
            ->getReference('test')
            ->set([
                'title' => $message,
                'content' => $message
            ]);
        });

        $mqtt->loop(true);
        return Command::SUCCESS;
    }
}
