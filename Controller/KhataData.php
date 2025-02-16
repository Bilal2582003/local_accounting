<?php
if(isset($_POST['data'])){
    $output='';
    include "../Model/connection.php";
    if($_POST['data'] == 'all'){
        $query="SELECT khata.*,workers.name as worker_name from khata join workers on khata.worker_id = workers.id where khata.deleted_at is null order by receipt_date desc";
      
    }
    else{
        $search=$_POST['data'];
        $query="SELECT khata.*,workers.name as worker_name from khata join workers on khata.worker_id = workers.id where khata.credit like '%$search%' or khata.debit like '%$search%' or khata.reason like '%$search%' or workers.name like '%$search%' and khata.deleted_at is null  order by receipt_date desc";
    }
    $res=mysqli_query($con,$query);
    if(mysqli_num_rows($res) > 0){
        while($row=mysqli_fetch_assoc($res)){

            $debit='';
            $amount='';
            if($row['debit'] != ''){
                $amount="<div class='green'>".$row['debit']."</div>"; 
                $debit="<div class='green'>Debit</div>";
            }else{
                $amount="<div class='red'>".$row['credit']."</div>";
                $debit="<div class='red'>Credit</div>";
            }
            $advance='';
            if($row['advance_recived'] == 1 ){
                $advance="<div class='red'>Advance Get</div>";
            }
            if($row['advance_paid'] == 1){
                $advance="<div class='green'>Advance Paid</div>";
            }if($row['hand_to_hand'] == 1){
                $advance="<div class='blue'>Hand To Hand</div>";
            }
           

            $output .='
            <tr onclick="trClick(this)">
            <td style="display:none">'.$row['id'].'</td>
            <td>'.$row['worker_name'].'</td>
            <td>'.$amount.'</td>
            <td>'.$debit.'</td>
            <td>'.$advance.'</td>
            <td>'.$row['reason'].'</td>
            <td>'.$row['created_at'].'</td>
            <td><a class="printBtn" href="../Controller/slip.php?id='.$row['id'].'&type=worker">Print</button></td>
            </tr>
            ';
        }
        echo $output;
    }
    else{
       echo $output="No Record";
    }


}
?>