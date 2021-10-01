<?php

namespace App\Console\Commands\Steam;

use Illuminate\Console\Command;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;

class UpdateGame extends Command
{
    private Factory $httpClient;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'steam:update-game {game}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Steam game ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Factory $httpClient)
    {
        parent::__construct();
        $this->httpClient = $httpClient;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $responce = $this->httpClient->post('https://postman-echo.com/post', [
            'foo' => 'bar',
            'alpha' => 'omega'
        ]);
        dump($responce->json());
        return 0;
    }
}
