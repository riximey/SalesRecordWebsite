@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="css/login.css">
@endsection
@section('contents')

<div class="background-overlay"></div>
    <section class="login-section">
        <div class="container">
            <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
                <div class="col-lg-5 col-md-7 col-sm-9">
                    <div class="login-card">
                        <div class="login-header text-center mb-4">
                            <h1 class="login-title">Welcome Back</h1>
                            <p class="login-subtitle">Login to your account</p>
                        </div>
                        
                     <form method="POST" action="/loggingIn">
                        @csrf
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Username / Email</label>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Enter your username or email" required>
                            </div>

                            <div class="form-group mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                            </div>

                           <button type="submit" class="btn btn-login-primary w-100 mb-3">Login</button>

                            <div class="text-center">
                                <a href="#" class="forgot-link">Forgot Password?</a>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="signup-text">Don't have an account? <a href="/register" class="signup-link">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
