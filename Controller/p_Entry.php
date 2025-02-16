<?php
if (isset($_POST["submit"]) || isset($_POST["update"])) {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $party = $_POST['partyKhata'];
    $debit_credit = $_POST['transactionType'];
    $amount = isset($_POST['amount']) && $_POST['amount'] > 0 ? $_POST['amount'] : 0;
    $receiptDate = isset($_POST['receiptDate']) && !empty($_POST['receiptDate']) ? $_POST['receiptDate'] : date("Y-m-d");
    $advanceTypePost = isset($_POST['advanceType']) ? $_POST['advanceType'] : '';
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
            $query = "INSERT INTO `p_khata`(`party_id`,`$debit_credit`, `$advance_type`, `reason`,`receipt_date`) VALUES ('$party','$amount','$advanceVal','$reason', '$receiptDate')";
        } else {
            // update query 
            $query = " UPDATE `p_khata` SET `party_id`='$party' ,`$debit_credit`='$amount', `$advance_type`='$advanceVal', `reason`='$reason', `$other`= NULL, receipt_date = '$receiptDate' where id=$id";
        }

    } else {
        if (isset($_POST["submit"])) {
            $query = "INSERT INTO `p_khata`(`party_id`,`$debit_credit`, `reason`,`receipt_date`) VALUES ('$party','$amount','$reason', '$receiptDate')";
        } else {
            // update query 
            $query = " UPDATE `p_khata` SET `party_id`='$party' ,`$debit_credit`='$amount',`reason`='$reason', `$other`= NULL, receipt_date = '$receiptDate' where id=$id";
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