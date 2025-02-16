<?php
session_start();
?>
<script>
 var a =prompt("enter Passwrod");
   var b= `<?php echo $_SESSION['password'] ?>`
   if(!(a == b)){
     window.location.assign("index.php")
  } 
  </script>


<!DOCTYPE html>
<html>

<head>
  <title>Parties Data</title>
  <link rel="stylesheet" href="../Assets/css/main.css">

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <style>
    /* body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f1f1f1;
} */

   
    #search_bar_section1 {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    
    #search_text1 {
      font-weight: bold;
    }

    #search_bar1 {
      width: 200px;
      height: 30px;
      border: 1px solid #ccc;
      border-radius: 4px;
      padding: 5px;
    }
    #buttonAdd1 {
      text-align: right;
    }
  </style> 
</head>

<body>

  <?php
  $page = "party";
  include('navbar.php'); ?>
  <h1 style="display:flex;justify-content:center;align-items:center">Parties</h1>
  <!-- Add Worker Modal -->
  <div class="modal " id="addPartyModal">
    <div class="modal-content" style="margin:5% auto">
      <span class="close" data-dismiss="modal">&times;</span>
      
      <h2>Add New Party</h2>
      <form id="addPartyForm" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        <label for="contact">Contact:</label>
        <input type="text" name="contact" required><br>
        <label for="address">Address:</label>
        <input type="text" name="address" required><br>
        <label for="city">City:</label>
        <input type="text" name="city" required><br>
        <label for="status">status:</label>
        <select id="status" name="status">
          <option value="0">Worker</option>
          <option value="1" selected>Party</option>
        </select><br>
        <input type="submit" value="Add Party">
      </form>
    </div>
</div>
  <section id="main_section">
    <!-- Add New Worker Button -->
    <section id="search_bar_section">
      <div>
        <div id="search_text">Search</div>
        <input id="search_bar" onkeyup="search()">
      </div>
      <button id="addPartyBtn" >Add New Party</button>
    </section>
    <!-- Display Workers Data Table -->
    <div id="main"
      style="height:350px; overflow-y:scroll;border:1px solid black;margin:20px;padding:10px;border-radius:8px">
      <!-- table data show will hear  -->
    </div>
    <div id="main1"
      style="height:350px; overflow-y:scroll;border:1px solid black;margin:20px;padding:10px;border-radius:8px">
      <!-- table data show will hear  -->
      <section id="search_bar_section1">
        <div>
          <div id="search_text1">Search</div>
          <input id="search_bar1">
        </div>
        <div id="buttonAdd">
          <button>ADD NEW ENTRY</button>
        </div>
      </section>
      <section>
        <table id="table">
          <thead id="thead">
            <tr>
              <th>Worker</th>
              <th>Amount</th>
              <th>Payment Mode</th>
              <th>Advance Mode</th>
              <th>Reason</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody id="tbody">
            <!-- Table content goes here -->
          </tbody>
        </table>
      </section>
    </div>

  </section>


   <!-- Modal -->
   <div id="partyDetailsModal" class="modal">
    <div class="modal-content" style="width:80% !important;margin:5% auto">
      <span class="close">&times;</span>
      <h1 style="display:flex;justify-content:center;align-items:center">Party Details</h1>
      <div id="partyDetails"></div>
      <div id="partyFullTble">
      </div>
    </div>
  </div>



  <div class="modal" id="khataModal">
    <div class="modal-content" style="margin:5% auto">
      <span class="close" >&times;</span>

      <div class="form-container">
        <h2>Party Transaction Form</h2>
        <form>
          <div class="form-group">
            <label for="worker">Party:</label>
            <select id="partyKhata" name="party" require>
              <?php
              include('../Model/connection.php');
              $query = "SELECT * from party";
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
          <div class="form-group">
            <label>Amount:</label>
            <input type="number" class="amount" name="amount" value="">
          </div>
          <div class="form-group">
            <label>Transaction Type:</label>
            <label>
              <input type="radio" class="transactionType" name="transactionType" value="debit"> Debit
            </label>
            <label>
              <input type="radio" class="transactionType" name="transactionType" value="credit"> Credit
            </label>
          </div>

          <div class="form-group" id="advanceDiv" style="display:none">
            <label>Advance:</label>
            <label style="display:none" id="advanceGet">
              <input type="radio" class="advanceType" name="advanceType" value="advance_recived"> Advance Get
            </label>
            <label style="display:none" id="advancePaid">
              <input type="radio" class="advanceType" name="advanceType" value="advance_paid"> Advance Paid
            </label>
            <label style="display:none" id="hand_to_hand">
              <input type="radio" class="advanceType" name="advanceType" value="hand_to_hand"> Hand to Hand
            </label>
          </div>

          <div class="form-group">
            <label for="reason">Reason:</label>
            <input type="text" id="reason" name="reason" placeholder="Enter reason" required>
          </div>
          <div class="form-group">
            <label for="receiptDate">Receipt Date:</label>
            <input type="text" id="receiptDate" name="receiptDate" placeholder="<?php echo date("Y-m-d"); ?>" required>
          </div>

          <div class="form-group">
            <input type="submit" id="submit" name="submit" value="Submit">
          </div>
        </form>
      </div>
    </div>
  </div>
 



  <div id="editModal" class="modal">
    <div class="modal-content" style="margin:5% auto">
      <span class="close" id="close_modal">&times;</span>
      <h2>Edit Details</h2>
      <div id="editModalDetails"></div>
    </div>
  </div>



