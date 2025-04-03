<?php

namespace App\Models;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Model;

class ServidorEfetivo extends Model
{
    protected $table = 'servidores_efetivos';

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id', 'pes_id');
    }
}
