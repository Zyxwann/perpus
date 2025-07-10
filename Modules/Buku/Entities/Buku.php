<?php

namespace Modules\Buku\Entities;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'judul', 'penulis', 'penerbit', 'tahun_terbit', 'isbn', 'jumlah','foto'
    ];
}
