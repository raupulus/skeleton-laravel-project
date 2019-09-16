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
}

/**
 * Lleva un paso atrás en el formulario para crear usuarios.
 */
function backStep() {
    changeStep('prev');
}

$('document').ready(() => {
    $('#red_social_add').click(red_social_add);
    $('.user_social_box_delete').click(red_social_delete);

    // Moverse por el formulario.
    $('#user-add-step-left').click(backStep);
    $('#user-add-step-right').click(nextStep);
});
