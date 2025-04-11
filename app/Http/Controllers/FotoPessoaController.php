<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\FotoPessoa;
use App\Services\FotoPessoaService;
use App\Http\Resources\PessoaResource;
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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

   /**
     * @OA\Post(
     *     path="/api/fotos",
     *     summary="Fazer upload de uma ou mais fotos para uma pessoa",
     *     description="Upload de múltiplas fotos associadas a uma pessoa.",
     *     operationId="uploadFotosPessoa",
     *     tags={"FotoPessoa"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"pes_id", "fotos"},
     *                 @OA\Property(
     *                     property="pes_id",
     *                     type="integer",
     *                     description="ID da pessoa"
     *                 ),
     *                 @OA\Property(
     *                     property="fotos",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         format="binary"
     *                     ),
     *                     description="Arquivos de imagem para upload"
     *                 )
     *             )
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
     *         description="Erro de validação"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
    public function store(StoreFotoPessoaRequest $request, Pessoa $pessoa)
    {
        Gate::authorize('update', $pessoa);
        
        try {
            $fotos = $this->fotoPessoaService->armazenarFotos($request->file('fotos'),  $pessoa->pes_id);

            return FotoPessoaResource::collection(collect($fotos));
        } catch (Exception $e) {
            Log::error("Erro ao fazer upload das fotos: {$e->getMessage()}");

            return response()->json([
                'message' => 'Erro ao fazer upload das fotos.',
                'detalhes' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FotoPessoa $fotoPessoa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FotoPessoa $fotoPessoa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FotoPessoa $fotoPessoa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FotoPessoa $fotoPessoa)
    {
        //
    }
}
