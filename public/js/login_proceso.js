(function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.formLogin')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()

                } else {
                    IniciarSesion()
                }

                form.classList.add('was-validated')
            }, false)
        })

    function IniciarSesion() {
        event.preventDefault()
        var formData = new FormData(document.getElementById("formLogin"));
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = url + '/login';
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status == 200) {
                    window.location = 'cliente/listar'
                } else {
                    swal({
                        title: objData.titulo,
                        html: objData.mensaje,
                        type: "warning",
                        confirmButtonText: 'Ok!'
                    })
                }
            }
        }
    }



    //Registarse the
    var forms = document.querySelectorAll('.formRegistro')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()

                } else {
                    RegistarUsuario()
                }

                form.classList.add('was-validated')
            }, false)
        })

    function RegistarUsuario() {
        event.preventDefault()
        var formData = new FormData(document.getElementById("formRegistro"));
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = url + '/crearUsuario';
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status == 200) {
                    swal({
                        title: objData.titulo,
                        html: objData.mensaje,
                        type: "success",
                        confirmButtonText: 'Ok!'
                    })
                    document.getElementById("formRegistro").reset()
                } else {
                    swal({
                        title: objData.titulo,
                        html: objData.mensaje,
                        type: "warning",
                        confirmButtonText: 'Ok!'
                    })
                }
            }
        }

    }



})()