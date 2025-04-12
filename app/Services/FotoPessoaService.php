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
                // Define a pasta (usando o ID da pessoa) e gera um nome único para o arquivo.
                $folder = "{$pessoaId}";
                $filename = uniqid('foto_', true) . '.' . $foto->getClientOriginalExtension();

                // Armazena o arquivo no disco 'minio'. Retorna o caminho onde o arquivo foi salvo.
                $path = $foto->storeAs($folder, $filename, 'minio');

                // Recupera o bucket definido na configuração ou no .env
                $bucket = env('MINIO_BUCKET', 'default');

                // Cria o registro no banco de dados com os dados da foto
                $fotoPessoa = FotoPessoa::create([
                    'pes_id'    => $pessoaId,
                    'fp_data'   => now()->toDateString(),
                    'fp_bucket' => $bucket,
                    'fp_hash'   => $path,
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
            // Força o acesso para verificar a conexão com o MinIO.
            Storage::disk('minio')->files();
        } catch (\Exception $e) {
            throw new \Exception('MinIO não está acessível ou mal configurado: ' . $e->getMessage());
        }
    }

    /**
     * Gera URLs temporárias para um array de instâncias de FotoPessoa.
     *
     * @param array $fotos
     * @param int $validadeSegundos
     * @return array
     */
    public function gerarUrlsTemporariasParaFotos(array $fotos, int $validadeSegundos = 3600): array
    {
        return array_map(function ($foto) use ($validadeSegundos) {
            $urlTemporaria = Storage::disk('minio')->temporaryUrl(
                $foto->fp_hash,
                now()->addSeconds($validadeSegundos)
            );

            $foto->url_temporaria = $urlTemporaria;
            return $foto;
        }, $fotos);
    }
}
