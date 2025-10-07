
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro - Simposio</title>
    

     <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS Custom -->
    <link rel="stylesheet" href="{{ asset('css/styles') }}">

</head>

<body>


    <!-- INICIO MENU -->
    @include('partes.menu')
    <!-- FIN MENU -->   


    <!-- INICIO CONTENIDO -->
    <main>

        <div class="container-fluid bg-secondary text-white">
            <div class="container py-3">
                <div class="d-flex justify-content-between align-content-center">
                    <h1 class="display-6">@yield('titulo', 'Título')</h1>
                    <span>
                        @yield('btn')
                    </span>
                </div>
            </div>
        </div>

        <div class="container py-4">

            @yield('contenido')

        </div>

    </main>
    <!-- FIN CONTENIDO -->


    <!-- INICIO FOOTER -->
     <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; 2025 Simposio Tecnológico. Todos los derechos reservados.</p>
        </div>
    </footer>
    <!-- FIN FOOTER -->


    <!-- JS -->

       <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- JS Custom -->
    <script src="{{ asset('js/script.js') }}"></script>

    <script>

    $(document).ready(function(){
        $('.datatable').DataTable();
    });

    </script>
    @stack('scripts')
</body>
</html>