<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Http\Requests\StoreCarroRequest;
use App\Http\Requests\UpdateCarroRequest;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Aplicando filtro na API 
        $carros = Carro::with('modelo');
        if ($request->has('filtro')) {
            $filtros=explode(';',$request->filtro);
            foreach ($filtros as $key => $condicao) {
                $c=explode(':',$condicao);
                $carros = $carros->where($c[0],$c[1],$c[2])->get();
            }
            
        }else{
            $carros = $carros->get();
        }

        //Direto sem o filtro
       // $carros = Carro::with('modelo')->get();    
        return response()->json($carros,200);
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
     * @param  \App\Http\Requests\StoreCarroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarroRequest $request)
    {
        $carro = Carro::create([
            'modelo_id'=>$request->modelo_id,
            'placa'=>$request->placa,
            'disponivel'=>$request->disponivel,
            'km'=>$request->km,
        ]);
        return response()->json($carro,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carro = Carro::with('modelo')->find($id);
        if($carro===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }
        return response()->json($carro,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function edit(Carro $carro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarroRequest  $request
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarroRequest $request, $id)
    {
        $carro = Carro::find($id);
        if($carro===null){
            return response()->json(['erro'=>'O Recurso pesquisado não existe'],404);
        }

        $carro->update([
            'modelo_id'=>$request->modelo_id,
            'placa'=>$request->placa,
            'disponivel'=>$request->disponivel,
            'km'=>$request->km,
        ]);

        return response()->json($carro,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carro = Carro::find($id);
        if($carro===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }

        $carro->delete();
        return response()->json(['msg'=>'A marca removida com sucesso!'],200);
    }
}
