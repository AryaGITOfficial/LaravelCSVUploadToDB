<?php

namespace App\Http\Controllers;

use App\csv_files;
use App\Csv_files as AppCsv_files;
use Session;
use Illuminate\Http\Request;

class CSVFilesController extends Controller{
    public function create(){
        return view('import');
    }

    public function store(Request $request){
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $headerRow = $request->file->first()->keys()->toArray();
        $validate = $this->validateHeaderRow($headerRow);

        $file = file($request->file->getRealPath());
        $data = array_slice($file, 1);
        if( $validate == true ){
            $parts = (array_chunk($data, 1000));

            foreach($parts as $index=>$part){
                $filename = resource_path('pending-files/'.date('y-m-d-H-i-s').$index. '.csv');
                
                file_put_contents($filename, $part);            
            }
        }
            (new AppCsv_files())->importToDB();
        session()->flash('status','queued for importing.');
        return redirect('/');
        
    }

    public function validateHeaderRow($headerRow)
    {
        $validate = false;

        if( $headerRow[0] == 'Module_code' && $headerRow[1] == 'Module_name' && $headerRow[2] == 'Module_term' ){
                $validate = true;
        } 

        return $validate;

    }

  
}
