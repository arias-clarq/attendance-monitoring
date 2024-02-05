<?php
include("assets/template/header.php");
session_start();
?>

<style>
    .gradient-custom {
        /* fallback for old browsers */
        background: #6a11cb;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
    }
</style>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold mb-2 text-uppercase">Attendance Monitoring System</h2>
                            <p class="text-white-50 mb-5">Please enter your login and password!</p>

                            <!-- login error messages -->
                            <div class="container">
                                <?php
                                if (isset($_SESSION['message'])) {
                                    ?>
                                    <div class="alert alert-danger">
                                       
                                        <strong>
                                            <?= $_SESSION['message'] ?>
                                        </strong>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <form action="config/login.php" method="post">
                                <div class="form-outline form-white mb-4">
                                    <input type="text" class="form-control form-control-lg" placeholder="Enter Username"
                                        name="username" />
                                    <label class="form-label">Username</label>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" placeholder="Enter Password"
                                        class="form-control form-control-lg" name="password" />
                                    <label class="form-label">Password</label>
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                            </form>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
session_unset();
include("assets/template/header.php");
?>