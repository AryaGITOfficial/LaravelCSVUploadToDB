<?php

namespace App\Jobs;

use App\Csv_files;
use App\Mail\CsvUploadStatusNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class ProcessCsvUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('upload-csv')->allow(1)->every(20)->then(function () {
            
            
            $data = array_map('str_getcsv', file($this->file));
            foreach($data as $row){
                Csv_files::updateOrCreate([
                    'Module_code' => $row[0]
                ], [
                    'Module_name' => $row[1],
                    'Module_term' => $row[1]
                ]);
            }
            
            Mail::to('charush@accubits.com')->send(new CsvUploadStatusNotificationMail());
            new CsvUploadStatusNotificationMail();

            unlink($this->file);

        }, function () {
            // Could not obtain lock...
    
            return $this->release(5);
        });
        
    }
}
