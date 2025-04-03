<?php

namespace App\Models;

use App\Models\Endereco;
use App\Models\Lotacao;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $fillable = ['pes_nome', 'pes_data_nascimento', 'pes_sexo', 'pes_mae', 'pes_pai'];


    /**
     * Retrieves the addresses associated with the person.
     *
     * This function uses Laravel's Eloquent ORM to establish a many-to-many relationship between the Pessoa model and the Endereco model.
     * The relationship is defined using the belongsToMany method, which specifies the related model, the pivot table, and the foreign keys.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @return \Illuminate\Database\Eloquent\Collection A collection of Endereco models associated with the person.
     */
    public function enderecos()
    {
        return $this->belongsToMany(Endereco::class, 'pessoa_enderecos', 'pes_id', 'end_id');
    }

    /**
     * Retrieves the job assignments associated with the person.
     *
     * This function uses Laravel's Eloquent ORM to establish a one-to-many relationship between the Pessoa model and the Lotacao model.
     * The relationship is defined using the hasMany method, which specifies the related model, the foreign key, and the local key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @return \Illuminate\Database\Eloquent\Collection A collection of Lotacao models associated with the person.
     */
    public function lotacoes()
    {
        return $this->hasMany(Lotacao::class, 'pes_id', 'pes_id');
    }
}
