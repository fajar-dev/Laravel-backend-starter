

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reset Password</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    </head>
    
    <body class="d-flex align-items-center py-4 bg-body-tertiary">
        
        <main class="form-signin w-100 m-auto">
            <div class="container">
                <div class="row justify-content-center d-flex h-100">
                    <div class="col-12 col-lg-4">
                        <form action="{{ route('reset.password.post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
                            <h1 class="h3 mb-3 fw-normal">Reset Passowrd</h1>
                            <div class="form-floating">
                                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" >
                                <label for="floatingInput">Email address</label>
                            </div>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                    
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" >
                                <label for="floatingPassword">Password</label>
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                    
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" name="password_confirmation" placeholder="Repeat Password" >
                                <label for="floatingPassword">Password</label>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                            
                            <button class="btn btn-primary w-100 py-2 mt-5" type="submit" >Reset</button>
                            <p class="mt-5 mb-3 text-body-secondary">© 2017–2023</p>
                        </form>
                    </div>
                </div>
            </div>
        </main>    
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
</html>
