<?php

namespace App\Models;

use App\Models\Lotacao;
use App\Models\Endereco;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = ['unid_nome', 'unid_sigla'];

    /**
     * Get all lotacoes associated with this unidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @property int $unid_id The unique identifier of the unidade.
     *
     * @see \App\Models\Lotacao
     */
    public function lotacoes()
    {
        return $this->hasMany(Lotacao::class, 'unid_id', 'unid_id');
    }

    /**
     * Get all enderecos associated with this unidade through the unidade_enderecos pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @property int $unid_id The unique identifier of the unidade.
     *
     * @see \App\Models\Endereco
     * @see \App\Models\UnidadeEndereco
     */ 
    public function enderecos()
    {
        return $this->belongsToMany(Endereco::class, 'unidade_enderecos', 'unid_id', 'end_id');
    }
}
