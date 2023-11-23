@extends('layouts.mainlayouts')

@section('tittle', 'Regist')


@section('content')
<main class="1-main">
    <div class="container-fluid login">
        <div class="row">
            <div class="col-6">   
                    <div class="login-content">
                        <div class="login-tittle text-start mb-5">
                            <h2>Get Started Now</h2>
                            <h4>Enter your credentials to accest your acount</h4>
                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                <div class="mb-4">
                                    <label for="InputNama" class="form-label">Your name</label>
                                    <input type="name" class="form-control" id="InputNama" aria-describedby="NamaHelp" placeholder="Masukkan namamu!">
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1">
                                </div>
                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                                <button type="submit" class="btn submit-login">Submit</button>
                            </form>
                        </div>   
                    </div>
            </div>
            <div class="col-6">
                <img src="{{ asset('img/login-hero.png') }}" alt="loginhero">
            </div>
        </div>
        
    </div>
</main>
@endsection
    
</body>
</html>