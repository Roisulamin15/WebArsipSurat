<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluar';

    protected $fillable = [
        'nomor',
        'nomor_surat',
        'tujuan_surat',
        'tanggal_surat',
        'perihal',
        'file'
    ];
}
