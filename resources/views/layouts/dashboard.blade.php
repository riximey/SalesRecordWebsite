<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Flower Shop Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    body {
        background-color:#ffffff;
    }

    .navbar {
        background-color: #ff69b4;
    }

    .navbar-brand, .nav-link {
        color: white !important;
        font-weight: 500;
    }

    .btn-pink {
        background-color: #ff69b4;
        color: white;
    }

    .btn-pink:hover {
        background-color: #ff1493;
        color: white;
    }

    .table thead {
        background-color: #ffc0cb;
    }

    .card {
        border-radius: 15px;
    }

    .modal-header {
        background-color: #ffc0cb;
    }
</style>
</head>
<body>
    @include('layouts.navbar')
    @yield('contents')
    @if(session('error'))
      <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center text-bg-danger border-0" role="alert">
          <div class="d-flex">
            <div class="toast-body">
              {{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
          </div>
        </div>
      </div>
    @endif

    @if(session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div class="toast align-items-center text-bg-success border-0" role="alert">
        <div class="d-flex">
          <div class="toast-body">
            {{ session('success') }}
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
      </div>
    </div>
    @endif
  
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        const toastElist = document.querySelectorAll('.toast');
            toastElist.forEach(function(toastEl){
                const toast= new bootstrap.Toast(toastEl,{
                    delay: 3000
                });
                toast.show();
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    @stack('scripts')
</body>
</html>