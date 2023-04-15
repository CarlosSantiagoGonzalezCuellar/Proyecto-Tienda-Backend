<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productoId = "";
    private $proCodigo = "";
    private $proNombre = "";
    private $proPrecio = "";
    private $category_id = "";
    private $proDescripcion = "";
    private $proImagen = "";

    /**
     * METODO DE URL INDEX DE PRODUCT: 1=GET - 2=PATCH
     *
     * Se recibe por key (id=#) el id del producto y se trae la encontrada o se traen todos
     * los datos en caso de no haber key. Si la opcion es 1
     *
     * Se reciben los datos de entrada y por medio del id se actualiza el producto
     * con los datos requeridos si la opcion es 2
     *
     * @param Request $request Datos de entrada
     * @param int $opcion Opcion digitada en la url para decidir el metodo
     * @return json Datos con el result y/o el id del producto actualizado
     **/
    public function index(Request $request, $opcion)
    {
        if ($opcion == "1") {
            if (isset($_GET["id"])) {
                $productoId = $_GET["id"];
                $products = Product::select('products.id', 'products.proCodigo', 'products.proNombre', 'products.proPrecio', 'categories.catNombre', 'products.proDescripcion', 'products.proImagen')
                    ->join('categories', 'products.category_id', '=', 'categories.id')
                    ->where('products.id', $productoId)
                    ->get();
            } else {
                $products = Product::select('products.id', 'products.proCodigo', 'products.proNombre', 'products.proPrecio', 'categories.catNombre', 'products.proDescripcion', 'products.proImagen')
                    ->join('categories', 'products.category_id', '=', 'categories.id')
                    ->get();
            }

            return response()->json($products);


        } elseif ($opcion == "2") {
            $_respuestas = new respuestas;
            $datos = json_decode($request->getContent());

            if (!isset($datos->id)) {
                return $_respuestas->error_400();

            } else {
                $this->productoId = $datos->id;

                if (isset($datos->proCodigo)) {
                    $this->proCodigo = $datos->proCodigo;
                }
                if (isset($datos->proNombre)) {
                    $this->proNombre = $datos->proNombre;
                }
                if (isset($datos->proPrecio)) {
                    $this->proPrecio = $datos->proPrecio;
                }
                if (isset($datos->category_id)) {
                    $this->category_id = $datos->category_id;
                }
                if (isset($datos->proDescripcion)) {
                    $this->proDescripcion = $datos->proDescripcion;
                }
                if (isset($datos->proImagen)) {
                    $this->proImagen = $datos->proImagen;
                }

                $_product = Product::find($this->productoId);
                $resultArray = array();

                foreach ($_product as $key) {
                    $resultArray[] = $key;
                }
                $datos = $this->convertirUtf8($resultArray);

                if ($datos) {
                    $_product->proCodigo = $this->proCodigo;
                    $_product->proNombre = $this->proNombre;
                    $_product->proPrecio = $this->proPrecio;
                    $_product->category_id = $this->category_id;
                    $_product->proDescripcion = $this->proDescripcion;
                    $_product->proImagen = $this->proImagen;
                    $_product->save();

                    $respu = $_product;
                    if ($respu) {
                        $resp = $respu;
                    } else {
                        $resp = 0;
                    }

                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id" => $this->productoId
                        );
                        return $respuesta;
                    } else {
                        return $_respuestas->error_500();
                    }
                } else {
                    return $_respuestas->error_200("Producto inactivo!!");
                }
            }
        }
    }


    /**
     * METODO DE URL CREATE DE PRODUCT: POST
     *
     * Se reciben los datos de entrada y se crea el producto
     * con los datos requeridos
     *
     * @param Request $request Datos de entrada
     * @return json Datos con el result y el id del producto creado
     **/
    public function create(Request $request)
    {
        $_respuestas = new respuestas;
        $_product = new Product();
        $datos = json_decode($request->getContent());

        if (
            !isset($datos->proCodigo) || !isset($datos->proNombre) || !isset($datos->proPrecio) || !isset($datos->category_id)
            || !isset($datos->proDescripcion) || !isset($datos->proImagen)
        ) {
            return $_respuestas->error_400();
        } else {
            $this->proCodigo = $datos->proCodigo;
            $this->proNombre = $datos->proNombre;
            $this->proPrecio = $datos->proPrecio;
            $this->category_id = $datos->category_id;
            $this->proDescripcion = $datos->proDescripcion;
            $this->proImagen = $datos->proImagen;

            $_product->proCodigo = $this->proCodigo;
            $_product->proNombre = $this->proNombre;
            $_product->proPrecio = $this->proPrecio;
            $_product->category_id = $this->category_id;
            $_product->proDescripcion = $this->proDescripcion;
            $_product->proImagen = $this->proImagen;
            $_product->save();

            $respu = $_product;
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
     * METODO DE URL DELETE DE PRODUCT: DELETE
     *
     * Se reciben los datos de entrada y por medio del id se elimina el producto
     *
     * @param Request $request Datos de entrada
     * @return json Datos con el result y el id del producto eliminado
     **/
    public function delete(Request $request)
    {
        $_respuestas = new respuestas;
        $datos = json_decode($request->getContent());

        if (!isset($datos->id)) {
            return $_respuestas->error_400();

        } else {
            $this->productoId = $datos->id;

            $_product = Product::find($this->productoId);
            $_product->delete();

            $respuesta = $_respuestas->response;
            $respuesta["result"] = array(
                "id" => $this->productoId
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
