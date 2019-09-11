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

$('document').ready(() => {
    $('#red_social_add').click(red_social_add);
    $('.user_social_box_delete').click(red_social_delete);
});
