<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\FotoPessoa;
use App\Services\FotoPessoaService;
use App\Http\Resources\PessoaResource;
use App\Http\Resources\FotoPessoaResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFotoPessoaRequest;
use Illuminate\Support\Facades\Gate;

class FotoPessoaController extends Controller
{
    private $fotoPessoaService;

    public function __construct(FotoPessoaService $fotoPessoaService)
    {
        $this->fotoPessoaService = $fotoPessoaService;
    }

   /**
     * @OA\Post(
     *     path="/api/pessoas/{pessoa}/fotos",
     *     summary="Fazer upload de uma ou mais fotos para uma pessoa",
     *     description="Upload de múltiplas fotos associadas a uma pessoa. Permitido de 1 a 10 imagens.",
     *     operationId="uploadFotosPessoa",
     *     tags={"FotoPessoa"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="pessoa",
     *         in="path",
     *         required=true,
     *         description="ID da pessoa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"fotos[]"},
     *                 @OA\Property(
     *                     property="fotos[]",
     *                     type="array",
     *                     minItems=1,
     *                     maxItems=10,
     *                     @OA\Items(
     *                         type="string",
     *                         format="binary",
     *                         description="Arquivo de imagem (JPEG, PNG, JPG ou WEBP, máx: 5MB)"
     *                     ),
     *                     description="Array de imagens (máx: 10 arquivos, 5MB cada)"
     *                 )
     *             ),
     *             encoding={
     *                 "fotos[]": {
     *                     "style": "form",
     *                     "explode": true
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Fotos salvas com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/FotoPessoa")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The fotos field is required."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
     */
    public function store(StoreFotoPessoaRequest $request, Pessoa $pessoa)
    {
         Gate::authorize('update', $pessoa);
    
        try {
            // Garante que $fotos seja sempre um array
            $fotos = $request->file('fotos');
            $fotos = is_array($fotos) ? $fotos : [$fotos];
            
            $fotosSalvas = $this->fotoPessoaService->armazenarFotos($fotos, $pessoa->pes_id);

            return FotoPessoaResource::collection(collect($fotosSalvas));
        } catch (Exception $e) {
            Log::error("Erro ao fazer upload das fotos: {$e->getMessage()}");

            return response()->json([
                'message' => 'Erro ao fazer upload das fotos.',
                'detalhes' => $e->getMessage()
            ], 500);
        }
    }
}
