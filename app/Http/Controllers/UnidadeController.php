<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Http\Resources\UnidadeResource;
use App\Http\Requests\StoreUnidadeRequest;
use App\Http\Requests\UpdateUnidadeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UnidadeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/unidades",
     *     summary="Listar unidades",
     *     tags={"Unidade"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Número da página",
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de unidades paginada",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Unidade")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
    public function index()
    {
        Gate::authorize('viewAny', Unidade::class);
        $unidades = Unidade::with(['enderecos', 'lotacoes'])->paginate(10);
        return UnidadeResource::collection($unidades);
    }

    /**
     * @OA\Post(
     *     path="/api/unidades",
     *     summary="Cadastrar nova unidade",
     *     tags={"Unidade"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Unidade")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Unidade criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Unidade")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function store(StoreUnidadeRequest $request)
    {
        Gate::authorize('create', Unidade::class);
        $unidade = Unidade::create($request->validated());
        
        if ($request->has('enderecos')) {
            $unidade->enderecos()->sync($request->enderecos);
        }
        
        return (new UnidadeResource($unidade->load('enderecos')))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *     path="/api/unidades/{id}",
     *     summary="Exibir unidade específica",
     *     tags={"Unidade"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Unidade encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/Unidade")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Unidade não encontrada"
     *     )
     * )
     */
    public function show(Unidade $unidade)
    {
        Gate::authorize('view', $unidade);
        return new UnidadeResource($unidade->load(['enderecos', 'lotacoes']));
    }

    /**
     * @OA\Put(
     *     path="/api/unidades/{id}",
     *     summary="Atualizar unidade",
     *     tags={"Unidade"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Unidade")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Unidade atualizada",
     *         @OA\JsonContent(ref="#/components/schemas/Unidade")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function update(UpdateUnidadeRequest $request, Unidade $unidade)
    {
        Gate::authorize('update', $unidade);
        $unidade->update($request->validated());
        
        if ($request->has('enderecos')) {
            $unidade->enderecos()->sync($request->enderecos);
        }
        
        return new UnidadeResource($unidade->fresh(['enderecos']));
    }

    /**
     * @OA\Delete(
     *     path="/api/unidades/{id}",
     *     summary="Excluir unidade",
     *     tags={"Unidade"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Unidade excluída"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unidade possui lotações ativas"
     *     )
     * )
     */
    public function destroy(Unidade $unidade)
    {
        Gate::authorize('delete', $unidade);
        
        if ($unidade->lotacoes()->exists()) {
            abort(403, 'Não é possível excluir uma unidade com lotações ativas');
        }
        
        $unidade->enderecos()->detach();
        $unidade->delete();
        
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/unidades/{unidade}/servidores-efetivos",
     *     summary="Listar servidores efetivos da unidade",
     *     tags={"Unidade"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="unidade",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de servidores efetivos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Pessoa")
     *         )
     *     )
     * )
     */
    public function servidoresEfetivos(Unidade $unidade)
    {
        Gate::authorize('view', $unidade);
        $servidores = $unidade->lotacoes()
            ->with(['pessoa.servidorEfetivo', 'pessoa.fotos'])
            ->whereHas('pessoa.servidorEfetivo')
            ->get()
            ->pluck('pessoa');
            
        return PessoaResource::collection($servidores);
    }
}