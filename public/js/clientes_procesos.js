var ProcesosClientes = {
    initCliente: function() {
        this.ListarClientes()
    },

    ListarClientes: function() {
        var self = this
        var table = $('#tablaListarClientes').DataTable({
            "autoWidth": !1,
            "responsive": !0,
            order: [],
            "ajax": {
                "url": "/listarClientes",
                "dataSrc": ""
            },
            "columns": [
                { "data": "nombre" },
                { "data": "imagen" },
                { "data": "cedula" },
                { "data": "correo" },
                { "data": "telefono" },
                { "data": "options" }
            ],
            "initComplete": function() {
                self.CrearEditarCliente(table)
            },
            pageLength: 10,
            columnDefs: [{
                orderable: !1,
                targets: [1, 5]
            }]
        });
        table.on('draw', function() {
            $(".EliminarCliente").on("click", function() {
                var id = $(this).attr('data-control');
                self.EliminarCliente(table, id);
            });

            $(".editarCliente").on("click", function() {
                var id = $(this).attr('data-control');
                self.ListarCliente(id, 1);
                $("#CrearEditarCliente").modal('show');
                $(".modal-title").html("Editar Cliente");
                $(".modal-header").css({
                    "background": "#ffc107",
                    "color": "#000"
                });
                $(".btn-accion").html("Actualizar").addClass("btn-warning").removeClass("btn-success");
            });

            $(".DetalleCliente").on("click", function() {
                var id = $(this).attr('data-control');
                $("#Detalle_Cliente").modal('show');
                self.ListarCliente(id, 0);
                self.ListarServiciosCliente()
            });

        })
    },

    EliminarCliente: function(table, id = '') {
        let self = this
        if (id != '') {
            swal({
                html: "<b>¿Realmente quiere eliminar al cliente?</b>",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "red",
                confirmButtonText: "Si, eliminar!",
                cancelButtonText: "No, cancelar!",
                closeOnConfirm: !1,
                closeOnCancel: !1,
            }).then(function(result) {
                if (result.value) {
                    var formData = new FormData()
                    formData.append("id_cliente", id);
                    formData.append("_token", $("input[name=_token]").val())

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = "/eliminarCliente"
                        // let strData = "id_cliente=" + id;
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
                    request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                            let objData = JSON.parse(request.responseText);
                            if (objData.status == 200) {
                                table.ajax.reload(function() {
                                    self.EliminarCliente(table);
                                });

                                swal({
                                    title: objData.titulo,
                                    html: objData.mensaje,
                                    type: "success",
                                    confirmButtonText: 'Ok!'
                                })
                            }
                        } else {
                            swal({
                                title: "Error!",
                                html: "Se presento un problema al momento de eliminar al cliente, intenta más tarde",
                                type: "error",
                                confirmButtonText: 'Ok!'
                            })
                        }
                    }
                }
            });
        }
    },

    ListarServiciosCliente: function() {
        self = this
            //if (id_cliente != '') {

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = "/listarServiciosCliente"
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status == 200) {
                        $(".bodyTabled").html(objData.html);


                    }
                }
            }
            // }
    },

    ListarCliente: function(id = '', tipo, tablaeService) {
        self = this
        if (id != '') {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = "/listarCliente/" + id
                // let strData = "id_cliente=" + id;
            request.open("GET", ajaxUrl, true);
            request.send();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status == 200) {
                        if (tipo) {
                            $("#id_cliente").val(objData.data.id);
                            $("#nombre").val(objData.data.nombre);
                            $("#cedula").val(objData.data.cedula);
                            $("#telefono").val(objData.data.telefono);
                            $("#correo").val(objData.data.correo);
                            $("#observacion").val(objData.data.observaciones);
                        } else {
                            $("#nombreDetal").html(objData.data.nombre);
                            $("#cedulaDetal").html(objData.data.cedula);
                            $("#telefonoDetal").html(objData.data.telefono);
                            $("#correoDetal").html(objData.data.correo);
                            $("#observacionDetal").html(objData.data.observaciones);
                            document.querySelector('#imagenDetail').src = objData.data.url_imagen;
                        }
                    }
                }
            }
        }
    },

    CrearEditarCliente: function(table) {
        var self = this
        $("form[name=procesoCliente]").submit(function(e) {
            e.preventDefault();
            self = this
            var formData = new FormData(document.getElementById("procesoCliente"));

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = '/crearCliente';
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status == 200) {
                        table.ajax.reload(function() {
                            self.EliminarCliente(table);
                        });
                        swal({
                            title: objData.titulo,
                            html: objData.mensaje,
                            type: "success",
                            confirmButtonText: 'Ok!'
                        })

                        document.getElementById("procesoCliente").reset()
                        $("#CrearEditarCliente").modal('hide');
                    } else {
                        swal({
                            title: objData.titulo,
                            html: objData.mensaje,
                            type: "warning",
                            confirmButtonText: 'Ok!'
                        })
                    }
                } else {
                    swal({
                        title: "Error!",
                        html: "Se presento un problema al momento de guardar al cliente, intenta más tarde",
                        type: "error",
                        confirmButtonText: 'Ok!'
                    })
                }
            }
        });
    }

}

