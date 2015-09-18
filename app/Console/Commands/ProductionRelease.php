<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ProductionRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'releases:production';

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
        $this->moveAssets();

        $this->info('Success!');
    }

    protected function moveAssets()
    {
        $this->comment('Move assets...');

        // 移動 css 檔
        $this->filesystem->move(base_path('resources/views/css/ccu.css.php'), cdn_path('css/ccu.min.css'));

        // 刪除舊有的 js 檔
        $this->filesystem->delete($this->filesystem->glob(temp_path('*.js')));

        // 複製檔案至暫存目錄
        foreach ($this->filesystem->allFiles(base_path('resources/views/js')) as $file) {
            if ('' !== $file->getRelativePath()) {
                $this->filesystem->copy($file, $this->tempDir . DIRECTORY_SEPARATOR . str_random(8) . '.js');
            }
        }
    }
}
