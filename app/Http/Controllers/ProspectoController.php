<?php

namespace App\Http\Controllers;

use App\Models\Prospecto;
use App\Http\Resources\ProspectoResource;
use App\Http\Requests\StoreProspectoRequest;
use App\Http\Requests\UpdateProspectoRequest;

use Illuminate\Http\Request;
use DataTables;

class ProspectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Prospecto::select('*');
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('creacion', function ($row) {
                    return $row->created_at->format('Y-m-d H:i');
                })
                ->addColumn('deleteRoute', function ($row) {
                    return route('prospectos.destroy', ['prospecto' => $row->id]);
                })
                ->make(true);
        }
        return view('app.prospectos.index');
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
     * @param  \App\Http\Requests\StoreProspectoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProspectoRequest $request)
    {
        Prospecto::create($request->validated());
        return response()->json(['message' => 'Prospecto creadó con exito.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prospecto  $prospecto
     * @return \Illuminate\Http\Response
     */
    public function show(Prospecto $prospecto)
    {
        return new ProspectoResource($prospecto);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prospecto  $prospecto
     * @return \Illuminate\Http\Response
     */
    public function edit(Prospecto $prospecto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProspectoRequest  $request
     * @param  \App\Models\Prospecto  $prospecto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProspectoRequest $request, Prospecto $prospecto)
    {
        $prospecto->fill($request->validated())->save();
        return response()->json(['message' => 'Prospecto editadó con exito.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prospecto  $prospecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prospecto $prospecto)
    {
        if ($prospecto->eventos->count() > 0) {
            return response()->json(['message' => 'El prospecto tiene ' . $prospecto->eventos->count() . ' evento(s), por lo cuál no se puede eliminar.'], 423);
        }
        $prospecto->delete();
        return response()->json(['message' => 'Prospecto eliminado con exito.']);
    }
}
