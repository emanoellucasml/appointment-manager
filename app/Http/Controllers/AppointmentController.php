<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\CompromissoSave;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Services\AppointmentSearchService;

class AppointmentController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(AppointmentSearchService $appointmentSearchService, Request $request)
    {
        $appointments = $appointmentSearchService->title($request->get('title_filter'))
                        ->description($request->get('description_filter'))
                        ->totalReminders($request->get('total_reminders_filter'))
                        ->creationDate($request->get('creation_date_filter'))
                        ->remindDate($request->get('reminder_date_filter'))
                        ->onlyFutureAppointments($request->get('only_future_appointments_filter'))
                        ->orderByCreationDateAscending()
                        ->getQuery()
                        ->paginate(5);

        return View::make('tarefa.index', compact('appointments'));
    }


    public function create()
    {
        abort(Response::HTTP_NOT_FOUND);
    }


    public function store(CompromissoSave $request)
    {
        $data = $request->validated();

        $data = array_merge($data, [
            'to_notify' => 1,
            'notified_amount' => 0
        ]);

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


    public function show()
    {
        abort(Response::HTTP_NOT_FOUND);
    }


    public function edit()
    {
        abort(Response::HTTP_NOT_FOUND);
    }


    public function update($appointmentId, CompromissoSave $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        try{
            $appointment = Appointment::findOrFail($appointmentId);
            DB::transaction(function() use($data, $appointment){
                $appointment->fill($data);
                $appointment->save();
            });
            return redirect()
                ->route('tarefa.index')
                ->with(['success' => 'Appointment atualizada!']);
        }catch(\Exception $e){
            return redirect()->route('tarefa.index')->withErrors(['erro' => $e->getMessage()]);
        }
    }


    public function destroy(Appointment $tarefa)
    {
        try{
            $tarefa->delete();
            return redirect()
                ->route('tarefa.index')
                ->with(['success' => 'Appointment apagada com sucesso!']);
        }catch(\Exception $e){
            return redirect()->route('tarefa.index')->withErrors(['erro' => $e->getMessage()]);
        }
    }
}
