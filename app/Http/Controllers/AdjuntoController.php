<?php

namespace App\Http\Controllers;

use App\Models\Adjunto;
use App\Models\Propuesta;
use App\Http\Requests\StoreAdjuntoRequest;
use App\Http\Requests\UpdateAdjuntoRequest;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use DataTables;

class AdjuntoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Propuesta $propuesta, Request $request)
    {
        if ($request->ajax()) {
            $data = $propuesta->adjuntos();
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('creacion', function ($row) {
                    return $row->created_at->format('Y-m-d H:i');
                })
                ->addColumn('deleteRoute', function ($row) use ($propuesta) {
                    return route('propuestas.adjuntos.destroy', ['propuesta' => $propuesta->id, 'adjunto' => $row->id]);
                })
                ->addColumn('file', function ($row) {
                    return Storage::url($row->archivo);
                })
                ->toJson();
        }
        return view('app.propuestas.adjuntos.index', ['propuesta' => $propuesta]);
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
     * @param  \App\Http\Requests\StoreAdjuntoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Propuesta $propuesta, StoreAdjuntoRequest $request)
    {
        // subir el adjunto y guardarlo
        $propuesta->adjuntos()->create([
            'archivo' => $request->file('archivo')->store('adjuntos', 'public'),
            'nombre' => $request->nombre
        ]);
        return response()->json(['message' => 'Adjunto guardadó con exito.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adjunto  $adjunto
     * @return \Illuminate\Http\Response
     */
    public function show(Adjunto $adjunto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adjunto  $adjunto
     * @return \Illuminate\Http\Response
     */
    public function edit(Adjunto $adjunto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdjuntoRequest  $request
     * @param  \App\Models\Adjunto  $adjunto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdjuntoRequest $request, Adjunto $adjunto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adjunto  $adjunto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Propuesta $propuesta, Adjunto $adjunto)
    {
        Storage::delete($adjunto->archivo);
        $adjunto->delete();
        return response()->json(['message' => 'Adjunto eliminadó con exito.']);
    }
}
