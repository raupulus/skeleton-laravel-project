<?php
/**
 * Created by PhpStorm.
 * User: Raúl Caro Pastorino
 * Date: 05/06/2019
 * Time: 13:50
 */

class FormHelper
{
    /**
     * Devuelve una estructura select con el elemento marcado.
     *
     * @param      $title         Título del select para el label.
     * @param      $name          Nombre del formulario, atributo "name".
     * @param      $colection     Colección con los elementos del select.
     * @param      $eleName       Nombre del atributo visible en cada option.
     * @param null $seleccionado  El id del elemento selccionado.
     * @param null   $class       Clases del elemento select.
     * @param string $option0     Título de la opción por defecto.
     *
     * @return string
     */
    public static function select($title, $name, $colection,
                                  $eleName, $seleccionado = null, $class = null,
                                  $option0 = 'Selecciona una Opción')
    {
        if (is_null($class)) {
            $class = 'form-control';
        }

        $html = '<label for="' . $name . '">' .
            $title .
            '</label>' .
            '<select name="' . $name . '" class="' . $class . '">' .
            '<option value="0">' .
            $option0 .
            '</option>';

        foreach($colection as $ele) {
            $selected = ($ele->id == $seleccionado) ? 'selected' : '';

            $html .= '<option value="' . $ele->id . '"' . $selected . '>' .
                $ele->{$eleName} .
                '</option>';
        }

        $html .= '</select>';

        return $html;
    }

    /**
     * Devuelve el atributo selected o cadena vacía para un elemento select.
     *
     * @param $id_selected Elemento seleccionado.
     * @param $id_current Elemento de la iteración actual a comparar.
     *
     * @return string Devuelve selected o cadena vacía.
     */
    public static function selected($id_selected, $id_current)
    {
        return $id_selected == $id_current ? 'selected' : '';
    }
}