</body>
<script src="../Assets/jquery.min.js"></script>

<script>

document.getElementById("buttonAdd").addEventListener("click", function () {
    var modal = document.getElementById("khataModal");
    modal.style.display = "block";
  });

   // CTRL + N --> add new data
   document.addEventListener("keyup", function (event) {
    // Check if Ctrl + N is pressed
    if (event.ctrlKey && event.key === "i") {
      event.preventDefault(); // Prevent default behavior
      document.getElementById("buttonAdd").click(); // Trigger button click
    }
    if (event.shiftKey && event.key === "I") {
      event.preventDefault(); // Prevent default behavior
      document.getElementById("addPartyBtn").click(); // Trigger button click
    }
  })

 
  $(document).ready(function(){

    $("#addPartyBtn").on("click",function(){
      $("#addPartyModal").show()

    })
    $(".close").on("click",function(){
      $("#addPartyModal").hide()
      $("#partyDetailsModal").css("display", "none");
      $("#khataModal").css("display", "none");
      $("#editModal").css("display", "none");
    })

     // Add a new Party via AJAX
     $("#addPartyForm").submit(function (e) {
      e.preventDefault();

      // Retrieve the form data
      var formData = $(this).serialize();

      // Send an AJAX request to the server
      $.ajax({
        type: "POST",
        url: "../Controller/add_worker.php", // Create a separate PHP file to handle the request
        data: formData,
        success: function (response) {
          // Refresh the page to display the updated worker data
          $("#addPartyModal").hide()
          showData();
          // console.log(response)
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });

    function showData() {
    $(document).ready(function () {
      $.ajax({
        type: "POST",
        url: "../Controller/partyData.php", // Create a separate PHP file to handle the request
        data: { data: 'all' },
        success: function (response) {
          // Refresh the page to display the updated worker data
          $("#main").html(response)
        },
      });
    })
  }
  showData();


  $("#submit").on("click", function (event) {
      event.preventDefault();

      var partyKhata = $("#partyKhata").val(); 
      var amount = $(".amount").val();
      var transactionType = $(".transactionType:checked").val();
      var advanceType = $(".advanceType:checked").val();
      var reason = $("#reason").val();
      var receiptDate = $("#receiptDate").val();
      var data;
      console.log(advanceType)
      if (advanceType !== null) {
        data = {
          'submit': 'submit',
          'partyKhata': partyKhata,
          'amount': amount,
          'transactionType': transactionType,
          'advanceType': advanceType,
          'reason': reason,
          'receiptDate':receiptDate
        };
      } else {
        data = {
          'submit': 'submit',
          'partyKhata': partyKhata,
          'amount': amount,
          'transactionType': transactionType,
          'reason': reason,
          'receiptDate':receiptDate
        };
      }

      $.ajax({
        url: '../Controller/p_Entry.php',
        type: 'post',
        data: data,
        success: function (data) {
          console.log(data)
          if (data == 1) {
            alert("Inserted");
            allData();
          } else {
            alert("Error!!");
          }
        }
      });
    });

    function allData() {
      $.ajax({
        url: '../Controller/p_KhataData.php',
        type: 'post',
        data: { 'data': 'all' },
        success: function (data) {
          $("#tbody").html(data);
        }
      });
    }
    allData();

     // it is for showing advance get , advance paid, hand to hand 
     $(".transactionType").on("change", function () {
      $("#advanceDiv").show("slow");
      var debit_credit = $.trim($(this).val());
      var debit_credit = debit_credit.toLowerCase();
      if (debit_credit == 'debit') {
        $("#advanceGet").show("slow");
        $("#advancePaid").hide("slow");
        $("#hand_to_hand").hide("slow");
      }
      else if (debit_credit == 'credit') {
        $("#advanceGet").hide("slow");
        $("#advancePaid").show("slow");
        $("#hand_to_hand").show("slow");
      }
      $("input[name='advanceType']").prop("checked", false);
    });


    
    $(document).on("click", ("#editsubmit"), function (event) {
      event.preventDefault();

      var id = $("#id").val();
      // console.log("id "+id)
      var partyKhata = $("#editworker").val();
      var amount = $(".editamount").val();
      var transactionType = $(".edittransactionType:checked").val();
      var advanceType = $(".editadvanceType:checked").val();
      var reason = $("#editreason").val();
      var data;
      // console.log(advanceType)
      if (advanceType !== null) {
        data = {
          'update': 'submit',
          'id': id,
          'partyKhata': partyKhata,
          'amount': amount,
          'transactionType': transactionType,
          'advanceType': advanceType,
          'reason': reason
        };
      } else {
        data = {
          'update': 'submit',
          'id': id,
          'partyKhata': partyKhata,
          'amount': amount,
          'transactionType': transactionType,
          'reason': reason
        };
      }

      $.ajax({
        url: '../Controller/p_Entry.php',
        type: 'post',
        data: data,
        success: function (data) {
          console.log(data)
          if (data == 1) {
            alert("Updated");
            allData();
          } else {
            alert("Error!!");

          }
        }
      });
    });
    

    $("#search_bar1").on("keyup", function () {
      var search = $("#search_bar1").val();
      console.log(search);
      $.ajax({
        type: "POST",
        url: "../Controller/p_KhataData.php", // Create a separate PHP file to handle the request
        data: { data: search },
        success: function (response) {
          // Refresh the page to display the updated worker data
          // console.log(response)
          $("#tbody").html(response)
        },
      });
    })

  })
  function trClick(tr) {
    var id = tr.getElementsByTagName('td')[0].innerHTML;
    console.log(id);

    $(document).ready(function () {
      $.ajax({
        url: '../Controller/p_EditKhata.php',
        type: 'post',
        data: { 'id': id },
        success: function (data) {
          // console.log(data);
          $("#editModalDetails").html(data);
          $("#editModal").css("display", "block"); // Set the display style to "block"

        }
      });
    });
  }

function partyDetials(tr) {
  $(document).ready(function () {
    var id = tr.getElementsByTagName('td')[0].innerHTML;
    // console.log(id);
    $.ajax({
      type: "POST",
      url: "../Controller/partyDetails.php", // Create a separate PHP file to handle the request
      data: { data: id },
      success: function (response) {
        // Refresh the page to display the updated worker data
        // console.log(response)
        // console.log(response);
        response = response.split('!');
        $("#partyDetails").html(response[0])
        $("#partyFullTble").html(response[1])
        $("#partyDetailsModal").css("display", "block");
      },
    });
  })
}

function search() {
    $(document).ready(function () {
      var search = $("#search_bar").val();
      console.log(search);
      $.ajax({
        type: "POST",
        url: "../Controller/partyData.php", // Create a separate PHP file to handle the request
        data: { data: search },
        success: function (response) {
          // Refresh the page to display the updated worker data
          // console.log(response)
          $("#main").html(response)
        },
      });
    })
  }

</script>
</html>