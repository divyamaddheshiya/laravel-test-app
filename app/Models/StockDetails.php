<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockDetails extends Model {

    protected $table="stock_details";
    public function user(){
        return $this->belongsTo('App\User');
    }
}