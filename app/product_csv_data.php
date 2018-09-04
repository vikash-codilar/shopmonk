<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_csv_data extends Model
{
    //
    public $fillable = ['imei','productcode','invoiceno','palletid','boxid','description','model','storage','color'];
}
