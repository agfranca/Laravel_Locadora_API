<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Http\Requests\StoreModeloRequest;
use App\Http\Requests\UpdateModeloRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modelos = [];
        if ($request->has('atributos_marca')) {
            //dd($request->atributos_marca);
            $atributos_marca = $request->atributos_marca;
            $modelos = Modelo::with('marca:id,'.$atributos_marca);
        }else{
            $modelos = Modelo::with('marca');
        }

        if ($request->has('filtro')) {
            $filtros=explode(';',$request->filtro);
            foreach ($filtros as $key => $condicao) {
                $c=explode(':',$condicao);
                $modelos = $modelos->where($c[0],$c[1],$c[2]);
            }
            
        }

        if ($request->has('atributos')) {
            $atributos = $request->atributos;
            $modelos = $modelos->selectRaw('id,'.$atributos)->get();
        }else{
            $modelos = $modelos->get();
        }
        
        return response()->json($modelos,200);

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
     * @param  \App\Http\Requests\StoreModeloRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModeloRequest $request)
    {
        
        //$imagem = $request->file('imagem');
        //$imagem_urn = $imagem->store('imagens/modelos','public');
        //dd($request->marca_id);
        $modelo = Modelo::create([
            'marca_id'=>$request->marca_id,
            'nome'=>$request->nome,
            //'imagem'=>$imagem_urn,
            'imagem'=>$request->imagem,
            'numero_portas'=>$request->numero_portas,
            'lugares'=>$request->lugares,
            'air_bag'=>$request->air_bag,
            'abs'=>$request->abs,
        ]);
        return response()->json($modelo,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = Modelo::with('marca')->find($id);
        if($modelo===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }
        return response()->json($modelo,200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModeloRequest  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModeloRequest $request, $id)
    {
        $modelo = Modelo::find($id);
        if($modelo===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }
/* 
        //REMOVE o arquivo antigo caso um novo arquivo tenha sido enviado no request
        if($request->file('imagem')){
            Storage::disk('public')->delete($modelo->imagem);
        }

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/modelos','public');
         */
        $modelo->update([
            'marca_id'=>$request->marca_id,
            'nome'=>$request->nome,
            //'imagem'=>$imagem_urn,
            'imagem'=>$request->imagem,
            'numero_portas'=>$request->numero_portas,
            'lugares'=>$request->lugares,
            'air_bag'=>$request->air_bag,
            'abs'=>$request->abs,
        ]);

        return response()->json($modelo,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = Modelo::find($id);
        if($modelo===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }
/* 
        //REMOVE o arquivo antigo
        Storage::disk('public')->delete($modelo->imagem);
 */

        $modelo->delete();
        return response()->json(['msg'=>'O Modelo foi removido com sucesso!'],200);
    }
}
