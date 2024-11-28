@extends('layouts.app')

@section('content')
<div class="container vh-100 d-flex justify-content-center align-items-center">

    <link rel="stylesheet" href="{{ asset('../../css/pageStyle.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-image: url({{ asset('../images/custom-api-development-services-banner.jpg')}});
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100vh;
        }

        .container {
            position: relative;
            z-index: 1;
        }

        .alert-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-top: 20px;
        }
    </style>

    <div class="row justify-content-center w-100">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <form id="login-form">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" class="form-control" placeholder="Enter username" required>
                        </div>

                        <div class="form-group pb-3">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Enter password" required>
                        </div>

                        <button type="button" id="login-button" class="btn btn-primary">Login</button>
                    </form>
                    <div id="login-error" class="btn btm-primary text-danger mt-2" style="display: none;">
                        Invalid credentials. Please try again.
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 alert-container">
            <div class="alert alert-success" role="alert">
               <span class="btn" onclick="insertCredential()">root - password <i class="fa-solid fa-arrow-pointer"></i></span>

            </div>
        </div>
    </div>

</div>
<script src="{{ asset('../../js/apilogin.js')}}"></script>

@endsection
