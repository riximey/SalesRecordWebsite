<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">🌸 Flower Shop Admin</a>
        <div>
            <a class="nav-link d-inline me-3" href="/home">Home</a>
            <a class="nav-link d-inline me-3" href="/admin/orders">Order</a>
            <a class="nav-link d-inline me-3" href="/admin/sales">Sales</a>
            <a class="nav-link d-inline me-3" href="/admin/showProfile">Profile</a>
            <form method="POST" action="/logout" class="d-inline">
                @csrf
                <button class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>