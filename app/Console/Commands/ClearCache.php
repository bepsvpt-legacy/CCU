<?php

namespace App\Console\Commands;

use Illuminate\Cache\CacheManager;
use Illuminate\Console\Command;

class ClearCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear {key? : The key to be deleted.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cache data for production update.';

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var array
     */
    private $keys = [
        'categories',
        'newestCoursesComments',
        'newestCoursesExams',
        'roommatesStatus',
    ];

    /**
     * Create a new command instance.
     *
     * @param CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager)
    {
        parent::__construct();

        $this->cacheManager = $cacheManager;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (null !== ($key = $this->argument('key'))) {
            $this->keys = [$key];
        }

        foreach ($this->keys as $key) {
            $this->cacheManager->store()->forget($key);
        }

        $this->info('Clear cache successfully!');
    }
}
