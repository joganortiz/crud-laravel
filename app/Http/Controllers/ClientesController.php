<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  DB::table('clientes')->where('eliminado', '1')->get();
        for ($i = 0; $i < count($clientes); $i++) {

            $clientes[$i]->imagen = '<img src="' . asset('storage') . '/' . (($clientes[$i]->imagen) ? $clientes[$i]->imagen : 'uploads/defaul.png') . '" alt="" width="60px" height="60px">';

            $clientes[$i]->options = '<div class="btn-group">
                <button class="btn btn btn-info btn-sm editarCliente" data-control="' . $clientes[$i]->id . '">
                    <i class="fa-solid fa-pen"></i> Editar
                </button>
                <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <button class="dropdown-item DetalleCliente" data-control="' . $clientes[$i]->id . '"> Detalle</button>
                    <a class="dropdown-item" href="' . url("/cliente/{$clientes[$i]->id}/servicios") . '"> Servicios</a>
                    <div class="dropdown-divider"></div>
                    <button class="dropdown-item EliminarCliente" data-control="' . $clientes[$i]->id . '"> Eliminar</button>
                </div>
            </div>';
        }

        echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function create(Request $request)
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

        if (empty(request('nombre')) || empty(request('cedula')) || empty(request('correo'))) {
            $arrResponse = array('status' => 404, 'titulo' => 'Aviso!', 'mensaje' => 'Hay campos que se encuentra vacio y son obligatorio');
            $continuar = false;
        }

        if ($continuar) {
            if (empty(request('id_cliente'))) {

                #tomamos todos los datos que necesitamos para ingresar a la tabla 
                $arrayDatosCliente = array(
                    "nombre" => request('nombre'),
                    "cedula" => request('cedula'),
                    "telefono" => request('telefono'),
                    "correo" => request('correo'),
                    "observaciones" => request('observacion'),
                    "imagen" =>  '',
                    "eliminado" => '1'
                );

                if ($request->hasFile('imagen')) {
                    $arrayDatosCliente["imagen"] = $request->file('imagen')->store('uploads', 'public');
                }

                $resul = Clientes::insert($arrayDatosCliente);
                if ($resul) {
                    $arrResponse = array('status' => 200, 'titulo' => '¡Buen trabajo!', 'mensaje' => 'El cliente <b class="text-info">' . request('nombre') . '</b> se creo exitoso');
                } else {
                    $arrResponse = array('status' => 404, 'titulo' => 'Error!', 'mensaje' => 'No se pudo guardar el cliente');
                }
            } else {
                $cliente = Clientes::findOrFail(request('id_cliente'));

                $cliente->nombre = request('nombre');
                $cliente->cedula = request('cedula');
                $cliente->telefono = request('telefono');
                $cliente->correo = request('correo');
                $cliente->observaciones = request('observacion');

                if ($request->hasFile('imagen')) {
                    $url = 'public/' . $cliente->imagen;
                    if (Storage::exists($url)) {
                        Storage::delete($url);
                    }

                    $cliente->imagen = $request->file('imagen')->store('uploads', 'public');
                }

                if ($cliente->save()) {
                    $arrResponse = array('status' => 200, 'titulo' => '¡Buen trabajo!', 'mensaje' => 'El cliente se actualizo correctamente');
                }
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *@param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $clinete =  DB::table('clientes')->where('id', $id)->get();

        if ($clinete) {
            $arrayCliente = array(
                "id" => $clinete[0]->id,
                "nombre" => $clinete[0]->nombre,
                "imagen" => $clinete[0]->imagen,
                "cedula" => $clinete[0]->cedula,
                "correo" => $clinete[0]->correo,
                "telefono" => $clinete[0]->telefono,
                "observaciones" => $clinete[0]->observaciones,
                "url_imagen" => asset('storage') . '/' . (($clinete[0]->imagen) ? $clinete[0]->imagen : 'uploads/defaul.png')
            );

            Session::put('id_cliente', $clinete[0]->id);
            $arrResponse = array("status" => 200, "data" => $arrayCliente);
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clientes $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cliente = Clientes::findOrFail(request('id_cliente'));

        $cliente->eliminado = '0';

        if ($cliente->save()) {
            $arrResponse = array('status' => 200, 'titulo' => '¡Buen trabajo!', 'mensaje' => 'Se ha eliminado al cliente exitosamente');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }
}