var ProcesosServicios = {
    initServicio: function() {
        this.ListarServicios()
        this.TraerNombreCliente()
    },

    TraerNombreCliente: function() {
        var id_cliente = $("input[name=id_cliente]").val();
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = "/listarCliente/" + id_cliente
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status == 200) {
                    $(".nombre_cliente").html(objData.data.nombre);
                }
            }
        }
    },

    ListarServicios: function() {
        var id_cliente = $("input[name=id_cliente]").val();
        var self = this
        var table = $('#tablaServicios').DataTable({
            "autoWidth": !1,
            "responsive": !0,
            order: [],
            "ajax": {
                "url": "/listarServicios/" + id_cliente,
                "dataSrc": ""
            },
            "columns": [
                { "data": "nombre" },
                { "data": "imagen" },
                { "data": "tipo_servicio" },
                { "data": "fecha_inicio" },
                { "data": "fecha_fin" },
                { "data": "options" }
            ],
            "initComplete": function() {
                self.CrearEditarServicio(table)
            },
        });
        table.on('draw', function() {
            $(".EliminarServicio").on("click", function() {
                var id = $(this).attr('data-control');
                self.EliminarServicio(table, id);
            });

            $(".editarServicio").on("click", function() {
                var id = $(this).attr('data-control');
                self.ListarServicio(id)

            });
        });

    },

    EliminarServicio: function(table, id = '') {
        self = this
        if (id != '') {
            swal({
                html: "<b>¿Realmente quiere eliminar el Servicio?</b>",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "red",
                confirmButtonText: "Si, eliminar!",
                cancelButtonText: "No, cancelar!",
                closeOnConfirm: !1,
                closeOnCancel: !1,
            }).then(function(result) {
                if (result.value) {
                    var formData = new FormData()
                    formData.append("id_servicio", id);
                    formData.append("_token", $("input[name=_token]").val())

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = "/eliminarServicio"
                        // let strData = "id_cliente=" + id;
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
                    request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                            let objData = JSON.parse(request.responseText);
                            if (objData.status == 200) {
                                table.ajax.reload(function() {
                                    self.EliminarServicio(table);
                                });

                                swal({
                                    title: objData.titulo,
                                    html: objData.mensaje,
                                    type: "success",
                                    confirmButtonText: 'Ok!'
                                })
                            }
                        } else {
                            swal({
                                title: "Error!",
                                html: "Se presento un problema al momento de eliminar al cliente, intenta más tarde",
                                type: "error",
                                confirmButtonText: 'Ok!'
                            })
                        }
                    }
                }
            });
        }
    },

    ListarServicio: function(id) {
        if (id != '') {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = "/listarServicio/" + id
                // let strData = "id_cliente=" + id;
            request.open("GET", ajaxUrl, true);
            request.send();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status == 200) {
                        $("#id_servicio").val(objData.data.id);
                        $("#nombre").val(objData.data.nombre);
                        $("#fecha_inicio").val(objData.data.fecha_inicio);
                        $("#fecha_fin").val(objData.data.fecha_fin);
                        $("#tipo_servicio").val(objData.data.tipo_servicio);
                        $("#observacion").val(objData.data.observaciones);
                    }
                }
            }
        }
    },

    CrearEditarServicio: function(table) {
        var self = this
        $("form[name=procesoServicio]").submit(function(e) {
            e.preventDefault();
            self = this
            var formData = new FormData(document.getElementById("procesoServicio"));

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = '/crearEditarServicio';
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status == 200) {
                        table.ajax.reload(function() {
                            self.EliminarServicio(table);
                        });
                        swal({
                            title: objData.titulo,
                            html: objData.mensaje,
                            type: "success",
                            confirmButtonText: 'Ok!'
                        })

                        document.getElementById("procesoServicio").reset()
                        $("input[name=id_servicio]").val('');
                    } else {
                        swal({
                            title: objData.titulo,
                            html: objData.mensaje,
                            type: "warning",
                            confirmButtonText: 'Ok!'
                        })
                    }
                } else {
                    swal({
                        title: "Error!",
                        html: "Se presento un problema al momento de guardar al cliente, intenta más tarde",
                        type: "error",
                        confirmButtonText: 'Ok!'
                    })
                }
            }
        });
    }
}