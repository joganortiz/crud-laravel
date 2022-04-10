<?php

namespace App\Http\Controllers;

use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $service =  DB::table('servicios')->where('eliminado', '1')->where('id_cliente', $id)->get();
        for ($i = 0; $i < count($service); $i++) {
            $service[$i]->imagen = '<img src="' . asset('storage') . '/' . (($service[$i]->imagen) ? $service[$i]->imagen : 'uploads/defaul.png') . '" alt="" width="60px" height="60px">';
            $service[$i]->tipo_servicio = ($service[$i]->tipo_servicio) ? '<span class="badge bg-primary">Avanzado</span>' : '<span class="badge bg-secondary">Basico</span>';
            $service[$i]->options = '<div class="btn-group">
                <button class="btn btn btn-info btn-sm editarServicio" data-control="' . $service[$i]->id . '">
                    <i class="fa-solid fa-pen"></i> Editar
                </button>
                <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item EliminarServicio" data-control="' . $service[$i]->id . '"> Eliminar</button>
                </div>
            </div>';
        }

        echo json_encode($service, JSON_UNESCAPED_UNICODE);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $continuar = true;
        $datosCliente = request()->except('_token');

        if (empty(request('nombre')) || empty(request('fecha_inicio')) || empty(request('fecha_fin'))) {
            $arrResponse = array('status' => 404, 'titulo' => 'Aviso!', 'mensaje' => 'Hay campos que se encuentra vacio y son obligatorio');
            $continuar = false;
        }

        if ($continuar) {
            if (empty(request('id_servicio'))) {
                #tomamos todos los datos que necesitamos para ingresar a la tabla 
                $arraydatosServicio = array(
                    "nombre" => request('nombre'),
                    "fecha_inicio" => request('fecha_inicio'),
                    "fecha_fin" => request('fecha_fin'),
                    "tipo_servicio" => request('tipo_servicio'),
                    "observaciones" => request('observacion'),
                    "imagen" =>  '',
                    "eliminado" => '1',
                    "id_cliente" => request('id_cliente'),
                );

                if ($request->hasFile('imagenSer')) {
                    $arraydatosServicio["imagen"] = $request->file('imagenSer')->store('uploads', 'public');
                }

                $resul = Servicios::insert($arraydatosServicio);
                if ($resul) {
                    $arrResponse = array('status' => 200, 'titulo' => '¡Buen trabajo!', 'mensaje' => 'El cliente <b class="text-info">' . request('nombre') . '</b> se creo exitoso');
                } else {
                    $arrResponse = array('status' => 404, 'titulo' => 'Error!', 'mensaje' => 'No se pudo guardar el cliente');
                }
            } else {
                $servicio = Servicios::findOrFail(request('id_servicio'));

                $servicio->nombre = request('nombre');
                $servicio->fecha_inicio = request('fecha_inicio');
                $servicio->fecha_fin = request('fecha_fin');
                $servicio->tipo_servicio = request('tipo_servicio');
                $servicio->observaciones = request('observacion');

                if ($request->hasFile('imagenSer')) {
                    $url = 'public/' . $servicio->imagen;
                    if (Storage::exists($url)) {
                        Storage::delete($url);
                    }
                    $servicio->imagen = $request->file('imagenSer')->store('uploads', 'public');
                }

                if ($servicio->save()) {
                    $arrResponse = array('status' => 200, 'titulo' => '¡Buen trabajo!', 'mensaje' => 'El Servicio del Cliente fue actualizo correctamente');
                }
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicios  $servicios
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $service =  DB::table('servicios')->where('id', $id)->get();

        if ($service) {
            $arrayCliente = array(
                "id" => $service[0]->id,
                "nombre" => $service[0]->nombre,
                "tipo_servicio" => $service[0]->tipo_servicio,
                "fecha_inicio" => $service[0]->fecha_inicio,
                "fecha_fin" => $service[0]->fecha_fin,
                "observaciones" => $service[0]->observaciones
            );

            $arrResponse = array("status" => 200, "data" => $arrayCliente);
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servicios  $servicios
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicios $servicios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servicios  $servicios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Servicios $servicios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servicios  $servicios
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicios $servicios)
    {
        //
        $service = Servicios::findOrFail(request('id_servicio'));
        $service->eliminado = '0';

        if ($service->save()) {
            $arrResponse = array('status' => 200, 'titulo' => '¡Buen trabajo!', 'mensaje' => 'Se ha eliminado el servicio exitosamente');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function listaServicesCliente()
    {
        $id_cliente = session('id_cliente');
        $html = '';
        $service =  DB::table('servicios')->where('eliminado', '1')->where('id_cliente', $id_cliente)->get();

        for ($i = 0; $i < count($service); $i++) {
            $html .= '
                <tr>
                    <th>' . $service[$i]->nombre . '</th>
                    <th><img src="' . asset('storage') . '/' . (($service[$i]->imagen) ? $service[$i]->imagen : 'uploads/defaul.png') . '" alt="" width="60px" height="60px"></th>
                    <th>' . (($service[$i]->tipo_servicio) ? '<span class="badge bg-primary">Avanzado</span>' : '<span class="badge bg-secondary">Basico</span>') . '</th>
                    <th>' . $service[$i]->fecha_inicio . '</th>
                    <th>' . $service[$i]->fecha_fin . '</th>
                </tr>
            ';
        }
        if (count($service) > 0) {
            $response = array("status" => 200, "html" => $html);
        } else {
            $response = array("status" => 200, "html" => ' <tr><th  colspan="5">No hay datos</th></tr>');
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
