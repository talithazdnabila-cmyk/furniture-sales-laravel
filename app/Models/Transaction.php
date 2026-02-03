<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'nama_pembeli',
        'nama_penerima',
        'no_telepon',
        'alamat',
        'catatan',
        'kode_transaksi',
        'tanggal',
        'user_id',
        'total_harga',
        'grand_total',
        'status'
    ];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
