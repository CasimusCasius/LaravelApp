<html>
    <head>
        <title>
            @yield('title', $applicationName)
        </title>
        <style>
            td {
                padding-right: 25px;
            }
        </style>
    </head>
    <body>

        <h1>{{ $applicationName }}</h1>

        <div class="sidebar">
            @section('sidebar')
                RODZIC
                <ul>
                    <li><a href="#">...</a></li>
                </ul>
            @show
        </div>

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
