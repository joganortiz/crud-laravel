<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        
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

        if (empty(request('nombre')) || empty(request('password')) || empty(request('correo'))) {
            $arrResponse = array('status' => 404, 'titulo' => 'Aviso!', 'mensaje' => 'Hay campos que se encuentra vacio y son obligatorio');
            $continuar = false;
        }

        if ($continuar) {
            // una forma tambien que se puede encriptar la contraseña
            //$pass = password_hash(request('password'), PASSWORD_DEFAULT);

            #Encriptamos la clave para mayor seguridad
            $pass2 = bcrypt(request('password'));

            $arrayDatosUser = array(
                "name" => request('nombre'),
                "email" => request('correo'),
                "password" => $pass2
            );

            $resul = User::insert($arrayDatosUser);
            if ($resul) {
                $arrResponse = array('status' => 200, 'titulo' => '¡Buen trabajo!', 'mensaje' => 'Te registraste correctamente');
            } else {
                $arrResponse = array('status' => 404, 'titulo' => 'Error!', 'mensaje' => 'No se pudo registrar, intenta más tarde');
            }
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *@param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        
        $continuar = true;
        $datosCliente = request()->except('_token');
        $user =  DB::table('users')->where('email', request('correo'))->get();
        

        if(empty($user[0])){
            $arrResponse = array('status' => 404, 'titulo' => 'Aviso!', 'mensaje' => 'Correo y/o contraseña es incorrecto');
            $continuar = false;
        }
        
        if($continuar){
            $password = request('password');
            if (!password_verify($password, $user[0]->password)) {
                $arrResponse = array('status' => 404, 'titulo' => 'Aviso!', 'mensaje' => 'Correo y/o contraseña es incorrecto');
                $continuar = false;
            }
        }
        
        if($continuar){
            Session::put('logueado', true);
            $arrResponse = array('status' => 200); 
        }
        //var_dump($user[0]->password);
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        

    }
}
