<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Stream extends Model
{
    use HasFactory , HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable =[
        'user_id' , 'content', 'classroom_id', 'link'
    ];

    protected static function booted()
    {
        //
    }

    // public function uniqueIds()
    // {
    //     return [
    //         'id',
    //     ];
    // }

    public function getUpdatedAtColumn()
    {
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
