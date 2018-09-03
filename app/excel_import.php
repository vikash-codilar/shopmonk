<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rap2hpoutre\FastExcel\FastExcel;
use App\User;

$list = collect([
    [ 'id' => 1, 'name' => 'Jane' ],
    [ 'id' => 2, 'name' => 'John' ],
]);

(new FastExcel($list))->export('file.xlsx');
class excel_import extends Model
{
    
    
    public function newCollection(array $models = [])
    {
        return new CustomCollection($models);
    }
}
