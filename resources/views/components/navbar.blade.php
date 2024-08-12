<style>
    .nav-link:hover {
        color: #fff;
        /* or any other color you prefer */
    }
</style>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img style="width: 200px" src="https://cdn.healthtechalpha.com/static/corporatesById/895.png"
                alt="Logo Bank DKI">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="btn btn-outline-primary @yield('rekening')" href="{{ route('rekening.index') }}">
                        <strong>Rekening</strong>
                    </a>
                </li>
                {{-- <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
          </li> --}}
            </ul>
            <div>
                <span class="badge bg-primary">{{ session('role') ?? 'Guest' }}</span>
                <button id="logout" class="btn btn-outline-danger">Log Out</button>
            </div>
        </div>
    </div>
</nav>
<script>
    $('#logout').on('click', function() {
        Swal.fire({
            title: "Apakah Anda Yakin Ingin Keluar?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Keluar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('auth.logout') }}";
            }
        });
    });
</script>
