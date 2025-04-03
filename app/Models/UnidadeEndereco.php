<?php

namespace App\Models;

use App\Models\Unidade;
use App\Models\Endereco;
use Illuminate\Database\Eloquent\Model;

class UnidadeEndereco extends Model
{
    protected $table = 'unidade_enderecos';
    protected $fillable = ['unid_id', 'end_id'];
    /**
     * Get the unidade record associated with the unidade_endereco.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @property-read \App\Models\Unidade $unidade The unidade record associated with the unidade_endereco.
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unid_id', 'unid_id');
    }

    /**
     * Get the endereco record associated with the unidade_endereco.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @property-read \App\Models\Endereco $endereco The endereco record associated with the unidade_endereco.
     */
    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'end_id', 'end_id');
    }
}
