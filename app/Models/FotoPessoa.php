<?php

namespace App\Models;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Model;

class FotoPessoa extends Model
{
    protected $table = 'fotos_pessoas';
    protected $fillable = ['pes_id','path'];
    protected $appends = ['url']; // Accessor para gerar a URL da imagem

    /**
     * Get the pessoa that owns the foto pessoa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @property int $pes_id The ID of the pessoa in the Pessoa table.
     *
     * @see \App\Models\Pessoa
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pes_id', 'pes_id');
    }

    public function getUrlAttribute()
    {
        return Storage::disk('minio')->temporaryUrl(
            $this->path,
            now()->addMinutes(10) // URL válida por 10 minutos
        );
    }
}
