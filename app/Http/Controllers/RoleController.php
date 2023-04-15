<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $rolId = "";
    private $rolNombre = "";

    /**
     * METODO DE URL INDEX DE ROLE: 1=GET - 2=PATCH
     *
     * Se recibe por key (id=#) el id del rol y se trae la encontrada o se traen todos
     * los datos en caso de no haber key. Si la opcion es 1
     *
     * Se reciben los datos de entrada y por medio del id se actualiza el rol
     * con los datos requeridos si la opcion es 2
     *
     * @param Request $request Datos de entrada
     * @param int $opcion Opcion digitada en la url para decidir el metodo
     * @return json Datos con el result y/o el id del rol actualizado
     **/
    public function index(Request $request, $opcion)
    {
        if ($opcion == "1") {
            if (isset($_GET["id"])) {
                $rolId = $_GET["id"];
                $roles = Role::select('roles.id', 'roles.rolNombre')
                    ->where('roles.id', $rolId)
                    ->get();
            } else {
                $roles = Role::select('roles.id', 'roles.rolNombre')
                    ->get();
            }

            return response()->json($roles);


        } elseif ($opcion == "2") {
            $_respuestas = new respuestas;
            $datos = json_decode($request->getContent());

            if (!isset($datos->id)) {
                return $_respuestas->error_400();
            } else {
                $this->rolId = $datos->id;

                if (isset($datos->rolNombre)) {
                    $this->rolNombre = $datos->rolNombre;
                }

                $_role = Role::find($this->rolId);
                $resultArray = array();

                foreach ($_role as $key) {
                    $resultArray[] = $key;
                }
                $datos = $this->convertirUtf8($resultArray);

                if ($datos) {
                    $_role->rolNombre = $this->rolNombre;
                    $_role->save();

                    $respu = $_role;
                    if ($respu) {
                        $resp = $respu;
                    } else {
                        $resp = 0;
                    }

                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id" => $this->rolId
                        );
                        return $respuesta;
                    } else {
                        return $_respuestas->error_500();
                    }
                } else {
                    return $_respuestas->error_200("Rol inactivo!!");
                }
            }
        }
    }


    /**
     * METODO DE URL CREATE DE ROLE: POST
     *
     * Se reciben los datos de entrada y se crea el rol
     * con los datos requeridos
     *
     * @param Request $request Datos de entrada
     * @return json Datos con el result y el id del rol creado
     **/
    public function create(Request $request)
    {
        $_respuestas = new respuestas;
        $_role = new Role();
        $datos = json_decode($request->getContent());

        if (!isset($datos->rolNombre)) {
            return $_respuestas->error_400();

        } else {
            $this->rolNombre = $datos->rolNombre;
            $_role->rolNombre = $this->rolNombre;
            $_role->save();

            $respu = $_role;
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
     * METODO DE URL DELETE DE ROLE: DELETE
     *
     * Se reciben los datos de entrada y por medio del id se elimina el rol
     *
     * @param Request $request Datos de entrada
     * @return json Datos con el result y el id del rol eliminado
     **/
    public function delete(Request $request)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($request->getContent());

        if (!isset($datos->id)) {
            return $_respuestas->error_400();
        } else {
            $this->rolId = $datos->id;

            $_role = Role::find($this->rolId);
            $_role->delete();

            $respuesta = $_respuestas->response;
            $respuesta["result"] = array(
                "id" => $this->rolId
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
