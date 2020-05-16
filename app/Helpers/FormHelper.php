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



    /******************************************
     * CAMPOS DE FORMULARIO COMPLETOS
     ******************************************/
    /**
     * Devuelve un campo input de tipo text.
     *
     * @param array $attributes Array con los atributos.
     *
     * @return string
     */
    private static function input($value, $attributesArray)
    {
        $attributesArray = array_merge([
            'value' => old($attributesArray['name'], $value),
        ], $attributesArray);

        $attributes = '';

        foreach ($attributesArray as $idx => $att) {
            $attributes .= ' ' . $idx . '="' . $att . '" ';
        }

        return '<input ' . $attributes . ' />';
    }

    /**
     * Genera una etiquita de tipo label asociada a un input.
     *
     * @param $title
     * @param $inputName
     *
     * @return string
     */
    public static function label($title, $inputName)
    {
        return '<label for="' . $inputName .'">' . $title . '</label>';
    }

    /**
     * Devuelve un campo input de tipo text.
     *
     * @param string $name Etiqueta "name" del formulario.
     * @param string $value El valor del input.
     * @param array $attributes Atributos para el input.
     *
     * @return string
     */
    public static function inputText($name, $value = '', $attributes = [])
    {
        $attributes = array_merge([
            'class' => 'form-control form-field-text',
            'type' => 'text',
            'name' => $name,
        ], $attributes);

        return self::input($value, $attributes);
    }

    /**
     * Crea un elemento textarea
     *
     * @param string $name El nombre del elemento en el formulario.
     * @param string $value El valor del contenido.
     * @param array  $attributesArray Un array con los atributos.
     *
     * @return string
     */
    public static function textarea($name, $value = '', $attributesArray = [])
    {
        $attributesArray = array_merge([
            'class' => 'form-control',
        ], $attributesArray);

        $attributes = '';

        foreach ($attributesArray as $idx => $att) {
            $attributes .= ' ' . $idx . '="' . $att . '" ';
        }

        return '<textarea ' . $attributes . '>' .
            old($name, $value) .
            '</textarea>';
    }

    public static function submit($title = 'Enviar', $icon = '', $attributesArray = [])
    {
        $attributesArray = array_merge([
            'class' => 'btn btn-primary',
        ], $attributesArray);

        $attributes = '';

        foreach ($attributesArray as $idx => $att) {
            $attributes .= ' ' . $idx . '="' . $att . '" ';
        }

        return '<button type="submit" ' . $attributes . '>' .
                ($icon ? '<i class="' . $icon . '"></i> ' : '') .
                $title .
            '</button>';
    }
}

?>
