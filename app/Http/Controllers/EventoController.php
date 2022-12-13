<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Prospecto;
use App\Http\Resources\EventoResource;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;

use Illuminate\Http\Request;
use DataTables;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Evento::with('prospecto')->select('eventos.*');
            if ($request->fecha) {
                $data = $data->whereMonth('fecha', $request->fecha);
            }
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('creacion', function ($row) {
                    return $row->created_at->format('Y-m-d H:i');
                })
                ->addColumn('prospecto', function ($row) {
                    return $row->prospecto->nombre;
                })
                ->addColumn('mes', function ($row) {
                    return date('M', strtotime($row->fecha));
                })
                ->addColumn('ciudad', function ($row) {
                    return $row->prospecto->ciudad;
                })
                ->addColumn('estado', function ($row) {
                    return $row->prospecto->estado;
                })
                ->addColumn('email', function ($row) {
                    return $row->prospecto->email;
                })
                ->addColumn('telefono', function ($row) {
                    return $row->prospecto->telefono;
                })
                ->addColumn('tipox', function ($row) {
                    return $row->tipo == 'publico' ? 'Público' : 'Privado';
                })
                ->addColumn('deleteRoute', function ($row) {
                    return route('eventos.destroy', ['evento' => $row->id]);
                })
                ->toJson();
        }
        $p = [];
        Prospecto::get()->each(function ($i, $k) use (&$p) {
            $p[$i->id] = $i->nombre . '(' . $i->email . ')';
        });
        return view('app.eventos.index', ['prospectos' => $p]);
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
     * @param  \App\Http\Requests\StoreEventoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventoRequest $request)
    {
        Evento::create($request->validated());
        return response()->json(['message' => 'Evento creadó con exito.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        return new EventoResource($evento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventoRequest  $request
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventoRequest $request, Evento $evento)
    {
        $evento->fill($request->validated())->save();
        return response()->json(['message' => 'Evento editadó con exito.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        // eliminar propuestas de este evento
        $evento->propuestas()->delete();
        $evento->delete();
        return response()->json(['message' => 'Prospecto eliminado con exito.']);
    }
}
