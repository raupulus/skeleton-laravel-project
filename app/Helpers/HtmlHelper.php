<?php
/**
 * Created by PhpStorm.
 * User: Raúl Caro
 * Date: 23/04/2019
 * Time: 16:21
 */


class Buttom
{
    public static function genericForm($action, $id,  $options = [])
    {
        $options = array_merge([
            'class' => 'm-1 btn btn-sm btn-danger delete',
            'text' => 'Eliminar',
            'valueId' => 'form-delete',
            'icon' => 'fa fa-trash',
            'confirm' => '¿Estás seguro de eliminar?'
        ], $options);

        return
    }

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
        $options = array_merge([
            'class' => 'm-1 btn btn-sm btn-danger delete',
            'text' => 'Eliminar',
            'valueId' => 'form-delete',
            'icon' => 'fa fa-trash',
            'confirm' => '¿Estás seguro de eliminar?'
        ], $options);

        return '<form action="' . $action . '" ' .
            'method="POST" ' .
            'id="' . $options['valueId'] . '-' . $id . '">' .
            csrf_field() .

            '<input type="hidden" name="id" value="' . $id . '">' .

            '<button type="button" ' .
                     'class="' . $options['class'] . '" ' .
                     'onclick="formSendConfirm(event, this, \'' . $options['confirm'] . '\')">' .
                '<i class="' . $options['icon'] . '"></i> ' .
                '<span class="d-none d-md-inline-block">' .
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
        $options = array_merge([
            'class' => 'm-1 btn btn-sm btn-success btn-panel btn-panel-view',
            'text' => 'Ver',
            'valueId' => 'form-view',
            'icon' => 'fa fa-eye',
        ], $options);

        return ' <a ' . 'id="' . $options['valueId'] . '-' . $id . '" ' .
            'class="' . $options['class'] . '" ' .
            'href="' . $action . '">' .
            '<i class="' . $options['icon'] . '"></i> ' .
            '<span class="d-none d-md-inline-block">' .
                $options['text'] .
            '</span>' .
            '</a> ';
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
        $options = array_merge([
            'class' => 'm-1 btn btn-sm btn-warning btn-panel btn-panel-edit',
            'text' => 'Editar',
            'icon' => 'fa fa-edit',
        ], $options);

        return self::view($action, $id, $options);
    }

    /**
     * Devuelve un botón para Acciones.
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
    public static function action($action, $id,  $options = [])
    {
        $options = array_merge([
            'class' => 'm-1 btn btn-sm btn-danger btn-panel btn-panel-action',
            'text' => 'Action',
            'icon' => 'fa fa-tasks-alt',
        ], $options);

        return self::view($action, $id, $options);
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

    /**
     * Devuelve un botón para ver.
     *
     * @param       $action URL del controlador que llamará.
     * @param       $dataName El identificador de tipo "data-name" que tendrá.
     * @param array $options Opciones posibles:
     *              class => clases css.
     *              text => Nombre del botón.
     *              icon => Clases para el icono.
     *
     * @return string
     */
    public static function generic($action, $dataName,  $options = [])
    {
        $options = array_merge([
            'class' => 'm-1 btn btn-primary btn-panel btn-panel-generic',
            'text' => 'Ver',
            'icon' => 'fa fa-edit',
        ], $options);

        return ' <a ' . 'data-name="' . $dataName . '" ' .
            'class="' . $options['class'] . '" ' .
            'href="' . $action . '">' .
            '<i class="' . $options['icon'] . '"></i> ' .
            '<span>' .
                $options['text'] .
            '</span>' .
            '</a> ';
    }
}
