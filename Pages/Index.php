<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("location:Auth.php");
}
$page = "index";
include "../Model/connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index</title>
  <link rel="stylesheet" href="../Assets/css/main.css">
</head>

<body>
  <?php include('navbar.php'); ?>

  <h1 style="display:flex;justify-content:center;align-items:center">Index</h1>

  <section id="main_section">
    <section id="search_bar_section">
      <div>
        <div id="search_text">Search</div>
        <input id="search_bar">
      </div>
      <div style="display:flex; justify-content: center;">
        <div id="buttonAdd" style="margin: 5px;">
          <button>ADD NEW ENTRY</button>
        </div>
        <div id="buttonClosing" style="margin: 5px;">
          <button>CLOSING</button>
        </div>
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
            <th>Receipt At</th>
          </tr>
        </thead>
        <tbody id="tbody">
          <!-- Table content goes here -->
        </tbody>
      </table>
    </section>
  </section>
  <div class="modal" id="modal">
    <div class="modal-content" style="margin:5% auto">
      <span class="close" id="close">&times;</span>

      <div class="form-container">
        <h2>Worker Transaction Form</h2>
        <form>
          <div class="form-group">
            <label for="worker">Worker:</label>
            <select id="worker" name="worker" require>
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


  <!-- edit modal  -->
  <!-- Modal -->
  <div id="editModal" class="modal">
    <div class="modal-content" style="margin:5% auto">
      <span class="close" id="close_modal">&times;</span>
      <h2>Edit Details</h2>
      <div id="editModalDetails"></div>
    </div>
  </div>


  <!-- --- Closing modal ---  -->
  <div class="modal" id="closing_modal">
    <div class="modal-content" style="margin:5% auto">
      <span class="close" id="closing_close">&times;</span>

      <div class="form-container">
        <h2>Worker Closing</h2>
        <form>
          <div class="form-group">
            <label for="worker-closing">Worker:</label>
            <select id="closing_worker" name="closing_worker" require>
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
          <div class="form-group">
            <label>Amount:</label>
            <input type="number" class="closing_amount" name="closing_amount" value="">
          </div>
          <div class="form-group">
            <label>Transaction Type:</label>
            <label>
              <input type="radio" class="closing_transactionType" name="closing_transactionType" value="debit"> Debit
            </label>
            <label>
              <input type="radio" class="closing_transactionType" name="closing_transactionType" value="credit"> Credit
            </label>
          </div>

          <div class="form-group">
            <label for="closing_reason">Reason:</label>
            <input type="text" id="closing_reason" name="closing_reason" placeholder="Enter reason" required>
          </div>
          <div class="form-group">
            <label for="closing_receiptDate">Receipt Date:</label>
            <input type="text" id="closing_receiptDate" name="closing_receiptDate"
              placeholder="<?php echo date("Y-m-d"); ?>" required>
          </div>

          <div class="form-group">
            <input type="submit" id="closing" name="closing" value="Closing">
          </div>
        </form>
      </div>
    </div>
  </div>




</body>

</html>
<script src="../Assets/jquery.min.js"></script>

