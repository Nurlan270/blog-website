<?php
    require_once __DIR__ . '/../../app/database/functions.php';
?>
<header class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <a href="/"><h1>My blog</h1></a>
            </div>
            <nav class="col-8">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/About-us">About us</a></li>
                    <li><a href="/Our-services">Services</a></li>
                    <li>
<!--                        Regular user    -->
                        <?php
                            if (isset($_SESSION['id'])):
                        ?>
                        <a href="#">
                            <i class="fa-regular fa-circle-user"></i>
                            <?= $_SESSION['login'] ?>
                        </a>
                        <ul>
                            <?php if ($_SESSION['admin']): ?>
                                <li><a href="/ADMIN">Admin panel</a></li>
                            <?php endif; ?>
                            <li><a href="/auth/Logout">Log out</a></li>
                        </ul>

<!--                        Not signed up     -->
                        <?php
                            elseif (!isset($_SESSION['id'])):
                        ?>
                        <a href="/auth/Registration">
                            <i class="fa-regular fa-user"></i>
                            Sign up
                        </a>
                        <ul>
                            <li><a href="/auth/Login">Log in</a></li>
                        </ul>
                        <?php
                            endif;
                        ?>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>