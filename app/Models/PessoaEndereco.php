<?php

namespace App\Models;

use App\Models\Pessoa;
use App\Models\Endereco;
use Illuminate\Database\Eloquent\Model;

class PessoaEndereco extends Model
{
    protected $fillable = ['pes_id', 'end_id'];

    /**
     * Get the pessoa record associated with the pessoa_endereco.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @param \App\Models\Pessoa $pessoa The pessoa model instance.
     * @param string $foreignKey The foreign key of the pessoa in the pessoa_endereco table.
     * @param string $ownerKey The owner key of the pessoa in the pessoa table.
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id', 'pes_id');
    }


    /**
     * Get the endereco record associated with the pessoa_endereco.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @param \App\Models\Endereco $endereco The endereco model instance.
     * @param string $foreignKey The foreign key of the endereco in the pessoa_endereco table.
     * @param string $ownerKey The owner key of the endereco in the endereco table.
     */
    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'end_id', 'end_id');
    }
}
