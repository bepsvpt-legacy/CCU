<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Schema;
use VirusTotal\File;

class ScanFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:scan
    {file : The file\'s path to be scanned}
    {--model= : Eloquent ORM Model}
    {--column= : The table\'s column to store the result}
    {--index= : The primary key\'s value to specific row}
    {--fakeName= : Fake file name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use VirusTotal to scan file.';

    /**
     * VirusTotal api public key.
     *
     * @var string
     */
    private $apiPublicKey;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->apiPublicKey = env('VIRUSTOTAL_PUBLIC_KEY');

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 確認是否有 api key
        if (null === $this->apiPublicKey) {
            $this->error('Invalid VirusTotal api public key.');

            return;
        }

        if ( ! $this->filesystem->isFile($file = $this->argument('file'))) {
            $this->error('File not exists.');

            return;
        }

        // 取得欲儲存的 Model
        if (null === ($model = $this->option('model'))) {
            $model = $this->ask('The Eloquent ORM Model');
        }

        // 取得欲儲存的欄位
        if (null === ($column = $this->option('column'))) {
            $column = $this->ask('The table\'s column to store the result');
        }

        // 取得欲儲存的欄位
        if (null === ($index = $this->option('index'))) {
            $index = $this->ask('The primary key\'s value to specific row');
        }

        // 檢查 Model 是否存在
        if ( ! class_exists($model)) {
            $this->error('Model not exists.');

            return;
        }

        $model = (new $model())->find($index);

        // 檢查該比資料是否存在
        if (null === $model) {
            $this->error('Model not exists');

            return;
        }

        // 檢查欄位是否存在
        if ( ! Schema::hasColumn($model->getTableName(), $column)) {
            $this->error('Column not exists.');

            return;
        }

        // 檢查是否有替代檔名
        if ((null !== ($fakeName = $this->option('fakeName'))) && (strlen($fakeName) > 0)) {
            $fakePath = temp_path($fakeName);

            $this->filesystem->copy($file, $fakePath);

            $file = $fakePath;
        }

        $virusTotal = new File($this->apiPublicKey);

        $report = $virusTotal->scan($file);

        $model->$column = $report['permalink'];

        $model->save();

        if (isset($fakePath)) {
            $this->filesystem->delete($fakePath);
        }

        $this->info('File scan successfully!');
    }
}
