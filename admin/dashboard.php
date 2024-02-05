<?php
include("../assets/template/header.php");
include("../assets/template/nav.php");
if ($_SESSION["token"] !== true) {
    header("location: ../index.php");
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Dashboard</h1>

    <div class="row">
        <!-- Card 1: Users -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">Total users: 100</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>

        <!-- Card 2: Revenue -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Revenue</h5>
                    <p class="card-text">$1,000,000</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>

        <!-- Card 3: Orders -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Orders</h5>
                    <p class="card-text">Total orders: 500</p>
                    <a href="#" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("../assets/template/header.php");
?>