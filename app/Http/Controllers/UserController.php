<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Helpers\JwtAuth;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller
{
    /**
     * Método para el registro de usuarios
     */
    public function register(Request $request)
    {
        //Recogemos variables por POST
        $json = $request->input('json', null);
            //Decodificamos el json, para poder usar los datos
        $params = json_decode($json);
            //Asignamos los datos obtenidos a variables
        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $surname = (!is_null($json) && isset($params->surname)) ? $params->surname : null;
        $role = 'ROLE_USER';
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;

        if(!is_null($email) && !is_null($password) && !is_null($name) && !is_null($surname))
        {
            //Creamos un usuario
            $user = new User();
            $user->email = $email;
            $user->name = $name;
            $user->surname = $surname;
            $user->role = $role;

            //Cifrado de password
            $pwd = hash('sha256', $password);
            $user->password = $pwd;

            //Comprobamos si el usuario ya existe en la BBDD
            $isset_user = User::where('email', '=', $email)->first();

            if(count($isset_user) == 0)
            {
                //Creamos el usuario
                $user->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'EXITO Usuario creado correctamente'
                );
            }
            else
            {
                //Ya existe el usuario
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'ERROR Correo electronico ya existente'
                );
            }
        }
        else
        {
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'ERROR Usuario no creado'
            );
        }

        return response()->json($data, 200);
    }

    /**
     * Método para el login de usuarios, mediante JWT
     */
    public function login(Request $request)
    {
        $jtwAuth = new JwtAuth();

        //Recibimos los datos por POST
        $json = $request->input('json', null);
        $params = json_decode($json);

        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        $getToken = (!is_null($json) && isset($params->gettoken)) ? $params->gettoken : null;

        //Ciframos la password
        $pwd = hash('sha256', $password);

        if(!is_null($email) && !is_null($password) && ($getToken == null || $getToken == 'false'))
        {
            //Hacemos signup
            $signup = $jtwAuth->signup($email, $pwd);
        }
        elseif($getToken != null)
        {
            $signup = $jtwAuth->signup($email, $pwd, $getToken);
        }
        else
        {
            $signup = array(
                'status' => 'error',
                'message' => 'Envia los datos por POST'
            );
        }

        return response()->json($signup, 200);
    }

}//END CLASS USER CONTROLLER
