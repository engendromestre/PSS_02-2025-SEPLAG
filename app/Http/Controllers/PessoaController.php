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
        // Gate::authorize('view', $pessoa);
        $pessoas = Pessoa::query()
            ->with(['fotos', 'servidorEfetivo', 'servidorTemporario'])
            ->paginate(10);

        return PessoaResource::collection($pessoas);
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
        Gate::authorize('store', $pessoa);

        return (new PessoaResource($pessoa))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pessoa  $pessoa
     * @return \App\Http\Resources\PessoaResource
     */
    public function show(Pessoa $pessoa)
    {
        Gate::authorize('view', $pessoa);

        return new PessoaResource($pessoa->load(['servidorEfetivo', 'servidorTemporario']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pessoa $pessoa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePessoaRequest  $request
     * @param  \App\Models\Pessoa  $pessoa
     * @return \App\Http\Resources\PessoaResource
     */
    public function update(UpdatePessoaRequest $request, Pessoa $pessoa)
    {
        Gate::authorize('update', $pessoa);

        $pessoa->update($request->validated());

        return new PessoaResource($pessoa);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pessoa  $pessoa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pessoa $pessoa)
    {
        Gate::authorize('delete', $pessoa);

        $pessoa->delete();

        return response()->json(null, 204);
    }
}
