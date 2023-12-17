@extends('layouts.mainlayouts')

@section('tittle', 'login')


@section('content')
<main class="1-main">
    <div class="container-fluid login vh-100 ">   
        <div class="row">
            <div class="col-6  d-flex align-items-center">   
                    <div class="login-content">
                        <div class="login-tittle text-start mb-5">
                            <h2>Welcome Back</h2>
                            <h4>Enter your credentials to accest your acount</h4>
                            @if(Session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}  
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            @if (Session::has('status'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('message') }}
                            </div>          
                            @endif

                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                @csrf
                                <div class="mb-4">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" required value="{{ old('name') }}">
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                                <button type="submit" class="btn submit-login">Login</button>
                            </form>
                            <h6 class="mt-2">Jika Belum memiliki Akun bisa <a href="/register">register</a></h6>
                        </div>   
                    </div>
            </div>
            <div class="col-6 vh-100 p-0">
                <img src="{{ asset('img/login-hero.png') }}" alt="loginhero">
            </div>
        </div>
        
    </div>
</main>
@endsection