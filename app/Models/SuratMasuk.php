<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_surat_masuk';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_surat';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'no_agenda',
        'no_surat',
        'klasifikasi_surat', // Klasifikasi surat ditambahkan
        'pengirim',
        'asal_surat',
        'penerima',
        'isi',
        'jumlah',
        'tgl_surat',
        'tgl_agenda',
        'file',
        'id_user',
    ];

    /**
     * Get the user that owns the surat.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
