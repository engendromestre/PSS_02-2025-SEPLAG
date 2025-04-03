<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lotacao extends Model
{
    protected $table = 'locacoes';
    protected $fillable = ['pes_id', 'unid_id', 'lot_data_lotacao', 'lot_data_remocao', 'lot_portaria'];

    /**
     * Get the pessoa record associated with the lotacao.
     *
     * This function retrieves the pessoa record associated with the lotacao using Laravel's Eloquent ORM.
     * It establishes a belongsTo relationship between the Lotacao and Pessoa models,
     * where the foreign key in the lotacao table is 'pes_id' and the local key in the pessoa table is also 'pes_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @property-read \App\Models\Pessoa $pessoa The pessoa record associated with the lotacao.
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id', 'pes_id');
    }

    /**
     * Get the unidade record associated with the lotacao.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @property-read \App\Models\Unidade $unidade The unidade record associated with the lotacao.
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unid_id', 'unid_id');
    }
}
