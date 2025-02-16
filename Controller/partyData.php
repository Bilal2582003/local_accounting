<?php
  // Database credentials
  
    include "../Model/connection.php";

    if(isset($_POST['data'])){
// Fetch workers data from the table
if($_POST['data'] == 'all'){
  $sql = "SELECT id, name, contact, address, city FROM party";
}
else {
  $search= $_POST['data'];
  $sql = "SELECT id, name, contact, address, city FROM party where name like '%$search%' or contact like '%$search%' or address like '%$search%' or city like '%$search%'";
}

$result = $con->query($sql);
  if($result){

  
    if ($result->num_rows > 0) {
      // Output table header
      echo "<table>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>City</th>
              </tr>";
  
      // Output table rows
      while ($row = $result->fetch_assoc()) {
        echo "<tr onclick='partyDetials(this)'>
                <td>".$row['id']."</td>
                <td>".$row['name']."</td>
                <td>".$row['contact']."</td>
                <td>".$row['address']."</td>
                <td>".$row['city']."</td>
              </tr>";
      }
  
      echo "</table>";
    } else {
      echo "No workers found in the database.";
    }
  
    // Close the database connection
    $con->close();

    }
  }
  else{
    echo "No workers found in the database.";
  }
    
    
  
  

  
    ?>