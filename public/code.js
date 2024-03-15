function mostrarContenido(opcion) {
    // Obtener todos los elementos con clase "contenido"
    let contenidos = document.querySelectorAll('.contenido');
    // Ocultar todos los contenidos
    contenidos.forEach(contenido => {
        contenido.classList.remove('mostrar');
    });
    // Mostrar solo el contenido seleccionado
    let contenidoMostrar = document.getElementById(opcion);
    contenidoMostrar.classList.add('mostrar');
}
