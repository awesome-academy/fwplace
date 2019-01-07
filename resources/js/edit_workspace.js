$(document).ready(function() {
    $('#add-workspace').click(function() {
        document.querySelector('#image-display').setAttribute('src', '');
        document.querySelector('#workspace-name').value = '';
        document.querySelector('#workspace-id').value = '';
    });
});
