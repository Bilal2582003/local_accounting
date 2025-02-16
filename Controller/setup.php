<?php

include "../Model/connection.php";
function getDeleteDateByCustomerId($id){
    global $con ;
    $query="SELECT * from khata where worker_id = '$id' and deleted_at is not null and delete_reason = 'closing' group by deleted_at ";
    $res=$con->query($query);
    $data = array();
    $status = 0;
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            $row['dateForShow'] = date("d-m-Y (D-m)",strtotime($row['deleted_at']));
            $data[] = $row;
        }
        $status = 1;
    }
    return json_encode(['status'=> $status , "data"=>$data]);
}

?>