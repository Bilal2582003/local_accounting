<?php
// Assuming you have a database connection established
// ...

// Sanitize and validate the received ID to prevent SQL injection
$id = $_POST['data'];

$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
date_default_timezone_set('Asia/Karachi');
$table = '<table class="mTable"><thead><tr>
<td>NAME</td>
<td>STATUS</td>
<td>DEBIT</td>
<td>CREDIT</td>
<td>RECEIVED DATE</td>
<td>REASON</td>
<td>CREATED DATE</td>
</tr></thead><tbody>';
// function getDataAndCalculateSums($id) {
    include "../Model/connection.php";
    // Initialize sums variables
    $creditSum = 0;
    $debitSum = 0;
    $handToHandSum = 0;
    $style='';
    $output = '';
    $allcredit=0;
    $name='';
    $result=0;

    // Query to retrieve data based on the given ID
    $query = "SELECT khata.*,workers.name as name FROM khata join workers on khata.worker_id = workers.id WHERE workers.id = $id and khata.deleted_at is null  order by receipt_date desc";
    $res=mysqli_query($con,$query);

    // Iterate through the retrieved rows
    while ($row = mysqli_fetch_assoc($res)) {
        $class='';
        // Retrieve the necessary fields from the row
        $workerId = $row['worker_id'];
        $credit = $row['credit'];
        $debit = $row['debit'];
        $handToHand = $row['hand_to_hand'];
        $name = $row['name'];
        $advance_recieved=$row['advance_recived'];
        $advance_paid=$row['advance_paid'];
        $status ='';
        // Perform the necessary calculations
        
        if($handToHand != 1){
            $debitSum += $debit;
            $creditSum += $credit;
        }
        $result=$creditSum - $debitSum;
        // agr liya hoa mal zda h or paisy km diye hn
        if($result > 0){
            $style="red";
        }
        else{
            $style="green";
        }
        if($debit == ''){
            $status = "Credit";
            $class ="red";
        }elseif($credit == ''){
            $status = "Debit";
            $class ="green";

        }
        if($handToHand == 1){
            $handToHandSum +=$credit;
            $status = "Hand To Hand ";
            $class ="blue";

        }
        $amount = $row['debit'] + $row['credit'];

        // if($row['receipt_date']){
            $Rdate =  $row['receipt_date'] ? date("Y-M-d (D)", strtotime($row['receipt_date'])) : '-';
            // $Rdate = date("Y-M-d (D)");
        // }
        // if($row['created_at']){
            // $row['created_at'] = explode(" ",$row['created_at']);
            // $cdate = date("Y-M-d (D)", $row['created_at'][0]);
            // $cdate = date("Y-M-d (D)");
        // }
        $table .='<tr>
          <td>'.$row['name'].'</td>
          <td>'.$status.'</td>
          <td class="'.$class.'">'.$row['debit'].'</td>
          <td class="'.$class.'">'.$row['credit'].'</td>
          <td>'.$Rdate.'</td>
          <td>'.$row['reason'].'</td>
          <td>'.$row['created_at'].'</td>
        </tr>';


    }
  // Create a div for each worker's name and store the sums within them
  $output .= "<div class='bigfont' style='font-weight: bold;'>Name: $name</div>";
  $output .= "<div class='bigfont bold' style='color: red;'>Credit Sum: $creditSum</div>";
  $output .= "<div class='bigfont bold' style='color: green;'>Debit Sum: $debitSum</div>";
  $output .= "<div class='bigfont bold' style='color: blue;'>Hand-to-Hand Sum: $handToHandSum</div>";
  $output .= "<div class='bigfont $style' style='width:50%;display:flex;justify-content:center;align-items:center' >Result: $result</div>";
  
    
// }

// Call the function and retrieve the data
// $output = output;
$table .='<tbody></table>';
// Output the result or use it as needed
echo $output.'!'.$table;
?>
