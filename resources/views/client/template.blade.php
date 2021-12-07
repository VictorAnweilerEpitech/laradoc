
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{config('laradoc.name') ?? 'LaraDoc'}} Doc | {{$pageTitle ?? ""}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{config('laradoc.logo')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://tympanus.net/Freebies/scribbler/scribbler-global.css">
    <link rel="stylesheet" href="https://tympanus.net/Freebies/scribbler/scribbler-doc.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('head')
</head>
<body>
    <div id="app">
        <div class="doc__bg"></div>
        <nav class="header">
            <h1 class="logo mb-0 d-flex align-items-center">
                <a href="{{route('laradoc.client.home')}}" class="d-flex align-items-center text-dark">
                    <img style="margin-right: 15px;" src="{{config('laradoc.logo')}}" height="30" />
                    {{config('laradoc.name') ?? 'LaraDoc'}} <span class="logo__thin ml-2">Doc</span>
                </a>
            </h1>
            <ul class="menu">
                @php
                    $user = Auth::guard(config('laradoc.auth.guard'))->user();
                    $columnName = config('laradoc.auth.loginColumn');
                    $permission = \Victoranw\Laradoc\Models\DocumentationPermission::where('user_id', Auth::guard(config('laradoc.auth.guard'))->user()->id)->first();
                @endphp
                <div class="menu__item toggle"><span></span></div>
                <li class="menu__item"><a href="{{route('laradoc.client.home')}}" class="link link--dark"><i class="fa fa-home"></i> Accueil</a></li>
                @if ($permission->admin)
                    <li class="menu__item"><a href="{{config('laradoc.url_prefix').'/admin/structure'}}" class="link link--dark"><i class="fas fa-tools" style="margin-right: 5px;"></i>Admin</a></li>
                @endif
                <li class="menu__item"><i class="fas fa-user" style="margin-right: 5px;"></i>{{$user->$columnName}}</li>
                <li class="menu__item"><a href="{{route('laradoc.back.auth.logout')}}" class="link link--dark"><i class="fas fa-sign-out-alt"></i></a></li>
            </ul>
        </nav>
        <div class="mt-4">
            <div class="wrapper" style="min-height: 82vh;">
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="footer" style="background-color: #34495e !important;">Documentation | © {{\Carbon\Carbon::now()->year}}</footer>

    <script src="{{route('laradoc.assets.js', 'client/template.js')}}"></script>

    @yield('scripts')

    <style>
        .bg-my-primary {
            background-color: {{config('laradoc.color')}} !important;
        }

        .text-my-primary {
            color: {{config('laradoc.color')}} !important;
        }

        .border-my-primary {
            border: 1px solid {{config('laradoc.color')}} !important;
        }
    </style>
</body>
</html>
