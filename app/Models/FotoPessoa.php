<?php

namespace App\Models;

use App\Models\Pessoa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FotoPessoa extends Model
{
    protected $table = 'fotos_pessoas';
    protected $primaryKey = 'fp_id';
    protected $fillable = ['pes_id', 'fp_data', 'fp_bucket', 'fp_hash'];
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

    public function gerarUrlTemporaria(int $minutos = 10): string
    {
        return Storage::disk('minio')->temporaryUrl(
            $this->fp_hash,
            now()->addMinutes($minutos)
        );
    }
}
