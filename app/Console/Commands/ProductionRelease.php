<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class ProductionRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'releases:production {--pre : Pre Release} {--post : Post Release}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle production release.';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $tempDir;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->filesystem = $filesystem;

        $this->tempDir = temp_path();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('pre')) {
            $type = 'pre-release';
        } else if ($this->option('post')) {
            $type = 'post-release';
        } else {
            $type = $this->choice('Please choose the type.', ['pre-release', 'post-release'], 1);
        }

        if ('pre-release' === $type) {
            $this->preRelease();
        } else {
            $this->postRelease();
        }
    }

    public function preRelease()
    {
        $this->call('down');

        $this->call('route:clear');

        $this->call('config:clear');
    }

    public function postRelease()
    {
        $this->gulp();

        $this->moveAssets();

        $this->call('migrate', ['--force' => true]);

        $this->call('route:cache');

        $this->call('config:cache');

        $this->call('up');
    }

    protected function gulp()
    {
        $process = new Process('gulp --production');

        $process->run();

        if ( ! $process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $this->info('Gulp successfully!');
    }

    protected function moveAssets()
    {
        // 移動 css 檔
        $this->filesystem->move(base_path('resources/views/css/ccu.css.php'), cdn_path('css/ccu.min.css'));

        $this->info('Move assets successfully!');
    }
}
