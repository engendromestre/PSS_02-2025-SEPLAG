<?php

namespace App\Http\Controllers;

use App\Models\FotoPessoa;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFotoPessoaRequest;

class FotoPessoaController extends Controller
{
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
     * Store a newly created resource in storage.
     */
    public function store(StoreFotoPessoaRequest $request)
    {
         $fotosCriadas = [];
         $folder = "fotos_pessoas/{$request->pes_id}";

          foreach ($request->file('fotos') as $foto) {
            // Gera um nome de arquivo único e sanitizado
            $filename = uniqid('foto_', true) . '.' . $foto->getClientOriginalExtension();

            // Salva no bucket MinIO
            $path = $foto->storeAs($folder, $filename, 'minio');
            $url = Storage::disk('minio')->url($path);

            // Cria o registro no banco
            $fotoPessoa = FotoPessoa::create([
                'pes_id' => $request->pes_id,
                'url' => $url,
            ]);

            $fotosCriadas[] = $fotoPessoa;
        }

        return FotoPessoaResource::collection(collect($fotosCriadas));
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
