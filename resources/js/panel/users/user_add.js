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
 * Avanza un paso en el formulario para crear usuarios.
 */
function nextStep() {
    // Tiene clase "active" el elemento marcado, pillar el hermano y hacer click
    var box = $('#user-form-create-tabs');
    var tabActive = box.find('.active');
    var sibling = tabActive.closest('li').next().find('.nav-link').first();

    // Elimino el anterior activo solo cuando existe próximo.
    if (sibling.attr('href')) {
        tabActive.removeClass('active');
        $(tabActive.attr('href')).removeClass(['active', 'show']);

        sibling.addClass('active');
        $(sibling.attr('href')).addClass(['active', 'show']);
    }
}

/**
 * Lleva un paso atrás en el formulario para crear usuarios.
 */
function backStep() {

}

$('document').ready(() => {
    $('#red_social_add').click(red_social_add);
    $('.user_social_box_delete').click(red_social_delete);

    // Moverse por el formulario.
    $('#user-add-step-left').click(backStep);
    $('#user-add-step-right').click(nextStep);
});
