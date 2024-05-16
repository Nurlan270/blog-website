<?php
    require_once '../app/controllers/auth.php';
?>
<!doctype html>
<html lang="en">
<head>
    <?php require_once '../assets/includes/meta.php' ?>
    <title>Registration</title>
</head>
<body>
<?php require_once '../assets/includes/header.php' ?>

<section class="bg-light p-3 p-md-4 p-xl-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                <div class="card border border-light-subtle rounded-4">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <h2 class="h4 text-center">Registration</h2>
                                    <h3 class="fs-6 fw-normal text-secondary text-center m-0">Enter your details to
                                        register</h3>
                                    <?php
                                        if (!empty($errMsg)) {
                                            echo "<p class='alert alert-danger my-3'>$errMsg</p>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <form action="/auth/Registration" method="post">
                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="login" value="<?= $login ?>" id="login"
                                               placeholder="Your login..." required>
                                        <label for="login" class="form-label">Login</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" name="email" value="<?= $email ?>" id="email"
                                               placeholder="user@mail.com" required>
                                        <label for="email" class="form-label">Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" name="pass" id="pass"
                                               placeholder="Your password" required>
                                        <label for="pass" class="form-label">Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" name="passAgain" id="passAgain"
                                               value="" placeholder="Your password again" required>
                                        <label for="passAgain" class="form-label">Password again</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" name="iAgree"
                                               id="iAgree" required>
                                        <label class="form-check-label text-secondary" for="iAgree">
                                            &nbsp;&nbsp; I agree to the <a href="#!" class="link-primary text-decoration-none">terms
                                                and conditions</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-primary" type="submit" name="btn-reg">Sign up</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <hr class="mt-5 mb-4 border-secondary-subtle">
                                <p class="m-0 text-secondary text-center">Already have an account? <a href="/auth/Login"
                                                                                                      class="link-primary text-decoration-none">Sign
                                        in</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../assets/includes/footer.php' ?>
</body>
</html>