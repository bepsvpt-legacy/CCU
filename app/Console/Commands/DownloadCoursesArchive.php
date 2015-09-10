<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use PharData;

class DownloadCoursesArchive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:download {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download the courses archive.';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Create a new command instance.
     *
     * @param Client $client
     * @param Filesystem $filesystem
     */
    public function __construct(Client $client, Filesystem $filesystem)
    {
        parent::__construct();

        $this->client = $client;
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get random file name and file extension
        $path = temp_path(str_random());
        $originalExtension = substr(strrchr($this->argument('url'), '.'), 1);

        // download file and store it
        $this->info('Downloading the file...' . PHP_EOL);
        $response = $this->client->get($this->argument('url'), ['verify' => storage_path('app/wildcard_ccu_edu_tw')]);
        $this->filesystem->put("{$path}.{$originalExtension}", $response->getBody()->getContents());

        // extract the file
        $this->info('Extracting the file...' . PHP_EOL);
        (new PharData("{$path}.{$originalExtension}"))->decompress();
        (new PharData("{$path}.tar"))->extractTo(temp_path());

        // delete non-used files
        $this->info('Deleting non-used the file...' . PHP_EOL);
        $this->filesystem->delete(["{$path}.{$originalExtension}", "{$path}.tar", temp_path('index.html')]);
        $this->filesystem->delete($this->filesystem->glob(temp_path('*e.html')));

        $this->info('Succeed!');
    }
}