@include('layouts.header')


<div class="row">
   <div class="col-lg-12">
      <div class="card mb-4">
         <div class="card-header ">
            <div class="row">
               <div class="col-lg-6 ">
                  <h5 class=""><small>Listado de Clientes</small></h5>
               </div>
               <div class="col-lg-6 text-end">
                  <button class="btn btn-primary btn-sm crear" type="" data-bs-toggle="modal" data-bs-target="#CrearEditarCliente"><i class="fa-solid fa-plus"></i> Crear Cliente</button>
               </div>
            </div>
         </div>
         <div class="card-body">
            <table id="tablaListarClientes" class="table table-bordered" style="width: 100%;">
               <thead>
                  <tr class="text-center">
                     <th class="all">Nombre</th>
                     <th class="">Imagen</th>
                     <th class="">Cedula</th>
                     <th>Correo</th>
                     <th>Teléfono</th>
                     <th class="all" style="width: 120px;">Acciones</th>
                  </tr>
               </thead>
               <tbody class="text-center">
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

@include('layouts.footer')

<script>
   $(document).ready(function() {
      
      ProcesosClientes.initCliente(url)
      $(".crear").click(function() {
         $(".modal-title").html("Crear Nuevo Cliente");
         $(".modal-header").css({
            "background": "#0d6efd",
            "color": "#fff"
         });
         document.getElementById("procesoCliente").reset()
         $("#id_cliente").val('')
         $(".btn-accion").html("Guardar").addClass("btn-success").removeClass("btn-warning");
      });
   });
</script>

<!-- Modal -->
<div class="modal fade" id="CrearEditarCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-xs">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form name="procesoCliente" id="procesoCliente">
            @csrf
            <div class="modal-body">
               <input type="hidden" name="id_cliente" id="id_cliente" value="">
               <div class="row">
                  <div class="col-12">
                     <div class="row g-3">
                        <div class="col-md-6">
                           <label for="nombre" class="form-label">Nombre:</label>
                           <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del cliente">
                        </div>
                        <div class="col-6">
                           <label for="cedula" class="form-label">Cedula</label>
                           <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cedula del cliente">
                        </div>
                        <div class="col-6">
                           <label for="telefono" class="form-label">Teléfono</label>
                           <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono del cliente">
                        </div>
                        <div class="col-6">
                           <label for="telefono" class="form-label">Imagen</label><br>
                           <input type="file" name="imagen" id="imagen" accept="image/*">
                        </div>

                        <div class="col-12">
                           <label for="correo" class="form-label">Correo:</label>
                           <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electrónico del cliente">
                        </div>
                        <div class="col-12">
                           <label for="observacion" class="form-label">Observación:</label>
                           <textarea name="observacion" id="observacion" cols="60" rows="5" placeholder="Ingrese una observación"></textarea>
                        </div>

                     </div>
                  </div>
               </div>
            </div>

            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
               <button class="btn btn-accion btn-sm"></button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="Detalle_Cliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header" style="background:#6c757d; color : #fff ">
            <h5 class=" modal-title" id="staticBackdropLabel">Detalla del Cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form name="procesoCliente" id="procesoCliente">
            @csrf
            <div class="modal-body">
               <div class="row">
                  <div class="col-lg-6 col-ms-12">
                     <div class="row ">
                        <div class="col-sm-6 col-lg-6">
                           <label for="nombre" class="form-label">Nombre:</label>
                           <p class="" id="nombreDetal"></p>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                           <label for="cedula" class="form-label">Cedula</label>
                           <p class="" id="cedulaDetal"></p>
                        </div>
                        <div class="col-sm-6">
                           <label for="telefono" class="form-label">Teléfono</label>
                           <p class="" id="telefonoDetal"></p>
                        </div>

                        <div class="col-6">
                           <label for="correo" class="form-label">Correo:</label>
                           <p class="" id="correoDetal"></p>
                        </div>
                        <div class="col-12">
                           <label for="observacion" class="form-label">Observación:</label>
                           <p class="" id="observacionDetal"></p>
                        </div>

                     </div>
                  </div>
                  <div class="col-lg-6 col-ms-12 text-center">
                     <img src="" alt="" srcset="" id="imagenDetail" width="250px" height="250px">
                  </div>
                  <div class="col-lg-12 col-ms-12 mt-3">
                     <table id="tablaServiciosCliente" class="table table-bordered tablaServiciosCliente" style="width: 100%;">
                        <thead>
                           <tr class="text-center">
                              <th class="all">Nombre</th>
                              <th class="">Imagen</th>
                              <th class="">Tipo servicio</th>
                              <th>Fecha inicio</th>
                              <th>Fecha fin</th>
                           </tr>
                        </thead>
                        <tbody class="text-center bodyTabled">
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
         </form>
      </div>
   </div>
</div>