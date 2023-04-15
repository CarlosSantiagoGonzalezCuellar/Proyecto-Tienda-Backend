<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * METODO FUNCIONAMIENTO LOGIN
     *
     * Se reciben los datos de entrada, se verifica que las credenciales sean correctas
     * y se retorna el token con datos de usuario
     *
     * @param Request $request Datos de entrada
     * @return json Datos con el result o el mensaje de error
     **/
    public function login(Request $request)
    {
        $_respuestas = new respuestas;

        $datos = json_decode($request->getContent());
        if (!isset($datos->useCorreo) || !isset($datos->usePassword)) {
            // Error en los campos
            return $_respuestas->error_401();

        } else {
            $correo = $datos->useCorreo;
            $password = $datos->usePassword;

            $_user = User::where('useCorreo', $correo)->firstOrFail();
            $resultArray = array();

            foreach ($_user as $key) {
                $resultArray[] = $key;
            }

            $datos = $this->convertirUtf8($resultArray);

            if ($datos) {
                // Verificar si la contraseña es igual
                if (Hash::check($password, $_user->usePassword)) {
                    $token = $_user->createToken('auth_token')->plainTextToken;
                    if ($token) {
                        $result = $_respuestas->response;

                        $result["result"] = array(
                            "token" => $token,
                            "id" => $_user->id,
                            "nombre" => $_user->useNombre,
                            "rol" => User::find($_user->id)->role->rolNombre
                        );

                        return $result;
                    } else {
                        //No se guardo
                        return $_respuestas->error_500("Error interno, no se ha podido guardar!!");
                    }
                } else {
                    //Contraseña incorrecta
                    return $_respuestas->error_200("La contraseña es invalida!!");
                }
            } else {
                // Si no existe el usuario
                return $_respuestas->error_200("El usuario $correo no existe!!");
            }
        }
    }


    /**
     * METODO PARA CONVERTIR A UTF8
     *
     * Por medio de metodos se recibe un arreglo de datos para convertirlos a UTF8
     *
     * @param array $array Datos del resultado
     * @return array Datos con conversion a UTF8
     **/
    public function convertirUtf8($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, "utf-8", true)) {
                $item = iconv("ISO-8859-1", "UTF-8", $item);
            }
        });
        return $array;
    }
}
