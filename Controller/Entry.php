<?php
if (isset($_POST["submit"]) || isset($_POST["update"]) || isset($_POST['closing'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $worker = $_POST['worker'];
    $debit_credit = $_POST['transactionType'];
    $amount = isset($_POST['amount']) && $_POST['amount'] > 0 ? $_POST['amount'] : 0;
    $receiptDate = isset($_POST['receiptDate']) && !empty($_POST['receiptDate']) ? $_POST['receiptDate'] : date("Y-m-d");
    $advanceTypePost = isset($_POST['advanceType']) && !empty($_POST['advanceType'])  ? $_POST['advanceType'] : '';
    $other = $debit_credit == 'debit' ? 'credit' : 'debit';
    include "../Model/connection.php";
    $reason = mysqli_real_escape_string($con, $_POST['reason']);


    if ($advanceTypePost != '') {
        $advance_type = $advanceTypePost;
        $advanceVal = 0;
        if ($advance_type == "advance_recived") {
            $advanceVal = 1;
        }
        if ($advance_type == "advance_paid") {
            $advanceVal = 1;
        }
        if ($advance_type == "hand_to_hand") {
            $advanceVal = 1;
        }

        if (isset($_POST["submit"])) {
            $query = "INSERT INTO `khata`(`worker_id`,`$debit_credit`, `$advance_type`, `reason`,`receipt_date`) VALUES ('$worker','$amount','$advanceVal','$reason', '$receiptDate')";
        } else {
            // update query 
            $query = " UPDATE `khata` SET `worker_id`='$worker' ,`$debit_credit`='$amount', `$advance_type`='$advanceVal', `reason`='$reason', `$other`= NULL, receipt_date = '$receiptDate' where id=$id";
        }

    } else {
        if (isset($_POST["submit"]) || isset($_POST['closing'])) {
            if (isset($_POST['closing'])) {
                $closing_date_set = date("Y-m-d H:i:s" , strtotime($receiptDate));
                $query1 = " UPDATE `khata` SET deleted_at = '$closing_date_set', delete_reason = 'closing' where worker_id = '$worker' and deleted_at is null ";
                $res1 = mysqli_query($con, $query1);
            }
            $query = "INSERT INTO `khata`(`worker_id`,`$debit_credit`, `reason`,`receipt_date`) VALUES ('$worker','$amount','$reason', '$receiptDate')";
        } else if (isset($_POST['update'])) {
            // update query 
            $query = " UPDATE `khata` SET `worker_id`='$worker' ,`$debit_credit`='$amount',`reason`='$reason', `$other`= NULL, receipt_date = '$receiptDate' where id=$id";
        }
    }

    $res = mysqli_query($con, $query);
    if ($res) {
        echo 1;
    } else {
        echo $query;
    }
}

?>