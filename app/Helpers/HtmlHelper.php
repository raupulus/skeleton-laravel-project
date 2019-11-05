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
     * Devuelve un botón genérico.
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

    /**
     * Devuelve un botón genérico con un formulario dentro.
     *
     * @param       $action URL del controlador que llamará.
     * @param       $id El id del elemento sobre el que actúa.
     * @param array $options Opciones posibles:
     *              class => clases css.
     *              text => Nombre del botón.
     *              valueId => Prefijo del id para el formulario.
     *              icon => Clases css para el icono del botón.
     *              confirm => Mensaje para confirmar envío.
     *              method => Tipo de envío para el formulario.
     *              alert => Indica si muestra cartel para confirmar envío.
     *              inputs => Campos ocultos extras: [name => value]
     *              attributes => Cadena con atributos extras para el botón.
     *
     * @return string
     */
    public static function genericForm($action, $id,  $options = [])
    {
        $options = array_merge([
            'class' => 'm-1 btn btn-sm btn-danger generic',
            'text' => 'Botón',
            'valueId' => 'form-generic',
            'icon' => 'fa fa-trash',
            'confirm' => '¿Estás seguro de continuar?',
            'method' => 'POST',
            'alert' => false,
            'inputs' => [],  ## Representa todos los campos ocultos
            'attributes' => '',
        ], $options);

        $form = '<form action="' . $action . '" ' .
            'method="' . $options['method'] . '" ' .
            'id="' . $options['valueId'] . '-' . $id . '">' .
            csrf_field() .

            '<input type="hidden" name="id" value="' . $id . '">';

        foreach ($options['inputs'] as $name => $value) {
            $form .= '<input type="hidden" name="' . $name . '" value="' . $value . '">';
        }

        $form .= '<button ' .
            'class="' . $options['class'] . '" ';
        $form .= $options['attributes'];

        if ($options['alert']) {
            $form .= 'onclick="formSendConfirm(event, this, \'' . $options['confirm'] . '\')"';
            $form .= ' type="button"';
        } else {
            $form .= ' type="submit"';
        }

        $form .= '><i class="' . $options['icon'] . '"></i> ' .
            '<span class="d-none d-md-inline-block">' .
                $options['text'] .
            '</span>' .
        '</button>' .
        '</form>';

        return $form;
    }

    /**
     * Devuelve un botón para cerrar la sesión.
     */
    public static function logout($options = [])
    {
        $action = route('logout');
        $id = random_int(1, 9999999);

        $options = array_merge([
            'class' => 'm-1 btn btn-sm btn-primary logout',
            'text' => 'Salir',
            'valueId' => 'form-logout',
            'icon' => 'fa fa-sign-out',
        ], $options);

        return self::genericForm($action, $id, $options);
    }

    /**
     * Devuelve un botón para eliminar.
     */
    public static function delete($action, $id,  $options = [])
    {
        $options = array_merge([
            'class' => 'm-1 btn btn-sm btn-danger delete',
            'text' => 'Eliminar',
            'valueId' => 'form-delete',
            'icon' => 'fa fa-trash',
            'confirm' => '¿Estás seguro de eliminar?',
            'alert' => true,
        ], $options);

        return self::genericForm($action, $id, $options);
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


}
