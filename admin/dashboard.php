<?php
session_start();
include("../assets/template/header.php");
include("../assets/template/nav.php");
if ($_SESSION["token"] !== true) {
    header("location: ../index.php");
}
?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Dashboard</h1>
    <h4 id="system-time" class="text-center mb-4">System Time: </h4>
    <?php
    $username = $_SESSION['username'];
    if (strpos($username, "@admin") == true) {
        include("admin-includes/admin-dashboard.php");
    }
    else if (strpos($username, "@staff") == true) {
        include("admin-includes/staff-dashboard.php");
    }
    ?>
</div>

<script>
    // Function to update system time
    function updateSystemTime() {
        var systemTimeElement = document.getElementById('system-time');
        var now = new Date();
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric'};
        var formattedTime = now.toLocaleDateString('en-US', options);
        systemTimeElement.textContent = 'System Time: ' + formattedTime;
    }

    // Update system time every second
    setInterval(updateSystemTime, 1000);

    // Initial call to update system time
    updateSystemTime();
</script>



<?php
include("../assets/template/header.php");
?>