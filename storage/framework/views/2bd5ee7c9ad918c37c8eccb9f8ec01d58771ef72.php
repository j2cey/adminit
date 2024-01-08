<nav class="main-header navbar navbar-expand-md navbar-light navbar-lightblue">
    <div class="container">
        <a href="/" class="navbar-brand"
           style="display: flex; align-items: center; justify-content: center; height: 100%; ">
            <img src="<?php echo e(asset('assets/images/app_logo.JPG')); ?>" alt="Logo" class="brand-image elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light"><?php echo e(config('app.name', 'Admin-IT')); ?></span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/dashboards" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i> Tableau de Bord</a>
                </li>

                <?php if(false): ?>
                <li class="nav-item dropdown">
                    <a id="dropdownSubjects" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Sujet(s)</a>
                    <ul aria-labelledby="dropdownSubjects" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/subjects" class="nav-link">Liste</a>
                        </li>
                        <li class="nav-item">
                            <a href="/subjects/create" class="nav-link">Créer</a>
                        </li>
                        <li class="nav-item">
                            <a href="/categories" class="nav-link">Catégories</a>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li>
                <?php endif; ?>

                <li class="nav-item dropdown">
                    <a id="dropdownReports" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Rapport(s)</a>
                    <ul aria-labelledby="dropdownReports" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/reports" class="nav-link">Rapport(s)</a>
                        </li>
                        <li class="nav-item">
                            <a href="/reporttypes" class="nav-link">Type(s) de Rapport</a>
                        </li>
                        <li class="nav-item">
                            <a href="/treatments" class="nav-link">Traitements</a>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a id="dropdownReports" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Ressource IT</a>
                    <ul aria-labelledby="dropdownReports" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/accessaccounts" class="nav-link">Comptes d'accès</a>
                        </li>
                        <li class="nav-item">
                            <a href="/reportservers" class="nav-link">Serveurs</a>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/reportsetting.index" class="nav-link"><i class="nav-icon fa fa-gears"></i> Paramètres</a>
                </li>

                <?php if(auth()->check() && auth()->user()->hasRole('Admin')): ?>
                <li class="nav-item dropdown">
                    <a id="usersMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Utilisateurs</a>
                    <ul aria-labelledby="usersMenu" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/users" class="nav-link">Liste</a>
                        </li>
                        <li class="dropdown-submenu dropdown-hover">
                            <a id="rolesMenu" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Profils</a>
                            <ul aria-labelledby="rolesMenu" class="dropdown-menu border-0 shadow">
                                <li class="nav-item">
                                    <a href="/roles" class="nav-link">Liste</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if(auth()->check() && auth()->user()->hasRole('Admin')): ?>
                <li class="nav-item dropdown">
                    <a id="systemsMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Système</a>
                    <ul aria-labelledby="systemsMenu" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/systems.index" class="nav-link">Index</a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

            </ul>

            <!-- SEARCH FORM -->

        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->


        <!-- Notifications Dropdown Menu -->

            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-th-large"></i></a>
            </li>
        </ul>
    </div>
</nav>
<?php /**PATH /var/www/adminit/resources/views/layouts/admin02/nav/nav.blade.php ENDPATH**/ ?>