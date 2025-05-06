<?php

namespace App\Models;

use App\Models\Endereco;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $primaryKey = 'cid_id';
    protected $fillable = ['cid_nome', 'cid_uf'];

    /**
     * Get the enderecos associated with this cidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'cid_id');
    }
}
