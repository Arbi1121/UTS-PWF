<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

        //mendefinisikan tabel pendaftar
        protected $table = 'pendaftar';

        //mempersilakan user untuk menginput yang mana saja yang boleh diinput
        protected $fillable = ['nama','kata_sandi','role','no_hp','tanggal_lahir'];
}
