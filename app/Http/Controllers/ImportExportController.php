<?php
namespace App\Http\Controllers;

use App\Imports\BulkImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    /**
    * 
    */
    public function importExportView()
    {
       return view('importexport');
    }
    public function import() 
    {
        Excel::import(new BulkImport,request()->file('file'));
           
        return back();
    }
}