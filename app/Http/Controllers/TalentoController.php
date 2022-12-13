<?php

namespace App\Http\Controllers;

use App\Models\Talento;
use App\Http\Resources\TalentoResource;
use App\Http\Requests\StoreTalentoRequest;
use App\Http\Requests\UpdateTalentoRequest;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use DataTables;

class TalentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Talento::select('*');
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('creacion', function ($row) {
                    return $row->created_at->format('Y-m-d H:i');
                })
                ->addColumn('portada', function ($row) {
                    return $row->portada;
                })
                ->addColumn('deleteRoute', function ($row) {
                    return route('talentos.destroy', ['talento' => $row->id]);
                })
                ->make(true);
        }
        return view('app.talentos.index');
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
     * @param  \App\Http\Requests\StoreTalentoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTalentoRequest $request)
    {
        $data = $request->validated();
        $data['imagen'] = $request->file('imagen')->store('talentos', 'public');
        Talento::create($data);
        return response()->json(['message' => 'Talento creadó con exito.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Talento  $talento
     * @return \Illuminate\Http\Response
     */
    public function show(Talento $talento)
    {
        return new TalentoResource($talento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Talento  $talento
     * @return \Illuminate\Http\Response
     */
    public function edit(Talento $talento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTalentoRequest  $request
     * @param  \App\Models\Talento  $talento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTalentoRequest $request, Talento $talento)
    {
        $data = $request->validated();
        $f = $request->file('imagen');
        if ($f) {
            Storage::disk('public')->delete($talento->imagen);
            $data['imagen'] = $f->store('talentos', 'public');
        } else {
            unset($data['imagen']);
        }
        $talento->fill($data)->save();
        return response()->json(['message' => 'Talento editadó con exito.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Talento  $talento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Talento $talento)
    {
        if ($talento->propuestas->count() > 0) {
            return response()->json(['message' => 'El talento tiene ' . $talento->propuestas->count() . ' propuestas(s), por lo cuál no se puede eliminar.'], 423);
        }
        Storage::disk('public')->delete($talento->imagen);
        $talento->delete();
        return response()->json(['message' => 'Talento eliminadó con exito.']);
    }
}
