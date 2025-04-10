<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Http\Resources\PessoaResource;
use App\Http\Requests\StorePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PessoaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pessoas",
     *     summary="Listar pessoas",
     *     tags={"Pessoas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pessoas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Pessoa")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Pessoa::class);
        $pessoas = Pessoa::query()
            ->with(['fotos', 'servidorEfetivo', 'servidorTemporario'])
            ->paginate(10);

        return PessoaResource::collection($pessoas);
    }

    /**
     * @OA\Post(
     *     path="/api/pessoas",
     *     summary="Cadastrar uma nova pessoa",
     *     tags={"Pessoas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Pessoa")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pessoa criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Pessoa")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erro de validação"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function store(StorePessoaRequest $request)
    {
        $pessoa = Pessoa::create($request->validated());

        return (new PessoaResource($pessoa))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *     path="/api/pessoas/{id}",
     *     summary="Exibir uma pessoa pelo ID",
     *     tags={"Pessoas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da pessoa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pessoa encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Pessoa")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Ação não permitida",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="This action is unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pessoa não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [Pessoa] 1")
     *         )
     *     )
     * )
     */
    public function show(Pessoa $pessoa)
    {
        Gate::authorize('view', $pessoa);
        return new PessoaResource($pessoa->load(['fotos','servidorEfetivo', 'servidorTemporario']));
    }

    /**
     * @OA\Put(
     *     path="/api/pessoas/{id}",
     *     summary="Atualizar uma pessoa pelo ID",
     *     tags={"Pessoas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da pessoa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Pessoa")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pessoa atualizada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Pessoa")
     *     ),
     *     @OA\Response(response=403, description="Não autorizado"),
     *     @OA\Response(response=404, description="Pessoa não encontrada")
     * )
     */
    public function update(UpdatePessoaRequest $request, Pessoa $pessoa)
    {
        Gate::authorize('update', $pessoa);

        $pessoa->update($request->validated());

        return new PessoaResource($pessoa->fresh(['fotos', 'servidorEfetivo', 'servidorTemporario']));
    }

    /**
     * @OA\Delete(
     *     path="/api/pessoas/{id}",
     *     summary="Excluir uma pessoa pelo ID",
     *     tags={"Pessoas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da pessoa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Pessoa excluída com sucesso",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(type="object")
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Ação não permitida",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="This action is unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pessoa não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [Pessoa] 1")
     *         )
     *     )
     * )
     */
    public function destroy(Pessoa $pessoa)
    {
        Gate::authorize('delete', $pessoa);

        $pessoa->delete();

        return response()->json(null, 204);
    }
}
