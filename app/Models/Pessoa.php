<?php

namespace App\Models;

use App\Models\FotoPessoa;
use App\Models\Endereco;
use App\Models\Lotacao;
use App\Models\ServidorEfetivo;
use App\Models\ServidorTemporario;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $primaryKey = 'pes_id';
    protected $fillable = ['pes_nome', 'pes_data_nascimento', 'pes_sexo', 'pes_mae', 'pes_pai'];

    public function enderecos()
    {
        return $this->belongsToMany(Endereco::class, 'pessoa_enderecos', 'pes_id', 'end_id');
    }

    public function lotacoes()
    {
        return $this->hasMany(Lotacao::class, 'pes_id', 'pes_id');
    }

    public function servidorEfetivo()
    {
        return $this->hasMany(ServidorEfetivo::class, 'pes_id');
    }

    public function servidorTemporario()
    {
        return $this->hasMany(ServidorTemporario::class, 'pes_id', 'pes_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoPessoa::class, 'pes_id');
    }
}
