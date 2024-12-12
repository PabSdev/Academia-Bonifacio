document.querySelector('form').addEventListener('submit', function (event) {
    let contrasena1 = document.getElementById('contrasena')
    let contrasena2 = document.getElementById('confirmar_contrasena')

    if (contrasena1.value !== contrasena2.value) {
        event.preventDefault()
        alert('Las contraseñas no coinciden')
    }
})
