<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $usuarioId = "";
    private $useNombre = "";
    private $role_id = "";
    private $useCorreo = "";
    private $usePassword = "";

    /**
     * METODO DE URL POR DEFECTO DE USER
     *
     * Se recibe por key (id=#) el id del usuario y se trae la encontrada o se traen todos
     * los datos en caso de no haber key. Si la opcion es 1
     *
     * @param Request $request Datos de entrada
     * @return json Datos con el result
     **/
    public function __invoke()
    {
        if (isset($_GET["id"])) {
            $usuarioId = $_GET["id"];
            $users = User::select('users.id', 'users.useNombre', 'roles.rolNombre', 'users.useCorreo', 'users.usePassword')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->where('users.id', $usuarioId)
                ->get();
        } else {
            $users = User::select('users.id', 'users.useNombre', 'roles.rolNombre', 'users.useCorreo', 'users.usePassword')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->get();
        }
        return response()->json($users);
    }


    /**
     * METODO DE URL INDEX DE USER: 1=GET - 2=PATCH
     *
     * Se recibe por key (id=#) el id del usuario y se trae la encontrada o se traen todos
     * los datos en caso de no haber key. Si la opcion es 1
     *
     * Se reciben los datos de entrada y por medio del id se actualiza el usuario
     * con los datos requeridos si la opcion es 2
     *
     * @param Request $request Datos de entrada
     * @param int $opcion Opcion digitada en la url para decidir el metodo
     * @return json Datos con el result y/o el id del usuario actualizado
     **/
    public function index(Request $request, $opcion)
    {
        if ($opcion == "1") {
            if (isset($_GET["id"])) {
                $usuarioId = $_GET["id"];
                $users = User::select('users.id', 'users.useNombre', 'roles.rolNombre', 'users.useCorreo', 'users.usePassword')
                    ->join('roles', 'users.role_id', '=', 'roles.id')
                    ->where('users.id', $usuarioId)
                    ->get();
            } else {
                $users = User::select('users.id', 'users.useNombre', 'roles.rolNombre', 'users.useCorreo', 'users.usePassword')
                    ->join('roles', 'users.role_id', '=', 'roles.id')
                    ->get();
            }
            return response()->json($users);

        } elseif ($opcion == "2") {
            $_respuestas = new respuestas;
            $datos = json_decode($request->getContent());

            if (!isset($datos->id)) {
                return $_respuestas->error_400();
            } else {
                $this->usuarioId = $datos->id;

                if (isset($datos->useNombre)) {
                    $this->useNombre = $datos->useNombre;
                }
                if (isset($datos->useCorreo)) {
                    $this->useCorreo = $datos->useCorreo;
                }
                if (isset($datos->usePassword)) {
                    $this->usePassword = $datos->usePassword;
                }
                if (isset($datos->role_id)) {
                    $this->role_id = $datos->role_id;
                }

                $_user = User::find($this->usuarioId);
                $resultArray = array();

                foreach ($_user as $key) {
                    $resultArray[] = $key;
                }
                $datos = $this->convertirUtf8($resultArray);

                if ($datos) {
                    $_user->useNombre = $this->useNombre;
                    $_user->role_id = $this->role_id;
                    $_user->useCorreo = $this->useCorreo;
                    $_user->usePassword = Hash::make($this->usePassword);
                    $_user->save();

                    $respu = $_user;
                    if ($respu) {
                        $resp = $respu;
                    } else {
                        $resp = 0;
                    }

                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id" => $this->usuarioId
                        );
                        return $respuesta;
                    } else {
                        return $_respuestas->error_500();
                    }
                } else {
                    return $_respuestas->error_200("Usuario inactivo!!");
                }
            }
        }
    }


    /**
     * METODO DE URL CREATE DE USER: POST
     *
     * Se reciben los datos de entrada y se crea el usuario
     * con los datos requeridos
     *
     * @param Request $request Datos de entrada
     * @return json Datos con el result y el id del usuario creado
     **/
    public function create(Request $request)
    {
        $_respuestas = new respuestas;
        $_user = new User;
        $datos = json_decode($request->getContent());

        if (!isset($datos->useNombre) || !isset($datos->role_id) || !isset($datos->useCorreo) || !isset($datos->usePassword)) {
            return $_respuestas->error_400();

        } else {
            $this->useNombre = $datos->useNombre;
            $this->role_id = $datos->role_id;
            $this->useCorreo = $datos->useCorreo;
            $this->usePassword = $datos->usePassword;

            $_user->useNombre = $this->useNombre;
            $_user->role_id = $this->role_id;
            $_user->useCorreo = $this->useCorreo;
            $_user->usePassword = Hash::make($this->usePassword);
            $_user->save();

            $respu = $_user;
            if ($respu["id"]) {
                $resp = $respu["id"];
            } else {
                $resp = 0;
            }

            if ($resp != null) {
                $resp = $resp;
            } else {
                $resp = 0;
            }

            if ($resp != null) {
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id" => $resp
                );
                return $respuesta;
            } else {
                return $_respuestas->error_500();
            }
        }
    }


    /**
     * METODO DE URL DELETE DE USER: DELETE
     *
     * Se reciben los datos de entrada y por medio del id se elimina el usuario
     *
     * @param Request $request Datos de entrada
     * @return json Datos con el result y el id del usuario eliminado
     **/
    public function delete(Request $request)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($request->getContent());

        if (!isset($datos->id)) {
            return $_respuestas->error_400();

        } else {
            $this->usuarioId = $datos->id;

            $_user = User::find($this->usuarioId);
            $_user->delete();

            $respuesta = $_respuestas->response;
            $respuesta["result"] = array(
                "id" => $this->usuarioId
            );
            return $respuesta;
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
