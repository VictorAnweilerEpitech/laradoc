
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('head')
</head>
<body>
    <div id="app">
        {{-- <footer class="footer" style="background-color: #34495e !important;">Documentation | © {{\Carbon\Carbon::now()->year}}</footer> --}}
        <div class="container">
            <nav class="py-3 mb-2 border-bottom d-flex justify-content-between align-items-center">
                <span class="logo mb-0 d-flex align-items-center">
                    <a href="{{route('laradoc.client.home')}}" style="text-decoration: none" class="d-flex align-items-center text-dark h5 mb-0">
                        <img style="margin-right: 15px;" src="{{config('laradoc.logo')}}" height="30" />
                        <span class="font-weight-bold">{{config('laradoc.name') ?? 'LaraDoc'}}</span>
                        <small class="font-weight-light text-secondary mt-1 ml-2">Doc</small>
                    </a>
                </span>
                <div class="col-4">
                    <search-bar
                    :lara-config="{{json_encode(config('laradoc'))}}"
                    />
                </div>
                <ul class="d-flex align-items-center pl-0 mb-0" style="list-style-type: none">
                    @php
                        $user = Auth::guard(config('laradoc.auth.guard'))->user();
                        $columnName = config('laradoc.auth.loginColumn');
                        $permission = \Victoranw\Laradoc\Models\DocumentationPermission::where('user_id', Auth::guard(config('laradoc.auth.guard'))->user()->id)->first();
                    @endphp
                    <li class="ml-4"><a class="text-dark" href="{{route('laradoc.client.home')}}">
                        <i class="fas fa-home"></i>
                    </a></li>
                    @if ($permission->admin)
                        <li class="ml-4"><a class="text-dark" href="{{config('laradoc.url_prefix').'/admin/structure'}}">
                            <i class="fas fa-pen"></i>
                        </a></li>
                    @endif
                    <li class="ml-4"><a class="text-dark" href="{{route('laradoc.back.auth.logout')}}"><i class="fas fa-sign-out-alt"></i></a></li>
                </ul>
            </nav>
            @yield('content')
        </div>
    </div>

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
