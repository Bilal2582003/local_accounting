<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Workers Data</title>

  <link rel="stylesheet" href="../Assets/css/main.css">

</head>

<body>

  <?php
  $page = "work";
  include('navbar.php'); ?>
  <h1 style="display:flex;justify-content:center;align-items:center">Worker</h1>
  <!-- Add Worker Modal -->
  <div id="addWorkerModal" class="modal">
    <div class="modal-content" style="margin:5% auto">
      <span class="close">&times;</span>
      <h2>Add New Worker</h2>
      <form id="addWorkerForm" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        <label for="contact">Contact:</label>
        <input type="text" name="contact" required><br>
        <label for="address">Address:</label>
        <input type="text" name="address" required><br>
        <label for="city">City:</label>
        <input type="text" name="city" required><br>
        <label for="status">status:</label>
        <select id="status" name="status" class="selectBox">
          <option value="0" selected>Worker</option>
          <option value="1">Party</option>
        </select><br>
        <input type="submit" value="Add Worker">
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
      <button id="addWorkerBtn">Add New Worker</button>
    </section>
    <!-- Display Workers Data Table -->
    <div id="main">
      <!-- table data show will hear  -->
    </div>
  </section>

  <!-- Modal -->
  <div id="workerDetailsModal" class="modal">
    <div class="modal-content" style="width:80% !important;margin:5% auto">
      <span class="close">&times;</span>
      <h1 style="display:flex;justify-content:center;align-items:center">Worker Details</h1>
      <div id="workerDetails"></div>
      <div id="workerFullTble">
      </div>
    </div>
  </div>


</body>
<script src="../Assets/jquery.min.js"></script>
<script>

  function showData() {
    $(document).ready(function () {
      $.ajax({
        type: "POST",
        url: "../Controller/workerData.php", // Create a separate PHP file to handle the request
        data: { data: 'all' },
        success: function (response) {
          // Refresh the page to display the updated worker data
          $("#main").html(response)
        },
      });
    })
  }
  showData();

  function search() {
    $(document).ready(function () {
      var search = $("#search_bar").val();
      console.log(search);
      $.ajax({
        type: "POST",
        url: "../Controller/workerData.php", // Create a separate PHP file to handle the request
        data: { data: search },
        success: function (response) {
          // Refresh the page to display the updated worker data
          // console.log(response)
          $("#main").html(response)
        },
      });
    })
  }
  // CTRL + N --> add new data
  document.addEventListener("keyup", function (event) {
    // Check if Ctrl + N is pressed
    if (event.ctrlKey && event.key === "i") {
      event.preventDefault(); // Prevent default behavior
      document.getElementById("addWorkerBtn").click(); // Trigger button click
    }
  })
  //CTRL + S
  document.addEventListener("keydown", function (event) {
    if (event.ctrlKey && event.key.toLowerCase() === "s") {
      event.preventDefault(); // Prevent browser's default save behavior
      const form = document.getElementById("addWorkerForm");
      if (form) {
        // Find the submit button within the form
        const submitButton = form.querySelector('input[type="submit"]');
        if (submitButton) {
          submitButton.click(); // Trigger button click programmatically
        } else {
          console.warn("No submit button found in the form!");
        }
      }
    }
  });

  $(document).ready(function () {
    // Open the modal
    $("#addWorkerBtn").click(function () {
      $("#addWorkerModal").css("display", "block");
    });

    // Close the modal
    $(".close").click(function () {
      $("#addWorkerModal").css("display", "none");
      $("#workerDetailsModal").css("display", "none");
    });

    // Add a new worker via AJAX
    $("#addWorkerForm").submit(function (e) {
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
          $("#addWorkerModal").css("display", "none");
          showData();
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });

  function workerDetials(tr) {
    $(document).ready(function () {
      var id = tr.getElementsByTagName('td')[0].innerHTML;
      console.log(id);
      $.ajax({
        type: "POST",
        url: "../Controller/workerDetails.php", // Create a separate PHP file to handle the request
        data: { data: id },
        success: function (response) {
          // Refresh the page to display the updated worker data
          // console.log(response)
          console.log(response);
          response = response.split('!');
          $("#workerDetails").html(response[0])
          $("#workerFullTble").html(response[1])
          $("#workerDetailsModal").css("display", "block");
        },
      });
    })
  }

</script>

</html>