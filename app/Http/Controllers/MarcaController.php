<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $marcas = [];
        if ($request->has('atributos_modelos')) {
            $atributos_modelos = $request->atributos_modelos;
            $marcas = Marca::with('modelos:marca_id,'.$atributos_modelos);
        }else{
            $marcas = Marca::with('modelos');
        }

        
        if ($request->has('filtro')) {
            $filtros=explode(';',$request->filtro);
            foreach ($filtros as $key => $condicao) {
                $c=explode(':',$condicao);
                $marcas = $marcas->where($c[0],$c[1],$c[2]);
            }
            
        }

        if ($request->has('atributos')) {
            $atributos = $request->atributos;
            $marcas = $marcas->selectRaw('id,'.$atributos)->get();
        }else{
            $marcas = $marcas->get();
        }

        return response()->json($marcas,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMarcaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMarcaRequest $request)
    {
       // dd($request->all());
        //$request->validate();
/* 
        //Pegar a Imagem do Formulario
        $imagem = $request->file('imagem');
        //Enviar a imagem para pasta do Sistema e recebe o nome para guardar no BD
        $imagem_urn = $imagem->store('imagens','public');
        //Usar este Item no Create Abaixo
        'imagem'=>$imagem_urn
 */
        $marca = Marca::create([
            'nome'=>$request->nome,
            'imagem'=>$request->imagem
        ]);

        return response()->json($marca,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = Marca::with('modelos')->find($id);
        if($marca===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }
        return response()->json($marca,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMarcaRequest  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMarcaRequest $request, $id)
    {
        $marca = Marca::find($id);
        if($marca===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }

/*         
        //REMOVE o arquivo antigo caso um novo arquivo tenha sido enviado no request
        if($request->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens','public');
        }else{
            $marca->update([
                'nome'=>$request->nome
            ]);
        }

 */
        $marca->update([
            'nome'=>$request->nome,
            'imagem'=>$request->imagem,
        ]);

        return response()->json($marca,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $marca = Marca::find($id);
        if($marca===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }

        //REMOVE o arquivo antigo
        Storage::disk('public')->delete($marca->imagem);


        $marca->delete();
        return response()->json(['msg'=>'A marca removida com sucesso!'],200);
    }
}
