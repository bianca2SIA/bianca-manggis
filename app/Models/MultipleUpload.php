<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multipleupload extends Model
{
    protected $fillable = [
        'ref_table',
        'ref_id',
        'filename',
    ];
}
