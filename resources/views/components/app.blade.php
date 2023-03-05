<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="{{ asset('/style.css') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

</head>

<body>

    <header>
        <div class="container">
            <div class="row">
                <div class="col-4">
                    
                    <h2 class="py-2"><a class="nav-link" href="/"> NOVAL</a></h2>

                </div>
                <div class="col-8">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/regional">Regional</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/provincial">Provincial</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Division BDD
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <li><a class="dropdown-item" href="/division-bdd-buk">Bukidnun</a></li>
                                            <li><a class="dropdown-item" href="/division-bdd-ldn">LDN</a></li>
                                            <li><a class="dropdown-item" href="/division-bdd-misor">MisOr</a></li>
                                            <li><a class="dropdown-item" href="/division-bdd-misoc">MisOc</a></li>
                                            <li><a class="dropdown-item" href="/division-bdd-cam">Cam</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Division CPD
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <li><a class="dropdown-item" href="/division-cpd-buk">Bukidnun</a></li>
                                            <li><a class="dropdown-item" href="/division-cpd-ldn">LDN</a></li>
                                            <li><a class="dropdown-item" href="/division-cpd-misor">MisOr</a></li>
                                            <li><a class="dropdown-item" href="/division-cpd-misoc">MisOc</a></li>
                                            <li><a class="dropdown-item" href="/division-cpd-cam">Cam</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Division FAD
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            <li><a class="dropdown-item" href="/division-fad-buk">Bukidnun</a></li>
                                            <li><a class="dropdown-item" href="/division-fad-ldn">LDN</a></li>
                                            <li><a class="dropdown-item" href="/division-fad-misor">MisOr</a></li>
                                            <li><a class="dropdown-item" href="/division-fad-misoc">MisOc</a></li>
                                            <li><a class="dropdown-item" href="/division-fad-cam">Cam</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    {{ $slot }}

    <script>
        function printTable() {
            var printButton = document.getElementById("print-button");

            printButton.addEventListener("click", function() {

                var table = document.getElementById("table").outerHTML;
                // console.log(table)
                var win = window.open('', '_blank');
                win.document.write('<html><head><title>Print Table</title>');
                win.document.write(
                    '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css" />'
                );
                win.document.write('</head><body>');
                win.document.write(table);
                win.document.write('</body></html>');
                win.document.close();
                win.print();
            });
        }
    </script>

</body>

</html>
