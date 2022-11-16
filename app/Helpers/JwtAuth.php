<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;

class JwtAuth
{
    public $key;

    public function __construct()
    {
        $this->key = 'clave-secret@-de-abocas-developer-411324-44897-99644534';
    }

    public function signup($email, $password, $getToken = null)
    {
        //Comprobamos si el usuario existe en la BBDD
        $user = User::where(
                array(
                    'email' => $email,
                    'password' => $password
                ))->first();
        
        $signup = false;
        if(is_object($user)) $signup = true;

        if($signup)
        {
            //Existe el usuario
            //Procedemos a general el token y devolverlo
            $token = array(
                'sub' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'surname' => $user->surname,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60) //Una semana para expirar el token
            );

            //Codificamos el token
            $jwt = JWT::encode($token, $this->key, 'HS256'); //Cifrado
                //Decodificamos el token
            $decoded = JWT::decode($jwt, $this->key, array('HS256')); //Objeto del usuario identificado

            //Dependiendo devolvemos el TOKEN o el OBJETO
            if(is_null($getToken)){
                return $jwt;
            }
            else{
                return $decoded;
            }
        }
        else
        {
            //Devolvemos error
            return array(
                'status' => 'error',
                'message' => 'Usuario o contraseña no válido'
            );
        }
    }

    public function checkToken($jwt, $getIdentity = false)
    {
        //Autentificacion por defecto en false
        $auth = false;

        try{
            $decoded = JWT::decode($jwt, $this->key, array('HS256'));
        }
        catch(\UnexpectedValueException $e){
            $auth = false;
        }catch(\DomainException $e){
            $auth = false;
        }

        if(isset($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true;
        }else{
            $auth = false;
        }

        if($getIdentity){
            return $decoded;
        }

        return $auth;
    }
}

?>