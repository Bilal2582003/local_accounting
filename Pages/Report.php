<?php
session_start();
?>
<!-- <script>
 var a =prompt("enter Passwrod");
   var b= `<?php echo $_SESSION['password'] ?>`
   if(!(a == b)){
     window.location.assign("index.php")
  } 
  </script> -->
<!DOCTYPE html>
<html>

<head>
    <title>Report</title>
    <link rel="stylesheet" href="../Assets/css/main.css">

</head>
<style>
    .row {
        width: 100%;
        display: flex;
        justify-content: flex-start;
    }

    .col-6 {
        width: 58%;
        margin: 2%;
    }

    .col-4 {
        width: 38%;
        margin: 2%;
    }

    .col-2 {
        width: 18%;
        margin: 2%;
    }

    .col-12 {
        width: 98%;
        margin: 2%;
    }

    input {
        width: 100%
    }

    select {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
    }

    .form-control {
        padding: 10px;
        border-radius: 8px;
        height: 13px;
    }

    .btn {
        padding: 10px;
        text-align: center;
    }

    .btn-warning {
        color: white;
        background-color: gold;
        border: none;

    }
</style>

<body>
    <?php
    $page = "report";
    include "../Model/connection.php";
    include('navbar.php'); ?>
    <h1 style="display:flex;justify-content:center;align-items:center">Closing Report</h1>
    <section id="main_section">
        <!-- Display Workers Data Table -->
        <form method="post" >
        <div id="main">
            <div class="row">
                    <div class="col-6 ">
                        <select id="worker" name="worker" require>
                            <option disabled selected>SELECT</option>
                            <?php
                            $query = "SELECT * from workers";
                            $res = mysqli_query($con, $query);
                            if (mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                    <option value="<?php echo $row["id"] ?>">
                                        <?php echo $row["name"] ?>
                                    </option>
                                    <?php
                                }
                            } else {
                                echo "No Record!";
                            }
                            ?>
                            <!-- Add more worker options as needed -->
                        </select>
                    </div>
                    <div class="col-4">
                        <select id="closing_date" name="closing_date" require>
                        </select>

                    </div>
                    <div class="col-2">
                        <button type="submit" name="get_report"
                            id="get_report" class="get_report"> Run Report </button>
                    </div>
                </div>
            </div>
        </form>

    </section>

    <div class="row">
        <div class="col-12">
            <?php
            if (isset($_POST['get_report'])) {
                $id = $_POST['worker'];
                $date = $_POST['closing_date'];

                $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
                $date = $con->real_escape_string($date);
                date_default_timezone_set('Asia/Karachi');
                $table = '<table class="mTable"><thead><tr>
<td>SNO</td>
<td>NAME</td>
<td>STATUS</td>
<td>DEBIT</td>
<td>CREDIT</td>
<td>RECEIVED DATE</td>
<td>REASON</td>
<td>CREATED DATE</td>
</tr></thead><tbody>';
                // Initialize sums variables
                $creditSum = 0;
                $debitSum = 0;
                $handToHandSum = 0;
                $style = '';
                $output = '';
                $allcredit = 0;
                $name = '';
                $result = 0;
                $sno = 1;

                // Query to retrieve data based on the given ID
                $query = "SELECT khata.*,workers.name as name FROM khata join workers on khata.worker_id = workers.id WHERE workers.id = $id and khata.deleted_at = '$date' order by receipt_date desc";
                $res = mysqli_query($con, $query);

                // Iterate through the retrieved rows
                while ($row = mysqli_fetch_assoc($res)) {
                    $class = '';
                    // Retrieve the necessary fields from the row
                    $workerId = $row['worker_id'];
                    $credit = $row['credit'];
                    $debit = $row['debit'];
                    $handToHand = $row['hand_to_hand'];
                    $name = $row['name'];
                    $advance_recieved = $row['advance_recived'];
                    $advance_paid = $row['advance_paid'];
                    $status = '';
                    // Perform the necessary calculations
            
                    if ($handToHand != 1) {
                        $debitSum += $debit;
                        $creditSum += $credit;
                    }
                    $result = $creditSum - $debitSum;
                    // agr liya hoa mal zda h or paisy km diye hn
                    if ($result > 0) {
                        $style = "red";
                    } else {
                        $style = "green";
                    }
                    if ($debit == '') {
                        $status = "Credit";
                        $class = "red";
                    } elseif ($credit == '') {
                        $status = "Debit";
                        $class = "green";

                    }
                    if ($handToHand == 1) {
                        $handToHandSum += $credit;
                        $status = "Hand To Hand ";
                        $class = "blue";

                    }
                    $amount = $row['debit'] + $row['credit'];

                    // if($row['receipt_date']){
                    $Rdate = $row['receipt_date'] ? date("Y-M-d (D)", strtotime($row['receipt_date'])) : '-';
                    // $Rdate = date("Y-M-d (D)");
                    // }
                    // if($row['created_at']){
                    // $row['created_at'] = explode(" ",$row['created_at']);
                    // $cdate = date("Y-M-d (D)", $row['created_at'][0]);
                    // $cdate = date("Y-M-d (D)");
                    // }
                    $table .= '<tr>
                    <td>'.$sno.'</td>
          <td>' . $row['name'] . '</td>
          <td>' . $status . '</td>
          <td class="' . $class . '">' . $row['debit'] . '</td>
          <td class="' . $class . '">' . $row['credit'] . '</td>
          <td>' . $Rdate . '</td>
          <td>' . $row['reason'] . '</td>
          <td>' . $row['created_at'] . '</td>
        </tr>';

                    $sno++;
                }
                // Create a div for each worker's name and store the sums within them
                $output .= "<div class='bigfont' style='font-weight: bold;'>Name: $name\t Closing Date: ".date("Y-m-d (D-M)",strtotime($_POST['closing_date']))."</div>";
                $output .= "<div class='bigfont bold' style='color: red;'>Credit Sum: $creditSum</div>";
                $output .= "<div class='bigfont bold' style='color: green;'>Debit Sum: $debitSum</div>";
                $output .= "<div class='bigfont bold' style='color: blue;'>Hand-to-Hand Sum: $handToHandSum</div>";
                $output .= "<div class='bigfont $style' style='width:50%;display:flex;justify-content:center;align-items:center' >Result: $result</div>";


                // }
            
                // Call the function and retrieve the data
// $output = output;
                $table .= '<tbody></table>';
                echo $output . $table;
            }
            ?>
        </div>
    </div>
</body>
<script src="../Assets/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $("#worker").on("change", function () {
            $.ajax({
                url: '../Controller/AllFunctions.php',
                type: 'post',
                data: { 'id': $(this).val(), 'action': 'getClosingDates' },
                success: function (data) {
                    var res = JSON.parse(data)
                    console.log(res)
                    if (res.status == 1) {

                        res.data.forEach(element => {
                            $("#closing_date").append(`<option value='${element.deleted_at}'>${element.dateForShow}</option>`)
                        });
                    } else {
                        $("#closing_date").html('');
                    }


                }
            });
        })
    })
</script>