<script>

  document.getElementById("buttonAdd").addEventListener("click", function () {
    var modal = document.getElementById("modal");
    modal.style.display = "block";
  });
  document.getElementById("buttonClosing").addEventListener("click", function () {
    var modal = document.getElementById("closing_modal");
    modal.style.display = "block";
  });

  document.getElementById("close").addEventListener("click", function () {
    var modal = document.getElementById("modal");
    modal.style.display = "none";
  });

  document.getElementById("close_modal").addEventListener("click", function () {
    var modal = document.getElementById("editModal");
    modal.style.display = "none";
  });
  document.getElementById("closing_close").addEventListener("click", function () {
    var modal = document.getElementById("closing_modal");
    modal.style.display = "none";
  });

  function trClick(tr) {
    var id = tr.getElementsByTagName('td')[0].innerHTML;
    console.log(id);

    $(document).ready(function () {
      $.ajax({
        url: '../Controller/EditKhata.php',
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

  // CTRL + N --> add new data
  document.addEventListener("keyup", function (event) {
    // Check if Ctrl + N is pressed
    if (event.ctrlKey && event.key === "i") {
      event.preventDefault(); // Prevent default behavior
      document.getElementById("buttonAdd").click(); // Trigger button click
    }
  })
  // CTRL + S --> SAVE DATA
  document.addEventListener("keydown", function (event) {
    if (event.ctrlKey && event.key === "s") {
      event.preventDefault(); // Stop the browser's default save behavior
      document.getElementById("submit").click(); // Trigger button click
    }
  });


  $(document).ready(function () {

    function allData() {
      $.ajax({
        url: '../Controller/KhataData.php',
        type: 'post',
        data: { 'data': 'all' },
        success: function (data) {
          $("#tbody").html(data);
        }
      });
    }
    allData();

    $("#search_bar").on("keyup", function () {
      var search = $("#search_bar").val();
      console.log(search);
      $.ajax({
        type: "POST",
        url: "../Controller/KhataData.php", // Create a separate PHP file to handle the request
        data: { data: search },
        success: function (response) {
          // Refresh the page to display the updated worker data
          // console.log(response)
          $("#tbody").html(response)
        },
      });
    })



    $("#submit").on("click", function (event) {
      event.preventDefault();

      var worker = $("#worker").val(); var amount = $(".amount").val();
      var transactionType = $(".transactionType:checked").val();
      var advanceType = $(".advanceType:checked").val();
      var reason = $("#reason").val();
      var receiptDate = $("#receiptDate").val();
      var data;
      console.log(advanceType)
      if (advanceType !== null) {
        data = {
          'submit': 'submit',
          'worker': worker,
          'amount': amount,
          'transactionType': transactionType,
          'advanceType': advanceType,
          'reason': reason,
          'receiptDate': receiptDate
        };
      } else {
        data = {
          'submit': 'submit',
          'worker': worker,
          'amount': amount,
          'transactionType': transactionType,
          'reason': reason,
          'receiptDate': receiptDate
        };
      }

      $.ajax({
        url: '../Controller/Entry.php',
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

    $("#closing").on("click", function (event) {
      event.preventDefault();

      var worker = $("#closing_worker").val();
      var amount = $(".closing_amount").val();
      var transactionType = $(".closing_transactionType:checked").val();
      var reason = $("#closing_reason").val();
      var receiptDate = $("#closing_receiptDate").val();
      var data;

      
        data = {
          'closing': 'closing',
          'worker': worker,
          'amount': amount,
          'transactionType': transactionType,
          'reason': reason,
          'receiptDate': receiptDate
        };

      $.ajax({
        url: '../Controller/Entry.php',
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
    })


    // update/

    $(document).on("click", ("#editsubmit"), function (event) {
      event.preventDefault();

      var id = $("#id").val();
      // console.log("id "+id)
      var worker = $("#editworker").val();
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
          'worker': worker,
          'amount': amount,
          'transactionType': transactionType,
          'advanceType': advanceType,
          'reason': reason
        };
      } else {
        data = {
          'update': 'submit',
          'id': id,
          'worker': worker,
          'amount': amount,
          'transactionType': transactionType,
          'reason': reason
        };
      }

      $.ajax({
        url: '../Controller/Entry.php',
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

    $(document).on("click", "#deleteKhata", function () {
      var id = $(this).val();
      if (confirm("Delete this record") == true) {
        window.location.assign("../Controller/deleteKhata.php?id=" + id);
      }
    })

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



    // it is for showing advance get , advance paid, hand to hand 
    $(document).on("change", ".edittransactionType", function () {
      $("#editadvanceDiv").show("slow");
      var debit_credit = $.trim($(this).val());
      debit_credit = debit_credit.toLowerCase();

      if (debit_credit === 'debit') {
        $("#editadvanceGet").show("slow");
        $("#editadvancePaid").hide("slow");
        $("#edithand_to_hand").hide("slow");
      } else if (debit_credit === 'credit') {
        $("#editadvanceGet").hide("slow");
        $("#editadvancePaid").show("slow");
        $("#edithand_to_hand").show("slow");
      }

      $(".editadvanceType:checked").show();
    });

  });


</script>