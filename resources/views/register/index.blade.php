@extends('layouts.mainlayouts')

@section('tittle', 'Regist')


@section('content')
<main class="1-main">
    <div class="container-fluid login">
        <div class="row">
            <div class="col-6  align-items-center">   
                    <div class="login-content">
                        <div class="login-tittle text-start mb-5">
                            <h2>Get Started Now</h2>
                            <h4>Enter your credentials to accest your acount</h4>
                        </div>
                        <div class="login-form">
                            <form action="/register" method="post">
                                @csrf
                                <div class="mb-4">
                                    <label for="InputNama" class="form-label">Your name</label>
                                    <input type="name" class="form-control" id="InputNama" name="name" @error('name') is-invalid 
                                    @enderror value="{{ old('name') }}" required>
 
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" 
                                    @error('email') is-invalid @enderror  value="{{ old('email') }}" required>

                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="exampleInputPhone" class="form-label">Phone Number</label>
                                    <input type="phone" class="form-control" id="exampleInputPhone" aria-describedby="PhoneHelp" name="phone" 
                                    @error('phone') is-invalid @enderror  value="{{ old('phone') }}" required>

                                    @error('phone')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                   <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" 
                                    @error('password') is-invalid @enderror  value="{{ old('password') }}" required>
                                    
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
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