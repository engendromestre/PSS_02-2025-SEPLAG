<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\FotoPessoa;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FotoPessoaService
{
    public function armazenarFotos(array $fotos, int $pessoaId): array
    {
        $this->verificarMinio();

        $fotosCriadas = [];

        foreach ($fotos as $foto) {
            if (!$foto instanceof UploadedFile) {
                Log::warning("Item inválido recebido no upload de fotos.", ['tipo' => gettype($foto)]);
                continue;
            }

            try {
                $folder = "fotos_pessoas/{$pessoaId}";
                $filename = uniqid('foto_', true) . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs($folder, $filename, 'minio');

                $fotoPessoa = FotoPessoa::create([
                    'pes_id' => $pessoaId,
                    'url' => $path,
                ]);

                $fotosCriadas[] = $fotoPessoa;

            } catch (\Exception $e) {
                Log::error("Erro ao armazenar a foto no MinIO: {$e->getMessage()}", ['exception' => $e]);
                throw new \Exception("Erro ao salvar a foto. Verifique o serviço de armazenamento.");
            }
        }

        return $fotosCriadas;
    }

    private function verificarMinio(): void
    {
        try {
            Storage::disk('minio')->files(); // forçar acesso
        } catch (\Exception $e) {
            throw new \Exception('MinIO não está acessível ou mal configurado: ' . $e->getMessage());
        }
    }

    public function gerarUrlsTemporariasParaFotos(array $fotos, int $validadeSegundos = 3600): array
    {
        return array_map(function ($foto) use ($validadeSegundos) {
            $urlTemporaria = Storage::disk('minio')->temporaryUrl(
                $foto->url,
                now()->addSeconds($validadeSegundos)
            );

            $foto->url_temporaria = $urlTemporaria;
            return $foto;
        }, $fotos);
    }
}