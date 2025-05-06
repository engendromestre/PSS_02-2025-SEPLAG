<?php

namespace App\Models;

use App\Models\Pessoa;
use App\Models\Cidade;
use App\Models\Unidade;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $primaryKey = 'end_id';
    protected $fillable = ['end_tipo_logradouro', 'end_logradouro', 'end_numero', 'end_bairro', 'cid_id'];

    /**
     * Get the cidade record associated with the endereco.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @property int $cid_id The foreign key for the related cidade record.
     *
     * @see \App\Models\Cidade
     */
    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cid_id', 'cid_id');
    }

    /**
     * Get the pessoas records associated with the endereco.
     *
     * This function retrieves the pessoas records that are associated with the endereco through the
     * many-to-many relationship defined in the 'pessoa_enderecos' pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @property int $end_id The primary key of the endereco record.
     * @property int $pes_id The foreign key for the related pessoa record.
     *
     * @see \App\Models\Pessoa
     */
    public function pessoas()
    {
        return $this->belongsToMany(Pessoa::class, 'pessoa_enderecos', 'end_id', 'pes_id');
    }

    /**
     * Get the unidades records associated with the endereco.
     *
     * This function retrieves the unidades records that are associated with the endereco through the
     * many-to-many relationship defined in the 'unidade_enderecos' pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @param int $end_id The primary key of the endereco record.
     * @param int $unid_id The foreign key for the related unidade record.
     *
     * @see \App\Models\Unidade
     */
    public function unidades()
    {
        return $this->belongsToMany(Unidade::class, 'unidade_enderecos', 'end_id', 'unid_id');
    }
}
