<?php
if (isset($_POST['action'])) {
    include_once "setup.php";
    if ($_POST['action'] == 'getClosingDates') {
        echo getDeleteDateByCustomerId($_POST['id']);
    }

}
?>