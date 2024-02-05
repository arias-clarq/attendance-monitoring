<?php
include("../assets/template/header.php");
include("../assets/template/nav.php");
if ($_SESSION["token"] !== true) {
    header("location: ../index.php");
}
?>

<?php
include("../assets/template/header.php");
?>