<?php
if(isset($_POST['id'])){
    $id= $_POST['id'];
    $output='';
    include "../Model/connection.php";
        $query="SELECT khata.*,workers.name as worker_name from khata join workers on khata.worker_id = workers.id where khata.id = $id and khata.deleted_at is null";    
    $res=mysqli_query($con,$query);
    if(mysqli_num_rows($res) > 0){
        while($row=mysqli_fetch_assoc($res)){

            $workerData='';
            $transctionTypedebit='';
            $transctionTypecredit='';
            $advance_received=$row['advance_recived'] == 1 ? 'checked' :'';
            $advance_paid=$row['advance_paid'] == 1 ? 'checked' :'';
            $hand_to_hand=$row['hand_to_hand'] == 1 ? 'checked' :'';
            $amount=$row['debit'] != '' && $row['debit'] != 0 ?$row['debit']:$row['credit'];

            $hideShowGet=$row['advance_recived'] == 1 ? '' :'style="display:none"';
            $hideShowPaid=$row['advance_paid'] == 1 ? '' :'style="display:none"';
            $hideShowhand_to_hand=$row['hand_to_hand'] == 1 ? '' :'style="display:none"';
            



            $worker_id = $row["worker_id"];
            $workerData .=' <option selected value="'.$row["worker_id"].'">'.$row["worker_name"].'</option>';
            $WorkerQuery="SELECT * from workers where id != '$worker_id'";
            $workerRes=mysqli_query($con,$WorkerQuery);
            if(mysqli_num_rows($workerRes) > 0){
                while($workerRow=mysqli_fetch_assoc($workerRes)){
            $workerData .=' <option value="'.$workerRow["id"].'">'.$workerRow["name"].'</option>';
                }
            }
            else{
                echo "No Record!";
            }
            
            if($row['debit'] != '' || $row['debit'] != 0){
                $transctionTypedebit ='checked';
            }
            else{
                $transctionTypecredit ='checked';
            }




            $output .='
            <div class="form-container">
  <h2>Worker Transaction Form</h2>
  <form >
    <div class="form-group">
    <input type="hidden" value="'.$row['id'].'" id="id">
      <label for="worker">Worker:</label>
      <select id="editworker" name="worker" require>
       '.$workerData.'
        <!-- Add more worker options as needed -->
      </select>
    </div>
    <div class="form-group">
    <label>Amount:</label>
    <input type="number" class="editamount" name="amount" value="'.$amount.'">
    </div>
    <div class="form-group">
      <label>Transaction Type:</label>
      <label>
                <input type="radio" '.$transctionTypedebit.' class="edittransactionType green" name="transactionType" value="debit"> Debit
              </label>
              <label>
                <input type="radio" '.$transctionTypecredit.' class="edittransactionType red" name="transactionType" value="credit"> Credit
              </label>
    </div>

    <div class="form-group" id="editadvanceDiv" style="display:none">
      <label>Advance:</label>
      <label '.$hideShowGet.' id="editadvanceGet">
        <input type="radio" '.$advance_received.' class="editadvanceType green" name="advanceType" value="advance_recived"> Advance Get
      </label>
      <label '.$hideShowPaid.' id="editadvancePaid">
        <input type="radio" '.$advance_paid.' class="editadvanceType" name="advanceType" value="advance_paid"> Advance Paid
      </label>
      <label '.$hideShowhand_to_hand.' id="edithand_to_hand">
        <input type="radio" '.$hand_to_hand.' class="editadvanceType" name="advanceType" value="hand_to_hand"> Hand to Hand
      </label>
    </div>

    <div class="form-group">
      <label for="reason">Reason:</label>
      <input type="text" value="'.$row['reason'].'" id="editreason" name="reason" placeholder="Enter reason" required>
    </div>

    <div class="form-group">
      <input type="submit" id="editsubmit" name="submit" value="Update">
      <button type="button" style="color:red;background-color:#FF8a8a;" id="deleteKhata" value="'.$row['id'].'">Delete</button>
    </div>
  </form>
</div>';
        }

            echo $output;
}
    else{
       echo $output="No Record";
    }


}

?>