// Prevengo error al detectar versión de bootstrap con selectpicker.
$.fn.selectpicker.Constructor.BootstrapVersion = bootstrap_version;

// Caja con la fila completa para agregar una red social
var clean_user_social_add = $('.user_social_box').first().clone(true);

/**
 * Añade una fila para introducir una nueva red social del usuario.
 */
function red_social_add() {
    var box = $('#user_social_content_box').prepend(clean_user_social_add.clone(true));
    box.find('.user_social_box_delete').click(red_social_delete);
    $('select').selectpicker();
}

/**
 * Elimina una fila de red social.
 */
function red_social_delete() {
    $(this).closest('.user_social_box').remove();
}

/**
 * Avanza o retrocede en el formulario de creación según la dirección recibida
 *
 * @param direction prev para retroceder y next para avanzar.
 */
function changeStep(direction) {
    // Tiene clase "active" el elemento marcado, pillar el hermano y hacer click
    var box = $('#user-form-create-tabs');
    var tabActive = box.find('.active');

    if (direction === 'next') {
        var sibling = tabActive.closest('li').next().find('.nav-link').first();
    } else if (direction === 'prev') {
        var sibling = tabActive.closest('li').prev().find('.nav-link').first();
    }

    // Elimino el anterior activo solo cuando existe próximo.
    if (sibling.attr('href')) {
        tabActive.removeClass('active');
        $(tabActive.attr('href')).removeClass(['active', 'show']);

        sibling.addClass('active');
        $(sibling.attr('href')).addClass(['active', 'show']);
    }
}

/**
 * Avanza un paso en el formulario para crear usuarios.
 */
function nextStep() {
    changeStep('next');
    progressBar();
}

/**
 * Lleva un paso atrás en el formulario para crear usuarios.
 */
function backStep() {
    changeStep('prev');
    progressBar();
}

/**
 * Recalcula y dibuja la barra de progreso para la situación actual.
 * Se lleva a cabo por la clase de navegación tomando como referencia la activa.
 */
function progressBar() {
    // TODO → Este timeout queda bien pero es por la prioridad de eventos
    setTimeout(() => {
        var progressbar = $('#box-progress-bar .progress-bar');
        var tabs = $('#user-form-create-tabs .nav-item .nav-link');
        var n_tabs = tabs.length;  // Total de pasos.
        var pos_tabs = 0;  // Paso seleccionado actualmente.
        var width = 0; // Ancho de la barra.

        // Busco elemento activo y anoto su posición.
        $.each(tabs, (idx, ele) => {
            if ($(ele).hasClass('active')) {
                pos_tabs = idx + 1;
            }
        });

        // Calculo el porcentaje que ocupa la posición actual respecto al total.
        width = (100 / n_tabs) * pos_tabs;

        progressbar.css('width', width + '%');
    }, 500);
}

$('document').ready(() => {
    $('#red_social_add').click(red_social_add);
    $('.user_social_box_delete').click(red_social_delete);

    // Moverse por el formulario.
    $('#user-add-step-left').click(backStep);
    $('#user-add-step-right').click(nextStep);

    /**
     * Recalcular barra de navegación
     * TODO → Problema en orden de ejecución eventos, progressbar tiene que
     * ser el último para darle tiempo al de bootstrap que cambie clases.
     *
     * El evento shown.bs.tab de bootstrap no llega a dispararse
     */
    progressBar();
    $('#user-form-create-tabs').find('.nav-link').click(progressBar);
    /*
    $('#user-form-create-tabs a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
        //var active = e.target; // newly activated tab
        //var activePrevius = e.relatedTarget; // previous active tab

        //console.log('entra');
        progressBar();
    });
    */
});
