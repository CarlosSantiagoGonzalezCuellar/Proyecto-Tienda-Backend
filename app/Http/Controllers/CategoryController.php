<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\respuestas;

class CategoryController extends Controller
{
    private $categoriaId = "";
    private $catNombre = "";

    /**
     * METODO DE URL INDEX DE CATEGORY: 1=GET - 2=PATCH
     *
     * Se recibe por key (id=#) el id de la categoria y se trae la encontrada o se traen todos
     * los datos en caso de no haber key. Si la opcion es 1
     *
     * Se reciben los datos de entrada y por medio del id se actualiza la categoria
     * con los datos requeridos si la opcion es 2
     *
     * @param Request $request Datos de entrada
     * @param int $opcion Opcion digitada en la url para decidir el metodo
     * @return json Datos con el result y/o el id de la categoria actualizada
     **/
    public function index(Request $request, $opcion)
    {
        if ($opcion == "1") {
            if (isset($_GET["id"])) {
                $categoriaId = $_GET["id"];
                $categories = Category::select('categories.id', 'categories.catNombre')
                    ->where('categories.id', $categoriaId)
                    ->get();
            } else {
                $categories = Category::select('categories.id', 'categories.catNombre')
                    ->get();
            }

            return response()->json($categories);
        } elseif ($opcion == "2") {
            $_respuestas = new respuestas;
            $datos = json_decode($request->getContent());

            if (!isset($datos->id)) {
                return $_respuestas->error_400();
            } else {
                $this->categoriaId = $datos->id;

                if (isset($datos->catNombre)) {
                    $this->catNombre = $datos->catNombre;
                }

                $_category = Category::find($this->categoriaId);
                $resultArray = array();

                foreach ($_category as $key) {
                    $resultArray[] = $key;
                }
                $datos = $this->convertirUtf8($resultArray);

                if ($datos) {
                    $_category->catNombre = $this->catNombre;
                    $_category->save();

                    $respu = $_category;
                    if ($respu) {
                        $resp = $respu;
                    } else {
                        $resp = 0;
                    }

                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id" => $this->categoriaId
                        );
                        return $respuesta;
                    } else {
                        return $_respuestas->error_500();
                    }
                } else {
                    return $_respuestas->error_200("Categoria inactiva!!");
                }
            }
        }
    }


    /**
     * METODO DE URL CATEGORY PARA TRAER PRODUCTOS SEGUN LA CATEGORIA
     *
     * Por medio de una key (id=#) en la url se traen los productos segun categoria
     *
     * @return json respuesta de los datos o mensaje de error
     **/
    public function getProductsOfCategory()
    {
        $_respuestas = new respuestas;
        if (isset($_GET["id"])) {
            $categoriaId = $_GET["id"];
            $products = Category::find($categoriaId)->products;
            return response()->json($products);
        } else {
            return $_respuestas->error_200("Debe añadir a la url una key donde este el id de la categoria!!");
        }
    }


    /**
     * METODO DE URL CREATE DE CATEGORY: POST
     *
     * Se reciben los datos de entrada y se crea la categoria
     * con los datos requeridos
     *
     * @param Request $request Datos de entrada
     * @return json Datos con el result y el id de la categoria creada
     **/
    public function create(Request $request)
    {
        $_respuestas = new respuestas;
        $_category = new Category();
        $datos = json_decode($request->getContent());

        if (!isset($datos->catNombre)) {
            return $_respuestas->error_400();
        } else {
            $this->catNombre = $datos->catNombre;
            $_category->catNombre = $this->catNombre;
            $_category->save();

            $respu = $_category;
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
     * METODO DE URL DELETE DE CATEGORY: DELETE
     *
     * Se reciben los datos de entrada y por medio del id se elimina la categoria
     *
     * @param Request $request Datos de entrada
     * @return json Datos con el result y el id de la categoria eliminada
     **/
    public function delete(Request $request)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($request->getContent());

        if (!isset($datos->id)) {
            return $_respuestas->error_400();
        } else {
            $this->categoriaId = $datos->id;

            $_category = Category::find($this->categoriaId);
            $_category->delete();

            $respuesta = $_respuestas->response;
            $respuesta["result"] = array(
                "id" => $this->categoriaId
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
