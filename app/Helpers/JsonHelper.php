<?php
/**
 * Created by PhpStorm.
 * User: Raúl Caro
 * Date: 08/05/2020
 * Time: 18:19
 */

/*
https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
201 Created
202 Accepted
204 No Content
301 Moved Permanently
302 Moved Tempor
400 Bad Request
401 Unauthorized
403 Forbidden
404 Not Found
405 Method Not Allowed
408 Request Timeout
500 Internal Server Error
501 Not Implemented
507 Insufficient Storage
 */

/**
 * Class RoleHelper
 *
 * Funciones de soporte para registrar sucesos/eventos clasificados.
 */
class JsonHelper
{
    /**
     * Mensaje confirmando procedimiento correcto.
     *
     * @var array
     */
    private static $success = [
        'success' => true,  // Estado de la petición.
        'message' => null,  // Mensaje de estado humanamente legible.
        'source' => [  // Información sobre el origen.
            'domain' => null,
            'url' => null,
            'full_url' => null,
            'path' => null,
        ],
        'link' => [  // Información sobre la url solicitada.
            'rel' => 'self',
            'href' => null,  // Url actual.
        ],
        'data' => null,
    ];

    /**
     * Mensaje que declara un error seguro.
     *
     * @var array
     */
    private static $error = [
        'success' => false,  // Estado de la petición
        'message' => null,  // Mensaje de estado humanamente legible.
        'source' => [  // Información sobre el origen.
            'domain' => null,
            'url' => null,
            'full_url' => null,
            'path' => null,
        ],
        'link' => [  // Información sobre la url solicitada.
            'rel' => 'self',
            'href' => null,  // Url actual.
        ],
        'error' => [
            'id' => null,  // Código de error interno a la app.
            'code' => null,  // Codigo http para el error.
            'message' => null,  // Mensaje del error.
            'trace' => null,  // Pila de errores.
        ],
    ];

    /**
     * Devuelve un array con el formato de respuesta para mezclar con el
     * $success o el $error rellenando la información sobre el sitio.
     *
     * @return array[]
     */
    private static function siteData()
    {
        return [
            'source' => [
                'domain' => request()->getHost(),
                'url' => request()->root(),
                'full_url' => request()->fullUrl(),
                'path' => request()->path(),
            ],
            'link' => [
                'rel' => 'self',
                'href' => request()->fullUrl(),

            ],
        ];
    }


    /**
     * Prepara un mensaje de respuesta cuando se ha llevado a cabo correctamente
     * la petición.
     *
     * @param array       $data Datos de la respuesta.
     * @param String|null $msg Mensaje sobre el proceso.
     * @param Int         $status Estado de la respuesta.
     *
     * @return \Illuminate\Http\JsonResponse Devuelve la respuesta final.
     */
    public static function success(Array $data,
                                   String $msg = null,
                                   Int $status = 200)
    {
        $response = array_merge(
            self::$success,
            self::siteData(),
            [
                'data' => $data,
                'message' => $msg,
            ],
        );

        return response()->json($response, $status);
    }

    /**
     * Prepara un mensaje de error para una acción fallida.
     *
     * @param String|null     $msg Mensaje en formato humano.
     * @param Int             $status Código http del error.
     * @param \Exception|null $trace Excepción de seguimiento.
     * @param Int|null        $id Id del error dentro de la aplicación.
     *
     * @return \Illuminate\Http\JsonResponse Devuelve la respuesta final.
     */
    public static function error(String $msg = null,
                                 Int $status = 400,
                                 Exception $trace = null,
                                 Int $id = null)
    {
        $response = array_merge(
            self::$error,
            self::siteData(),
            [
                'error' => [
                    'id' => $id,
                    'code' => $status,
                    'trace' => $trace,
                    'message' => $msg,
                ],
            ],
        );

        return response()->json($response, $status);
    }

    /**
     * Respuesta indicando que se ha creado un elemento correctamente.
     *
     * @param array $data
     *
     * @return \Illuminate\Http\JsonResponse Devuelve la respuesta final.
     */
    public static function created(Array $data)
    {
        return self::success(
            $data,
            'Se ha creado correctamente',
            201
        );
    }

    /**
     * Respuesta indicando que la petición ha sido aceptada.
     *
     * @param array $data Datos de la respuesta.
     *
     * @return \Illuminate\Http\JsonResponse Devuelve la respuesta final.
     */
    public static function accepted(Array $data)
    {
        return self::success(
            $data,
            'Se ha recibido la petición correctamente',
            202
        );
    }
}
