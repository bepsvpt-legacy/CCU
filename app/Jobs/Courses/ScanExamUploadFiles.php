<?php

namespace App\Jobs\Courses;

use App\Ccu\Course\Exam;
use App\Jobs\Job;
use Artisan;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use VirusTotal\Exceptions\RateLimitException;

class ScanExamUploadFiles extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Exam
     */
    private $exam;

    /**
     * Create a new job instance.
     *
     * @param Exam $exam
     */
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->attempts() > 1) {
            $this->delay(30);
        }

        try {
            Artisan::call('file:scan', [
                'file' => storage_path('uploads/courses/exams/' . $this->exam->getAttribute('file_path')),
                '--model' => get_class($this->exam),
                '--column' => 'virustotal_report',
                '--index' => $this->exam->getAttribute('id'),
                '--fakeName' => $this->exam->getAttribute('file_name'),
            ]);
        } catch (RateLimitException $e) {
            Log::error('VirusTotal rate limit exception.');
        }
    }
}
