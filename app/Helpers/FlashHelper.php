<?php
/**
 * Created by PhpStorm.
 * User: Raúl Caro Pastorino
 * Date: 21/08/2020
 * Time: 12:32
 */

/**
 * Class FlashHelper
 *
 * Clase para ayudar con los mensajes en sesión, estos serán establecidos en
 * la sesión y eliminados tras llegar a la vista por primera vez.
 * De este modo podemos enviar rápidamente mensajes cuando nos interesa que
 * sean mostrados solo una vez al usuario y desaparezcan.
 */
class FlashHelper
{
    /**
     * Función que establece el flash en la sesión.
     *
     * @param string $level Indica el tipo aviso que mostrará luego la vista (key)
     * @param string $message Este es el mensaje (value)
     */
    private static function send($level, $message)
    {
        session()->flash('flash_notification', ['level' => $level, 'message' => $message]);
    }

    /**
     * Mensaje indicando un suceso correcto.
     * El color de este será verde.
     *
     * @param string $message El mensaje a ser mostrado.
     */
    public static function success($message)
    {
        self::send('success', $message);
    }

    /**
     * Mensaje mostrando información adicional o interesante.
     * El color de este será azul.
     *
     * @param string $message El mensaje a ser mostrado.
     */
    public static function info($message)
    {
        self::send('info', $message);
    }

    /**
     * Mensaje advirtiendo sobre algo.
     * El color de este será amarillo.
     *
     * @param string $message El mensaje a ser mostrado.
     */
    public static function warning($message)
    {
        self::send('warning', $message);
    }

    /**
     * Mensaje de problema o error.
     * El color de este será rojo.
     *
     * @param string $message El mensaje a ser mostrado.
     */
    public static function danger($message)
    {
        self::send('danger', $message);
    }

    /**
     * Mensaje de problema o error.
     * El color de este será rojo.
     *
     * @param string $message El mensaje a ser mostrado.
     */
    public static function error($message)
    {
        self::danger($message);
    }
}
