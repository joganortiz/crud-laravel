@include('layouts.header')

<div class="row">
   <div class=" col-6 text-center mt-5">
      <h1>Inciar Sesión</h1>
      <form class="row g-3 formLogin" id="formLogin" name="formLogin" novalidate>
         @csrf
         <div class="col-md-12">
            <label for="validationCustomUsername" class="form-label">Correo</label>
            <div class="input-group has-validation">
               <span class="input-group-text" id="inputGroupPrepend">@</span>
               <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo electrónico" aria-describedby=" inputGroupPrepend" required>
               <div class="invalid-feedback">
                  Ingrese Correo electrónico
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <label for="validationCustomUsername" class="form-label">Contraseña</label>
            <div class="input-group has-validation">
               <span class="input-group-text" id="inputGroupPrepend">@</span>
               <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" aria-describedby="inputGroupPrepend" required>
               <div class="invalid-feedback">
                  Ingrese la contraseña
               </div>
            </div>
         </div>
         <div class="col-12">
            <button class="btn btn-primary" type="submit">Iniciar Sesión</button>
         </div>
      </form>
   </div>
   <div class=" col-6 text-center mt-5">
      <h1>Registrarme</h1>
      <form class="row g-3 formRegistro" id="formRegistro" name="formRegistro" novalidate>
         @csrf
         <div class="col-md-12">
            <label for="validationCustomUsername" class="form-label">Nombre:</label>
            <div class="input-group has-validation">
               <span class="input-group-text" id="inputGroupPrepend">@</span>
               <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su Nombre" aria-describedby="inputGroupPrepend" required>
               <div class="invalid-feedback">
                  Ingrese Nombre
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <label for="correo" class="form-label">Correo</label>
            <div class="input-group has-validation">
               <span class="input-group-text" id="inputGroupPrepend">@</span>
               <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese un correo electrónico" aria-describedby="inputGroupPrepend" required>
               <div class="invalid-feedback">
                  Ingrese Correo electrónico
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group has-validation">
               <span class="input-group-text" id="inputGroupPrepend">@</span>
               <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese una contraseña" aria-describedby="inputGroupPrepend" required>
               <div class="invalid-feedback">
                  Ingrese contraseña
               </div>
            </div>
         </div>
         <div class="col-12">
            <button class="btn btn-primary" type="submit">Registrarme</button>
         </div>
      </form>
   </div>
</div>

@include('layouts.footer')
<script src="{{ asset('js/login_proceso.js') }}"></script>