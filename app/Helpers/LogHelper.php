<?php
/**
 * Created by PhpStorm.
 * User: Raúl Caro
 * Date: 24/09/2019
 * Time: 17:36
 */

/**
 * Class RoleHelper
 *
 * Funciones de soporte para registrar sucesos/eventos clasificados.
 */
class LogHelper
{
    /**
     * Ruta donde almacenar el log.
     */
    private const LOGPATH = 'path/to/log';

    /**
     * Tipos de eventos a registrar.
     */
    private const EVENTS = [
        'info',
        'error',
        'success',
    ];

    /**
     * Registra un suceso recibiendo el tipo y el mensaje a registrar.
     *
     * @param $type
     * @param $message
     *
     * @return bool
     */
    public static function register($type, $message)
    {
        $created_by = auth()->id();
        // TODO → Guarda en DB
        // TODO → Guardar en Log
        return true;
    }
}
