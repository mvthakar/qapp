<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
            <a href="<?= urlOf('admin/') ?>" class="text-center">
                <img src="<?= urlOf('admin/assets/images/logo.jpg') ?>" alt="Logo" class="brand-image elevation-3" id="brand-logo">
                <span class="brand-text font-weight-light"></span>
            </a>
        </div>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= urlOf('admin/assets/images/user.png') ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">QApp</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Dashboard
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= urlOf('admin/categories') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Categories</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= urlOf('admin/questions') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Questions</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Account
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= urlOf('admin/change-password.php') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Change password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= urlOf('admin/logout.php') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Log out</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>