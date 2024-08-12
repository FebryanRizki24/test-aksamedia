<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Division extends Model
{
    protected $table = 'divisions';
    protected $primaryKey = 'id';

    protected $fillable = ['name'];

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected static function booted(): void
    {
        static::creating(function (Division $division) {
            $division->id = Str::uuid()->toString();
        });
    }
}
