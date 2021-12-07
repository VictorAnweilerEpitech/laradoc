
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{config('laradoc.name') ?? 'LaraDoc'}} Doc | {{$pageTitle ?? ""}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{config('laradoc.logo')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />

    @yield('head')
</head>
<body>
<div class="d-flex align-items-center flex-column justify-content-center h-100">
    <h1 class="display-4 animate__animated animate__bounceIn">
        <div class="d-flex align-items-center">
            <img style="margin-right: 15px;" src="{{config('laradoc.logo')}}" height="75" />
            <div>
                {{config('laradoc.name')}}.
                <h6 class="font-weight-light text-secondary mb-0">
                    Espace Documentation
                </h6>
            </div>
        </div>
    </h1>
    <form action="{{route('laradoc.back.auth.connect')}}" method="POST" class="mt-4 w-25 text-center animate__animated animate__bounceIn">
        @csrf
        <input type="text" class="form-control p-2 w-100 mb-2 text-center" name="login" placeholder="Identifiant" />
        <input type="password" class="form-control p-2 w-100 mb-2 text-center" name="password" placeholder="Mot de passe" />
        <button class="btn btn-primary mt-3 bg-default-color border-0" type="submit" style="font-weight: 300;">
            Se connecter
            <i class="fas fa-arrow-right" style="margin-left: 5px"></i>
        </button>
    </form>
</div>
<style>
body,html {
    height: 100%;
}

input,
textarea
{
    border: 1px solid #dfe4ea !important;
    font-weight: 400;
}
textarea:hover, 
input:hover, 
textarea:active, 
input:active, 
textarea:focus, 
input:focus,
button:focus,
button:active,
button:hover,
label:focus,
.btn:active,
.btn.active
{
    outline:0px !important;
    box-shadow: none !important;
    border: 1px solid #ced6e0 !important;
}

.bg-default-color {
    background-color: {{config('laradoc.color')}} !important;
}
</style>
</body>
</html>
