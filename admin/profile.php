<?php
include("../assets/template/header.php");
include("../assets/template/nav.php");
if ($_SESSION["token"] !== true) {
    header("location: ../index.php");
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- User Profile Card -->
            <div class="card">
                <img src="https://via.placeholder.com/150" class="card-img-top" alt="User Image">
                <div class="card-body">
                    <h5 class="card-title">John Doe</h5>
                    <p class="card-text">Web Developer</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Email: john.doe@example.com</li>
                    <li class="list-group-item">Phone: +1 (123) 456-7890</li>
                    <li class="list-group-item">Location: City, Country</li>
                </ul>
                <div class="card-body">
                    <a href="#" class="btn btn-primary">Edit Profile</a>
                    <a href="#" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("../assets/template/header.php");
?>