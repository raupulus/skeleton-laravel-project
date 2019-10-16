<?php
/**
 * Created by PhpStorm.
 * User: Raúl Caro
 * Date: 23/04/2019
 * Time: 16:21
 */


class Buttom
{
    /**
     * Devuelve un botón para eliminar.
     *
     * @param       $action URL del controlador que llamará.
     * @param       $id El id del elemento a eliminar.
     * @param array $options Opciones posibles:
     *              class => clases css,
     *              text => Nombre del botón
     *              valueId => Prefijo del id para el formulario
     *
     * @return string
     */
    public static function delete($action, $id,  $options = [])
    {
        if (! array_key_exists('class', $options)) {
            $options['class'] = 'btn btn-sm btn-danger pull-right delete';
        }

        if (! array_key_exists('text', $options)) {
            $options['text'] = 'Eliminar';
        }

        if (! array_key_exists('valueId', $options)) {
            $options['valueId'] = 'form-delete';
        }

        return '<form action="' . $action . '" ' .
            'method="POST" ' .
            'id="' . $options['valueId'] . '-' . $id . '">' .
            csrf_field() .

            '<input type="hidden" name="id" value="' . $id . '">' .

            '<button type="button" ' .
            'class="' . $options['class'] . '" ' .
            'onclick="' . jsHelper::confirm() . '">' .
            '<i class="fa fa-trash"></i> ' .
            '<span class="hidden-xs hidden-sm">' .
            $options['text'] .
            '</span>' .
            '</button>' .
            '</form>';
    }

    /**
     * Devuelve un botón para editar.
     *
     * @param       $action URL del controlador que llamará.
     * @param       $id El id del elemento a editar.
     * @param array $options Opciones posibles:
     *              class => clases css,
     *              text => Nombre del botón
     *              valueId => Prefijo del id para el formulario
     *
     * @return string
     */
    public static function edit($action, $id,  $options = [])
    {
        if (! array_key_exists('class', $options)) {
            $options['class'] = 'btn btn-sm btn-primary pull-right edit';
        }

        if (! array_key_exists('text', $options)) {
            $options['text'] = 'Editar';
        }

        if (! array_key_exists('valueId', $options)) {
            $options['valueId'] = 'form-edit';
        }

        return '<form action="' . $action . '" ' .
            'method="POST" ' .
            'id="' . $options['valueId'] . '-' . $id . '">' .
            csrf_field() .

            '<input type="hidden" name="id" value="' . $id . '">' .

            '<button type="submit" ' .
            'class="' . $options['class'] . '">' .
            '<i class="fa fa-check"></i> ' .
            '<span class="hidden-xs hidden-sm">' .
            $options['text'] .
            '</span>' .
            '</button>' .
            '</form>';
    }

    /**
     * Devuelve un botón para aprobar.
     *
     * @param       $action URL del controlador que llamará.
     * @param       $id El id del elemento a aprobar.
     * @param array $options Opciones posibles:
     *              class => clases css,
     *              text => Nombre del botón
     *              valueId => Prefijo del id para el formulario
     *
     * @return string
     */
    public static function aprobar($action, $id,  $options = [])
    {
        if (! array_key_exists('class', $options)) {
            $options['class'] = 'btn btn-sm btn-success pull-right edit';
        }

        if (! array_key_exists('text', $options)) {
            $options['text'] = 'Aprobar';
        }

        if (! array_key_exists('valueId', $options)) {
            $options['valueId'] = 'form-aprobar';
        }

        return '<form action="' . $action . '" ' .
            'method="POST" ' .
            'id="' . $options['valueId'] . '-' . $id . '" >' .
            csrf_field() .

            '<input type="hidden" name="id" value="' . $id . '">' .

            '<button type="submit" ' .
            'class="' . $options['class'] . '">' .
            '<i class="fa fa-check"></i> ' .
            '<span class="hidden-xs hidden-sm">' .
            $options['text'] .
            '</span>' .
            '</button>' .
            '</form>';
    }

    /**
     * Devuelve un botón para ver.
     *
     * @param       $action URL del controlador que llamará.
     * @param       $id El id del elemento a ver.
     * @param array $options Opciones posibles:
     *              class => clases css,
     *              text => Nombre del botón
     *              valueId => Prefijo del id para el formulario
     *
     * @return string
     */
    public static function view($action, $id,  $options = [])
    {
        if (!array_key_exists('class', $options)) {
            $options['class'] = 'btn btn-sm btn-success pull-right view';
        }

        if (!array_key_exists('text', $options)) {
            $options['text'] = 'Ver';
        }

        if (!array_key_exists('valueId', $options)) {
            $options['valueId'] = 'form-view';
        }

        return '<a ' . 'id="' . $options['valueId'] . '-' . $id . '" ' .
            'class="' . $options['class'] . '" ' .
            'href="' . $action . '">' .
            '<i class="fa fa-eye"></i> ' .
            '<span class="hidden-xs hidden-sm">' .
            $options['text'] .
            '</span>' .
            '</a>';
    }


    /**
     * Recibe un booleano y devuelve su estado activo/inactivo.
     *
     * @param $boolean
     *
     * @return string
     */
    public static function active($boolean)
    {
        $texto = '';
        $clases = 'label';

        if ($boolean) {
            $clases .= ' label-primary';
            $texto = 'Activo';
        } else {
            $clases .= ' label-danger';
            $texto = 'Inactivo';
        }

        return '<span class="' . $clases . '">' .
            $texto .
            '</span>';
    }

    /**
     * Recibe un booleano e indica si está activo o inactivo con un icono
     * en forma de estrella.
     *
     * @param $item
     * @param $route
     * @param $active
     *
     * @return string
     */
    public static function favorite($item, $route, $active)
    {
        $classFavorite = ($active) ? 'favorite' : '' ;

        $button = '<span class="fa fa-star '. $classFavorite .'" data-item_id="' . $item . '" data-route="'. $route .'"></span>';

        return $button;
    }
}
