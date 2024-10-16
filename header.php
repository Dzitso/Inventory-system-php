<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-box-seam"></i> Smd
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <?php if (isset($_SESSION["user_id"])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Assets
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="add_asset.php">Add Asset</a></li>
                                <li><a class="dropdown-item" href="asset_list.php">View Assets</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Departments
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="add_department.php">Add Department</a></li>
                                <li><a class="dropdown-item" href="department_list.php">View Departments</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Maintenance Task
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="add_department.php">Add Maintenance Task</a></li>
                                <li><a class="dropdown-item" href="department_list.php">View maintenance Tasks</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
                <form class="d-flex me-3" action="search.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search assets" aria-label="Search" name="q">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
                <?php if (isset($_SESSION["user_id"])): ?>
                    <span class="navbar-text me-3">
                        Logged in as: <?php echo $_SESSION['username']; ?>
                    </span>
                    <a href="logout.php" class="btn btn-outline-light">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-light me-2">Login</a>
                    <a href="register.php" class="btn btn-light">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>