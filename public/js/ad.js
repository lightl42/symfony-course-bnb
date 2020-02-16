$('#add-image').click(function() {
    // Recupere le numero des futurs champs que je vais creer
    const index = +$('#widgets-counter').val();
    // Recupere le prototype des entrees
    const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);
    // Injecte le code au sein de la <div>
    $('#ad_images').append(tmpl);
    $('#widgets-counter').val(index + 1);
    // Gerer le bouton supprimer
    handleDeleteButtons();
});
function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function() {
        const target = this.dataset.target;
        $(target).remove();
    });
}
function updateCounter() {
    const count = +$('#ad_images div.form-group').length;
    $('#widgets-counter').val(count);
}
updateCounter();
handleDeleteButtons();