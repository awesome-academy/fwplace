function showModal(id, name, image) {
    document.querySelector('#image-display').setAttribute('src', image);
    document.querySelector('#workspace-name').value = name;
    document.querySelector('#workspace-id').value = id;
}
