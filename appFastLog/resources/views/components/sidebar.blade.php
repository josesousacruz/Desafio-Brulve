<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="/" class="logo">
                <h1 class="text-white text-2xl font-bold">FastLog</h1>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="/dashboard" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('pedido*') ? 'active' : '' }}">
                    <a href="/pedido" class="nav-link">
                        <i class="fas fa-box"></i>
                        <p>Pedidos</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('entregador*') ? 'active' : '' }}">
                    <a href="/entregador" class="nav-link">
                        <i class="fas fa-motorcycle"></i>
                        <p>Entregadores</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('usuario*') ? 'active' : '' }}">
                    <a href="/usuario" class="nav-link">
                        <i class="fas fa-users"></i>
                        <p>Usuários</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>