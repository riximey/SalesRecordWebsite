<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Riri's Flower Shop</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('css');
</head>
<body>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>