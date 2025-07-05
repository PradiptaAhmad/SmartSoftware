<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mutasi extends Model
{
    protected $table = 'mutasi';

    protected $fillable = [
        'jumlah',
        'saldo',
        'keterangan',
        'kode_customer',
        'tipe',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kode_customer', 'id');
    }
}
