<?php

namespace App\Console\Commands\Steam;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Client\Factory;
use Throwable;

class LoadGames extends Command
{

    protected $signature = 'steam:load-games {steep=1}';

    protected $description = 'Steam -load games';

    private Factory $httpClient;

    private string $temporaryGamesList = './storage/app/steam';
    private array $genres = [];
    private array $publishers = [];
    private array $developers = [];


    public function __construct(Factory $httpClient)
    {
        parent::__construct();
        $this->httpClient = $httpClient;
    }

    private function loadGameList(): void
    {
        $steamAllGamesUrl = config('steam.api.games.all');
        $responce = $this->httpClient->get($steamAllGamesUrl);

        if ($responce->failed())
        {
            $this->error('Reqest Failed. Status code: ' . $responce->status());
            exit;
        }
        $responceContent = $responce->json();
        $apps = $responceContent['applist']['apps'];
        $jsonApps = json_encode($apps);
        $res = file_put_contents($this->temporaryGamesList, $jsonApps);
        $this->info('LOADED !!!');
    }


    public function handle()
    {
        $steep = $this->argument('steep');
        if ($steep == 1)
        {
            $this->loadGameList();
            return 0;
        }

        $gameList = file_get_contents($this->temporaryGamesList);
        $gameList = json_decode($gameList, true);

        //dd(count($gameList));

        $savedGames = DB::table('games')
            ->select('steam_appid')
            ->pluck('steam_appid')
            ->toArray();

        $savedGames = array_flip($savedGames);

        $genres = DB::table('genres')->select()->get()->toArray();

        foreach ($genres ?? [] as $row)
        {
            $this->genres[$row->id] = (array) $row;
        }

        $progressDB = $this->output->createProgressBar(count($gameList));

        foreach ($gameList as $row)
        {

            $appId = $row['appid'];

            if (array_key_exists($appId, $savedGames))
            {
                $progressDB->advance();
                $this->info(' - ' . $appId);
                continue;
            }

            usleep(100000);

            $responce = $this->httpClient->get(
                config('steam.api.games.details'),
                [
                    'appids' => $appId,
                    'l' => 'en'
                ]
            );

            if ($responce->failed())
            {
                $this->error("Error: Game: $appId HTTP Code {$responce->status()}");
                continue;
            }

            $data = $responce->json();

            if ($data[$row['appid']]['success'] === false)
            {
                $this->error("ERROR: Game: $appId Data is empty");
                continue;
            }

            try
            {
                $this->create($data);
            }
            catch (Throwable $e)
            {
                dump($data);
                dump($e);
                continue;
            }
            $progressDB->advance();
            $this->info(" - " . $appId . ": " . $data[$appId]['data']['name']);
        }
        $progressDB->finish();
        $this->info('End from DB');

        return 0;
    }

    private function create($data)
    {
        $result = DB::transaction(function () use ($data)
        {
            $data = array_shift($data);

            if ($data['success'] !== true)
            {
                return;
            }

            $data = $data['data'];
            $game = [
                'steam_appid' => $data['steam_appid'],
                'relation_id' => !empty($data['fullgame']) ? (int) $data['fullgame']['appid'] : null,
                'name' => $data['name'],
                'type' => $data['type'],
                'description' => $data['detailed_description'],
                'short_description' => $data['short_description'],
                'about' => $data['about_the_game'],
                'image' => $data['header_image'],
                'website' => $data['website'],
                'price_amount' => $data['price_pverview']['initial'] ?? null,
                'price_currency' => $data['price_overview']['currency'] ?? null,
                'metacritic_score' => $data['metacritic']['score'] ?? null,
                'metacritic_url' => $data['metacritic']['url'] ?? null,
                'relase_date' => $data['release_date']['date'],
                'languages' => $data['supported_languages'] ?? null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

            $gameId = DB::table('games')->insertGetId($game);

            foreach ($data['genres'] ?? [] as $genre)
            {
                if (empty($this->genres[$genre['id']]))
                {
                    $genreData = [
                        'id' => $genre['id'],
                        'name' => $genre['description'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                    $result = DB::table('genres')->insert($genreData);
                    $this->genres[$genreData['id']] = $genreData;
                }

                DB::table('gameGenres')->insert([
                    'game_id' => $gameId,
                    'genre_id' => $genre['id']
                ]);
            }

            foreach ($data['publishers'] ?? [] as $publisher)
            {
                if (empty($this->publishers[$publisher]))
                {
                    $publisherData = [
                        'name' => $publisher,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                    $publisherId = DB::table('publishers')->insertGetId($publisherData);
                    $publisherData['id'] = $publisherId;
                    $this->publishers[$publisher] = $publisherData;
                }

                $publisherId = $this->publishers[$publisher]['id'];

                DB::table('gamePublishers')->insert([
                    'game_id' => $gameId,
                    'publisher_id' => $publisherId
                ]);
            }
            foreach ($data['developers'] ?? [] as $developer)
            {
                if (empty($this->developers[$developer]))
                {
                    $developerData = [
                        'name' => $developer,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                    $developerId = DB::table('developers')->insertGetId($developerData);
                    $developerData['id'] = $developerId;
                    $this->developers[$developer] = $developerData;
                }

                $developerId = $this->developers[$developer]['id'];

                DB::table('gameDevelopers')->insert([
                    'game_id' => $gameId,
                    'developer_id' => $developerId
                ]);
            }

            foreach ($data['screenshots'] ?? [] as $screenshot)
            {
                DB::table('screenshots')->insert(
                    [
                        'game_id' => $gameId,
                        'thumbnail' => $screenshot['path_thumbnail'],
                        'url' => $screenshot['path_full'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                );
            }

            foreach ($data['movies'] ?? [] as $movie)
            {
                DB::table('movies')->insertOrIgnore(
                    [
                        'game_Id' => $gameId,
                        'orginal_id' => $movie['id'],
                        'name' => $movie['name'],
                        'highlight' => $movie['highlight'],
                        'thumbnail' => $movie['thumbnail'],
                        'webm_480' => $movie['webm']['480'],
                        'webm_url' => $movie['webm']['max'],
                        'mp4_480' => $movie['mp4']['480'],
                        'mp4_url' => $movie['mp4']['max'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                );
            }
        });
    }
}
