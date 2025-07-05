<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reseller extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'reseller';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    const CREATED_AT = 'tgl_daftar';
    const UPDATED_AT= 'tgl_aktivitas';

    protected $fillable = [
        'kode',
        'nama',
        'saldo',
        'alamat',
        'pin',
        'aktif',
        'kode_upline',
        'kode_level',
        'keterangan',
        'tgl_daftar',
        'tgl_aktivitas',
        'saldo_minimal',
        'pengingat_saldo',
        'f_pengingat_saldo',
        'nama_pemilik',
        'kode_area',
        'tgl_pengingat_saldo',
        'markup',
        'markup_ril',
        'pengirim',
        'komisi',
        'kode_mutasi',
        'kode_customer',
    ];

    protected function casts(): array
    {
        return [
            'poin' => 'integer',
            'saldo' => 'integer',
            'markup' => 'integer',
            'saldo_minimal' => 'integer',
            'aktif' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kode_user', 'id');
    }
}
