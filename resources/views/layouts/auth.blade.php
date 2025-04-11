<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Patient Directory')</title>
        
        <!-- Bootstrap CSS 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        jQuery UI CSS 
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="pt-5 pb-5">

        <!-- Bootstrap Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container justify-content-center">
                <a class="navbar-brand mx-auto" href="{{ route('dashboard') }}">Patient Directory</a>
            </div>
        </nav>        

        <!-- Main Content -->
        <div class="container mt-4">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="bg-dark text-white text-center py-3 fixed-bottom">
            <p>&copy; {{ date('Y') }} EMR System. All rights reserved.</p>
        </footer>

        @yield('scripts')

        <!-- Bootstrap JS 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
         Jquery JS 
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>-->
    </body>
</html>
