<?php

namespace App\Http\Controllers;

use App\Models\Propuesta;
use App\Models\Talento;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Need;
use App\Models\Evento;
use App\Http\Resources\PropuestaResource;
use App\Http\Requests\StorePropuestaRequest;
use App\Http\Requests\UpdatePropuestaRequest;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarPropuesta;
use Illuminate\Http\Request;
use DataTables;
use PDF;

class PropuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Propuesta::with(['evento', 'evento.prospecto', 'talento'])->select('propuestas.*');
            if ($request->estado) {
                $data = $data->where('estado', $request->estado);
            }
            if ($request->fecha) {
                $data = $data->whereHas('evento', function(Builder $query) use ($request) {
                    $query->whereMonth('fecha', $request->fecha);
                });
            }
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('creacion', function ($row) {
                    return $row->created_at->format('Y-m-d H:i');
                })
                ->addColumn('folio', function ($row) {
                    return sprintf('%04d', $row->id);
                })
                ->addColumn('evento', function ($row) {
                    return $row->evento->nombre;
                })
                ->addColumn('estadox', function ($row) {
                    return ucfirst($row->estado) ;
                })
                ->addColumn('enviarRoute', function ($row) {
                    return route('propuestas.enviar', ['propuesta' => $row->id]);
                })
                ->addColumn('aceptarRoute', function ($row) {
                    return route('propuestas.aceptar', ['propuesta' => $row->id]);
                })
                ->addColumn('rechazarRoute', function ($row) {
                    return route('propuestas.rechazar', ['propuesta' => $row->id]);
                })
                ->addColumn('deleteRoute', function ($row) {
                    return route('propuestas.destroy', ['propuesta' => $row->id]);
                })
                ->addColumn('adjuntosRoute', function ($row) {
                    return route('propuestas.adjuntos.index', ['propuesta' => $row->id]);
                })
                ->addColumn('file', function ($row) {
                    return $row->url;
                })
                ->addColumn('prospecto', function ($row) {
                    return $row->evento->prospecto->nombre;
                })
                ->addColumn('mes', function ($row) {
                    return date('M', strtotime($row->evento->fecha));
                })
                ->addColumn('ciudad', function ($row) {
                    return $row->evento->prospecto->ciudad;
                })
                ->addColumn('estadox', function ($row) {
                    return $row->evento->prospecto->estado;
                })
                ->addColumn('email', function ($row) {
                    return $row->evento->prospecto->email;
                })
                ->addColumn('telefono', function ($row) {
                    return $row->evento->prospecto->telefono;
                })
                ->addColumn('talento', function ($row) {
                    return $row->talento->nombre;
                })
                ->make(true);
        }
        $p = [];
        Evento::get()->each(function ($i, $k) use (&$p) {
            $p[$i->id] = $i->nombre;
        });
        $t = [];
        Talento::get()->each(function ($i, $k) use (&$t) {
            $t[$i->id] = $i->nombre;
        });
        return view('app.propuestas.index', ['eventos' => $p, 'talentos' => $t]);
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
     * @param  \App\Http\Requests\StorePropuestaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePropuestaRequest $request)
    {
        $data = $request->validated();
        unset($data['tipo']);
        unset($data['nombres']);
        $data['archivo'] = '';
        // crear PDF
        $propuesta = Propuesta::create($data);
        if ($request->tipo) {
            foreach ($request->tipo as $key => $tipo) {
                $propuesta->needs()->create([
                    'tipo' => $tipo,
                    'nombre' => $request->nombres[$key]
                ]);
            }
        }
        $necesidades = $propuesta->needs()->orderBy('tipo', 'asc')->get();
        $needs = [];
        $necesidades->pluck('tipo')->each(function ($i, $k) use (&$needs, $necesidades) {
            $needs[$i] = $necesidades->where('tipo', $i);
        });
        $pdf = PDF::loadView('pdf.propuesta', ['talento' => $propuesta->talento, 'propuesta' => $propuesta, 'evento' => $propuesta->evento, 'prospecto' => $propuesta->evento->prospecto, 'necesidades' => $needs]);
        $contenido = $pdf->download()->getOriginalContent();
        Storage::disk('public')->put('propuestas/'.$propuesta->id.'/propuesta.pdf', $contenido);
        $propuesta->archivo = 'propuestas/'.$propuesta->id.'/propuesta.pdf';
        $propuesta->save();
        return response()->json(['message' => 'Propuesta creadá con exito.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Propuesta  $propuesta
     * @return \Illuminate\Http\Response
     */
    public function show(Propuesta $propuesta)
    {
        return new PropuestaResource($propuesta);
    }

    public function enviar(Propuesta $propuesta)
    {
        // enviar
        if ($propuesta->evento->prospecto->email == null) {
            return response()->json(['message' => 'El prospecto no tiene un email al cual enviar el registro, favor de agregar el mail correspondiente.'], 423);
        }
        Mail::to($propuesta->evento->prospecto->email)->send(new EnviarPropuesta($propuesta));
        $propuesta->estado = 'enviada';
        $propuesta->save();
        return response()->json(['message' => 'Propuesta enviada con exito.']);
    }

    public function aceptar(Propuesta $propuesta)
    {
        $propuesta->estado = 'aceptada';
        $propuesta->save();
        return response()->json(['message' => 'Propuesta aceptada con exito.']);
    }

    public function rechazar(Propuesta $propuesta)
    {
        $propuesta->estado = 'rechazada';
        $propuesta->save();
        return response()->json(['message' => 'Propuesta rechazada con exito.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Propuesta  $propuesta
     * @return \Illuminate\Http\Response
     */
    public function edit(Propuesta $propuesta)
    {
        $necesidades = $propuesta->needs()->orderBy('tipo', 'asc')->get();
        $needs = [];
        $necesidades->pluck('tipo')->each(function ($i, $k) use (&$needs, $necesidades) {
            $needs[$i] = $necesidades->where('tipo', $i);
        });
        $pdf = PDF::loadView('pdf.propuesta', ['talento' => $propuesta->talento, 'propuesta' => $propuesta, 'evento' => $propuesta->evento, 'prospecto' => $propuesta->evento->prospecto, 'necesidades' => $needs]);
        return $pdf->download('invoice.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePropuestaRequest  $request
     * @param  \App\Models\Propuesta  $propuesta
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePropuestaRequest $request, Propuesta $propuesta)
    {
        $data = $request->validated();
        unset($data['tipo']);
        unset($data['nombres']);
        unset($data['ids']);
        $data['archivo'] = '';
        // crear PDF
        $propuesta->fill($data)->save();
        $ids = [];
        if ($request->tipo) {
            foreach ($request->tipo as $key => $tipo) {
                $id = $request->ids[$key]??null;
                if ($id) {
                    $need = Need::find($id);
                    $need->tipo = $tipo;
                    $need->nombre = $request->nombres[$key];
                    $need->save();
                } else {
                    $need = $propuesta->needs()->create([
                        'tipo' => $tipo,
                        'nombre' => $request->nombres[$key]
                    ]);
                }
                $ids[] = $need->id;
            }
        }
        Need::where('propuesta_id', $propuesta->id)->whereNotIn('id', $ids)->delete();
        $necesidades = $propuesta->needs()->orderBy('tipo', 'asc')->get();
        $needs = [];
        $necesidades->pluck('tipo')->each(function ($i, $k) use (&$needs, $necesidades) {
            $needs[$i] = $necesidades->where('tipo', $i);
        });
        $pdf = PDF::loadView('pdf.propuesta', ['talento' => $propuesta->talento, 'propuesta' => $propuesta, 'evento' => $propuesta->evento, 'prospecto' => $propuesta->evento->prospecto, 'necesidades' => $needs]);
        $contenido = $pdf->download()->getOriginalContent();
        Storage::disk('public')->put('propuestas/'.$propuesta->id.'/propuesta.pdf', $contenido);
        $propuesta->archivo = 'propuestas/'.$propuesta->id.'/propuesta.pdf';
        $propuesta->save();
        return response()->json(['message' => 'Propuesta editadá con exito.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Propuesta  $propuesta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Propuesta $propuesta)
    {
        Storage::disk('public')->delete($propuesta->archivo);
        $propuesta->delete();
        return response()->json(['message' => 'Propuesta eliminadá con exito.']);
    }
}
