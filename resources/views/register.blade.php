@extends('layouts/main')
@section('css')
    <link rel="stylesheet" href="css/registration.css">
@endsection
@section('contents')

    <section class="registration-section">
        <div class="container">
            <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="registration-card">
                        <div class="registration-header text-center mb-4">
                            <h1 class="registration-title">Join Us</h1>
                            <p class="registration-subtitle">Create your account to start blooming</p>
                        </div>
                        
                      <form method="POST" action="/signup">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="fullname" id="fullName" placeholder="Enter your full name" required>
                                <div class="invalid-feedback">
                                    Please enter your name.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Create a password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" id="confirmPassword" placeholder="Confirm password" required>
                                    <div class="invalid-feedback">
                                        Please confirm your password.
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-register-primary w-100 mb-3">Create Account</button>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="login-text">Already have an account? <a href="/login" class="login-link">Log In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection