<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Prueba-Laravel</title>
   <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" type="" href="{{ asset('css/styles.css') }}">

   <!-- Datatable -->
   <link rel="stylesheet" type="text/css" href="{{ asset('js/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
   <link rel="stylesheet" type="text/css" href=" {{ asset('js/datatables.net-bs4/css/responsive.dataTables.min.css') }}">

   <link rel="stylesheet" type="" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
</head>

<body>
   <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
         <a class="navbar-brand" href="#">Prueba laravel</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="{{url('/cliente/listar')}}">Listador Clientes</a>
               </li>

            </ul>
            <div class="d-flex dropdown">
               <div class=" ">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <i class="fas fa-user fa-fw"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                     <li><a class="dropdown-item" href="#">Perfil</a></li>
                     <li><a class="dropdown-item" href="#">Configuraciones</a></li>
                     <li>
                        <hr class="dropdown-divider">
                     </li>
                     <li><a class="dropdown-item salir" href="{{url('/salir')}}">Salir</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </nav>
   <div class="container-fluid px-4 mt-3">