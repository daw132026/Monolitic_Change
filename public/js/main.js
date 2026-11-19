// contador de letras del título en el formulario de crear / editar petición
let titulo = document.getElementById("titulo");
let contador = document.getElementById("titulo-count");
if (titulo && contador) {
  contador.textContent = titulo.value.length;
  titulo.addEventListener("input", function () {
    contador.textContent = titulo.value.length;
  });
}

// mostrar el nombre de la imagen elegida en la zona de subida
let imagen = document.getElementById("file");
let nombreImagen = document.getElementById("file-name");
if (imagen && nombreImagen) {
  imagen.addEventListener("change", function () {
    nombreImagen.textContent = imagen.files.length ? imagen.files[0].name : "";
  });
}
