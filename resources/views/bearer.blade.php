@extends('layouts.app')

@section('content')
    <div class="container-fluid disp_none" id="call_container">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="../../css/pageStyle.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <div class="container-fluid py-4">
            <div class="row align-items-md-stretch pb-4">

                <div class="col-md-3">
                    <div class="h-100 p-4 text-white bg-secondary rounded-3 d-flex flex-column">
                        <h2>Richiesta API</h2>
                        <div class="container">
                            <div class="form-group">
                                <label for="token">Token</label>
                                <input type="text" class="form-control" id="token"
                                    placeholder="Inserisci il tuo Bearer Token">
                            </div>

                            <div class="form-group pb-3">
                                <label for="url">URL della chiamata API</label>
                                <input type="text" id="url" class="form-control"
                                    placeholder="Inserisci la URL della chiamata">
                            </div>

                            <button class="btn btn-primary w-100" id="sendButton" onclick="fetchUserProfile()">Invia
                                richiesta</button>
                            <div id="result" class="result mt-3" style="display:none;"></div>
                        </div>
                        <div class="container">
                            <div class="mt-4 w-100">
                                <button class="btn btn-danger w-100" onclick="UserLogout()">Logout</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="p-4 mb-4 bg-light rounded-3">
                        <div class="container-fluid" id="apiResult">
                            <table class="table table-striped" id="breweries-table" style="width:100%">
                                <thead id="api_table-column"></thead>
                                <tbody id="api_table-rows"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <script src="{{ asset('../../js/apicall.js')}}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                GetValidateToken();
            });
        </script>
    </div>
@endsection
