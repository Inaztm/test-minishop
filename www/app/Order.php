<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MathieuTu\JsonSyncer\Contracts\JsonExportable;
use MathieuTu\JsonSyncer\Contracts\JsonImportable;
use MathieuTu\JsonSyncer\Traits\JsonExporter;
use MathieuTu\JsonSyncer\Traits\JsonImporter;

class Order extends Model implements JsonExportable, JsonImportable
{
    use JsonExporter, JsonImporter;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    protected $fillable = ['status', 'name', 'email', 'phone', 'total_price', 'comment'];

    public function products() {
        return $this->belongsToMany('App\Product')
                    ->using('App\OrderProduct');
    }

}
