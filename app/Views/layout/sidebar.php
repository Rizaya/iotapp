<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/index3.html" class="brand-link">
        <img src="/dist/img/desktop-computer.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Monitoring APP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= base_url(); ?>dashboard" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Charts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/tds" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>TDS Chart</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/ph" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>pH Chart</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/suhu" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Suhu Chart</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/logging" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Logging
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>