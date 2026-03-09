<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">

        <a class="navbar-brand" href="/basic/index.php">MyApp</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">

            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- HOME -->
                <li class="nav-item">
                    <a class="nav-link" href="/basic/index.php">Home</a>
                </li>


                <!-- LOGIN USER MENU -->
                <?php if (!empty($user)) { ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/basic/?page=dashboard">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/basic/?page=profile">
                            Profile
                        </a>
                    </li>

                <?php } ?>


                <!-- ADMIN MENU -->
                <?php if (!empty($user) && $isAdmin) { ?>

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">

                            User Management
                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="/basic/?page=user/list">
                                    User List
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="/basic/?page=user/create">
                                    Create User
                                </a>
                            </li>

                        </ul>

                    </li>

                <?php } ?>

            </ul>



            <!-- ACCOUNT MENU -->
            <ul class="navbar-nav">

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">

                        <?php
                        if (!empty($user)) {
                            echo $user->name;
                        } else {
                            echo "Account";
                        }
                        ?>

                    </a>


                    <ul class="dropdown-menu dropdown-menu-end">

                        <?php if (empty($user)) { ?>

                            <li>
                                <a class="dropdown-item" href="/basic/?page=login">
                                    Login
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="/basic/?page=register">
                                    Register
                                </a>
                            </li>

                        <?php } else { ?>

                            <li>
                                <a class="dropdown-item" href="/basic/?page=profile">
                                    Profile
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="/basic/?page=dashboard">
                                    Dashboard
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item" href="/basic/?page=logout">
                                    Logout
                                </a>
                            </li>

                        <?php } ?>

                    </ul>

                </li>

            </ul>


            <!-- SEARCH -->
            <form class="d-flex ms-3" role="search">

                <input class="form-control me-2" type="search" placeholder="Search">

                <button class="btn btn-outline-success" type="submit">

                    Search

                </button>

            </form>

        </div>
    </div>
</nav>
