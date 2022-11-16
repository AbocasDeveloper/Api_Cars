<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JwtAuth;
use App\Car;

class CarController extends Controller
{
    /**
     * Metodo para mostrar el listado completo de todos los vehiculos
     */
    public function index(Request $request)
    {
        //Obtenemos todos los vehiculos y los datos del usuario al que pertenece
        $cars = Car::all()->load('user');
        
        return response()->json(array(
            'cars' => $cars,
            'status' => 'success'
        ), 200);
    }

    /**
     * Metodo para mostrar los datos de un vehiculo en concreto
     */
    public function show($id)
    {
        //Comprobamos si el vehiculo existe en la BBDD
        $car = Car::find($id);

        if(is_object($car))
        {
            $car = Car::find($id)->load('user');

            return response()->json(array(
                'car' => $car,
                'status' => 'success'
            ), 200);
        }
        else
        {
            //No existe
            return response()->json(array(
                'status' => 'error',
                'code' => 400,
                'message' => 'ERROR Vehiculo no existe'
            ), 200);
        }
    }

    /**
     * Metodo para actualizar vehiculo
     */
    public function update($id, Request $request)
    {
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);
        
        if($checkToken)
        {
            //Recoger valores por POST
            $json = $request->input('json', null);
            $params = json_decode($json);
            $params_array = json_decode($json, true);

            //Validacion de datos
            $validate = \Validator::make($params_array, [
                'title' => 'required|min:5',
                'description' => 'required',
                'status' => 'required',
                'price' => 'required'
            ]);

            if($validate->fails())
            {
                return response()->json($validate->errors(), 400);
            }

            //Comprobamos si el vehiculo existe en la BBDD y lo actualizamos
            unset($params_array['id']);
            unset($params_array['user_id']);
            unset($params_array['creared_at']);
            unset($params_array['user']);

            $car = Car::where('id', $id)->update($params_array);
            
            $data = array(
                'car' => $params,
                'status' => 'success',
                'code' => '200',
                'message' => 'Vehiculo actualizado correctamente'
            );
        } 
        else
        {
            //ERROR
            $data = array(
                'status' => 'error',
                'code' => '400',
                'message' => 'Login fallido - No existe TOKEN'
            );  
        }

        return response()->json($data, 200);
    }

    /**
     * Metodo que utiliamos para guardar un vehiculo en la BBDD
     */
    public function store(Request $request)
    {
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);
        
        if($checkToken)
        {
            //Recogemos los datos por POST
            $json = $request->input('json', null);
            $params = json_decode($json);
            $params_array = json_decode($json, true);

            //Conseguir user identificado
            $user = $jwtAuth->checkToken($hash, true);

            //Validamos los datos recibidos
            $validate = \Validator::make($params_array, [
                'title' => 'required|min:5',
                'description' => 'required',
                'status' => 'required',
                'price' => 'required'
            ]);

            if($validate->fails())
            {
                return response()->json($validate->errors(), 400);
            }

            //Guardamos los datos del coche
            $car = new Car();

            $car->user_id = $user->sub;
            $car->title = $params->title;
            $car->description = $params->description;
            $car->status = $params->status;
            $car->price = $params->price;

            $car->save();

            $data = array(
                'car' => $car,
                'status' => 'success',
                'code' => '200',
                'message' => 'Coche creado correctamente'
            );
        } 
        else
        {
            //ERROR
            $data = array(
                'status' => 'error',
                'code' => '400',
                'message' => 'Login fallido - No existe TOKEN'
            );  
        }

        return response()->json($data, 200);
    }

    /**
     * Metodo para eliminar un vehiculo
     */
    public function destroy($id, Request $request)
    {
        $hash = $request->header('Authorization', null);

        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);
        
        if($checkToken)
        {
            //Comprobamos si el vehiculo existe en la BBDD
            $car = Car::find($id);

            if(count($car) != 0)
            {
                //Borramos el registro
                $car->delete();

                $data = array(
                    'car' => $car,
                    'status' => 'success',
                    'code' => '200',
                    'message' => 'Coche eliminado correctamente'
                );
            }
            else
            {
                //No existe
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'ERROR Vehiculo no existe'
                );
            }
        } 
        else
        {
            //ERROR
            $data = array(
                'status' => 'error',
                'code' => '400',
                'message' => 'Login fallido - No existe TOKEN'
            );  
        }

        return response()->json($data, 200);
    }
} //END CLASS CAR CONTROLLER
