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
     * Display a listing of the resource with pagination.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {

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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePessoaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePessoaRequest $request)
    {
        $pessoa = Pessoa::create($request->validated());

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
