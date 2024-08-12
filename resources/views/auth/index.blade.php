@extends('layouts.main')
@section('title', 'Login')
@section('content')
    @if ($errors->any())
        <div class="container my-5">
            @foreach ($errors->all() as $error)
                <div class="container">
                    <div class="alert alert-danger container px-5 rounded shadow text-center w-50 mx-auto"
                        style="cursor: pointer" role="alert">
                        {{ $error }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="container my-5 p-5 bg-light rounded shadow text-center w-50 mx-auto">
        <form id="loginForm" action="{{ route('auth.validate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email address</label>
                <input class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email"
                    name="email" autofill="off">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password"
                    autofill="off">
            </div>
            <button type="submit" id="btnSubmit" class="btn btn-primary">Login</button>
        </form>
    </div>
@endsection
@push('script')
    <script>
        $('.alert').on('click', function() {
            $(this).remove();
        });
    </script>
@endpush

{{-- @section('script')
    <script>
        $('#btnSubmit').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                type: $('#loginForm').attr('method'),
                url: $('#loginForm').attr('action'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest'
                },
                data: $('#loginForm').serialize(),
                success: function(data) {
                    console.log(data);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseJSON);
                }
            });
        });
    </script>
@endsection --}}
