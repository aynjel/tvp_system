<?php

require('../autoload.php');

$admin = new Admin();

if($admin->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    $validate = new Validate();
    $validation = $validate->check($_POST, [
        'username' => [
            'display' => 'Username',
            'required' => true,
            'min' => 2,
            'max' => 50
        ],
        'password' => [
            'display' => 'Password',
            'required' => true,
            'min' => 5
        ]
    ]);

    if($validation->passed()){
        try{
            $login = $admin->login(Input::get('username'), Input::get('password'));

            if($login){
                Redirect::to('index.php');
            }else{
                Session::flash('error', 'Login failed');
            }
        }catch(Exception $e){
            Session::flash('error', $e->getMessage());
        }
    }else{
        Session::flash('error', $validation->errors()[0]);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Login | <?= Config::get('website/title'); ?>
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"
        integrity="sha512-SbiR/eusphKoMVVXysTKG/7VseWii+Y3FdHrt0EpKgpToZeemhqHeZeLWLhJutz/2ut2Vw1uQEj2MbRF+TVBUA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: #007bff;
            background: linear-gradient(to right, #0062E6, #33AEFF);
        }

        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
        }

        .btn-google {
            color: white !important;
            background-color: #ea4335;
        }

        .btn-facebook {
            color: white !important;
            background-color: #3b5998;
        }
    </style>
</head>
<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">

                        <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In as Administrator</h5>

                        <?= Session::display_session_msg(); ?>

                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" value="<?= Input::get('username'); ?>"
                                    placeholder="name@example.com" name="username">
                                <label for="floatingInput">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                                    name="password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                                    in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"
        integrity="sha512-i9cEfJwUwViEPFKdC1enz4ZRGBj8YQo6QByFTF92YXHi7waCqyexvRD75S5NVTsSiTv7rKWqG9Y5eFxmRsOn0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>