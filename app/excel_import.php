<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rap2hpoutre\FastExcel\FastExcel;
use App\User;

class excel_import extends Model
{
    

    // Export all users
    (new FastExcel($users))->export('file.xlsx');
}
