<?php

namespace App;

use App\Jobs\ProcessCsvUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Csv_files extends Model
{
    // public static function insertData($data){
    //     DB::table('csv_files')->insert($data);
    //  }

    protected $guarded = [];

    public function importToDB(){
        $path = resource_path('pending-files/*.csv');

        $files = glob($path);
        foreach($files as $file){
            ProcessCsvUpload::dispatch($file);
        }



    }
}
