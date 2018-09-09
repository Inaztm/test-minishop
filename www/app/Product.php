<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use MathieuTu\JsonSyncer\Contracts\JsonExportable;
use MathieuTu\JsonSyncer\Contracts\JsonImportable;
use MathieuTu\JsonSyncer\Traits\JsonExporter;
use MathieuTu\JsonSyncer\Traits\JsonImporter;

class Product extends Model implements JsonExportable, JsonImportable
{
    use JsonExporter, JsonImporter;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = ['name', 'price'];

}
