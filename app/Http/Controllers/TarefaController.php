<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\CompromissoSave;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class TarefaController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }


    public function index()
    {
        $appointments = Tarefa::where('user_id', Auth::user()->id)
                        ->orderBy('created_at', 'DESC')
                        ->paginate(8);
        return View::make('tarefa.index', compact('appointments'));
    }


    public function create()
    {
        abort(Response::HTTP_NOT_FOUND);
    }


    public function store(CompromissoSave $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        try{
            DB::transaction(function() use($data, $user){
                $user->appointments()->create($data);
            });
            
            return redirect()
                    ->route('tarefa.index')
                    ->with(['success' => 'Cadastrado com sucesso!']);
        }catch(\Exception $e){
            return redirect()->route('tarefa.index')->withErrors(['erro' => $e->getMessage()]);   
        }
    }


    public function show(Tarefa $tarefa)
    {
        abort(Response::HTTP_NOT_FOUND);
    }


    public function edit(Tarefa $tarefa)
    {
        abort(Response::HTTP_NOT_FOUND);
    }


    public function update(CompromissoSave $request, Tarefa $tarefa)
    {
        $data = $request->validated();
        $user = Auth::user();

        try{
            DB::transaction(function() use($data, $tarefa){
                $tarefa->fill($data);
                $tarefa->save();
            });
            return redirect()
                ->route('tarefa.index')
                ->with(['success' => 'Tarefa atualizada!']);
        }catch(\Exception $e){
            return redirect()->route('tarefa.index')->withErrors(['erro' => $e->getMessage()]);   
        }
    }


    public function destroy(Tarefa $tarefa)
    {
        try{
            DB::table(function() use ($tarefa){
                $tarefa->delete();
            });
            return redirect()
                ->route('tarefa.index')
                ->with(['success' => 'Tarefa atualizada!']);
        }catch(\Exception $e){
            return redirect()->route('tarefa.index')->withErrors(['erro' => $e->getMessage()]);   
        }
    }
}
