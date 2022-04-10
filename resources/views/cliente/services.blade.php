@include('layouts.header')
<div class="row">
   <div class="col-12 text-center">

      <h5><span style="font-size:15px">Cliente: </span> <small class="nombre_cliente"></small></h5>
   </div>
   <div class="col-lg-4 mb-4">
      <h5 class=""><small>Formulario de Servicios</small></h5>
      <form name="procesoServicio" id="procesoServicio">
         @csrf
         <input type="hidden" name="id_cliente" id="id_cliente" value="{{ $id }}">
         <input type="hidden" name="id_servicio" id="id_servicio" value="">
         <div class="row">
            <div class="col-12">
               <div class="row g-3">
                  <div class="col-md-12">
                     <label for="nombre" class="form-label">Nombre:</label>
                     <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del servicio">
                  </div>
                  <div class="col-12">
                     <label for="telefono" class="form-label">Imagen</label><br>
                     <input type="file" name="imagenSer" id="imagenSer" accept="image/*">
                  </div>

                  <div class="col-6">
                     <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                     <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                  </div>
                  <div class="col-6">
                     <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                     <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                  </div>
                  <div class="col-12">
                     <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                     <select class="form-select" name="tipo_servicio" id="tipo_servicio">
                        <option>**Seleccione**</option>
                        <option value="0">Básico</option>
                        <option value="1">Avanzado</option>
                     </select>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                     <label for=" " class="form-label col-lg-12 col-sm-12">Observación:</label>
                     <textarea name="observacion" id="observacion" cols="40" rows="3" placeholder="Ingrese una observación"></textarea>
                  </div>

                  <div class="col-lg-6 col-sm-6">
                     <button class="btn btn-primary btn-CrearEditar btn-sm">Guardar</button>
                  </div>
                  <div class="col-lg-6 col-sm-6 text-end">
                     <input type="button" class="btn btn-secondary btn-VaciasCampos btn-sm" value="Vacias Campos">
                  </div>

               </div>
            </div>
         </div>
      </form>
   </div>
   <div class="col-lg-8">
      <div class="card mb-4">
         <div class="card-header ">
            <div class="row">
               <div class="col-lg-6 ">
                  <h5 class=""><small>Listado de Servicios Por Cliente</small></h5>
               </div>
            </div>
         </div>
         <div class="card-body">
            <table id="tablaServicios" class="table table-bordered" style="width: 100%;">
               <thead>
                  <tr class="text-center">
                     <th class="all">Nombre</th>
                     <th class="">Imagen</th>
                     <th class="">Tipo servicio</th>
                     <th>Fecha inicio</th>
                     <th>Fecha fin</th>
                     <th class="all" style="width: 100px;">Acciones</th>
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
      ProcesosServicios.initServicio()

      $(".btn-VaciasCampos").click(function() {
         document.getElementById("procesoServicio").reset()
         $("input[name=id_servicio]").val('');
      });
   });
</script>