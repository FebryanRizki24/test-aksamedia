<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Karyawan extends Model
{
    protected $table = 'karyawans';
    protected $primaryKey = 'id';

    protected $fillable = ['name','image','phone','position','division_id'];

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected static function booted(): void
    {
        static::creating(function (Karyawan $karyawan) {
            $karyawan->id = Str::uuid()->toString();
        });
    }

    /**
     * Get the division that owns the Karyawan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
