<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Http\Requests\StoreLocacaoRequest;
use App\Http\Requests\UpdateLocacaoRequest;
use Illuminate\Http\Request;

class LocacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        //Aplicando filtro na API 
        $locacao = Locacao::with('cliente')->with('carro')->with('carro.modelo');    
        if ($request->has('filtro')) {
            $filtros=explode(';',$request->filtro);
            foreach ($filtros as $key => $condicao) {
                $c=explode(':',$condicao);
                $locacao = $locacao->where($c[0],$c[1],$c[2])->get();
            }
        }else{
            $locacao = $locacao->get();
        }
        return response()->json($locacao,200);
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
     * @param  \App\Http\Requests\StoreLocacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocacaoRequest $request)
    {
        $locacao = Locacao::create([
            'cliente_id'=>$request->cliente_id,
            'carro_id'=>$request->carro_id,
            'data_inicio_periodo'=>$request->data_inicio_periodo,
            'data_final_previsto_periodo'=>$request->data_final_previsto_periodo,
            'data_final_realizado_periodo'=>$request->data_final_realizado_periodo,
            'valor_diaria'=>$request->valor_diaria,
            'km_inicial'=>$request->km_inicial,
            'km_final'=>$request->km_final,
        ]);
        return response()->json($locacao,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locacao = Locacao::with('cliente')->with('carro')->find($id);
        if($locacao===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }
        return response()->json($locacao,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Locacao $locacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLocacaoRequest  $request
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocacaoRequest $request, $id)
    {
        $locacao = Locacao::find($id);
        if($locacao===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }

        $locacao->update([
            'cliente_id'=>$request->cliente_id,
            'carro_id'=>$request->carro_id,
            'data_inicio_periodo'=>$request->data_inicio_periodo,
            'data_final_previsto_periodo'=>$request->data_final_previsto_periodo,
            'data_final_realizado_periodo'=>$request->data_final_realizado_periodo,
            'valor_diaria'=>$request->valor_diaria,
            'km_inicial'=>$request->km_inicial,
            'km_final'=>$request->km_final,
        ]);

        return response()->json($locacao,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Locacao  $locacao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $locacao = Locacao::find($id);
        if($locacao===null){
            return response()->json(['erro'=>'Recurso pesquisado não existe'],404);
        }

        $locacao->delete();
        return response()->json(['msg'=>'A marca removida com sucesso!'],200);
    }
}
