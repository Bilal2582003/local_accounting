<div class="navbar">
    <a href="../Pages/Index.php" class="<?php if ($page == 'index') {
        echo "active";
    } ?>">Index</a>
    <a href="../Pages/Workers.php" class="<?php if ($page == 'work') {
        echo "active";
    } ?>">Worker</a>
    <a href="../Pages/Parties.php" class="<?php if ($page == 'party') {
        echo "active";
    } ?>">Settings</a>
    <a href="../Pages/Report.php" class="<?php if ($page == 'report') {
        echo "active";
    } ?>">Report</a>

    <img src="../Assets/Images/moon.png" id="icon" width="20px" height="20px" />
    <!-- Add more navigation links as needed -->
    <div id="logout"><a href="../Controller/logout.php"
            style="padding:13px;position:absolute;right:10px;color:whtie;border:1.3px solid red;border-radius:8px;background-color:darkred">Logout</a>
    </div>
</div>

<script>
    var icon = document.getElementById("icon");

    // Toggle dark theme when the icon is clicked
    icon.onclick = function () {
        document.body.classList.toggle("dark-theme");

        // Send an AJAX request to PHP to update the session theme
        var theme = document.body.classList.contains("dark-theme") ? "dark" : "light";


        fetch("../Controller/update_theme.php", {
            method: "POST", // Specify the HTTP method
            headers: {
                "Content-Type": "application/json" // Set the Content-Type header to JSON
            },
            body: JSON.stringify({ theme: theme }) // Send the theme as a JSON string
        })
            .then(res => res.json()) // Parse the JSON response from the server
            .then(response => {
                console.log(response); // Log the server response
            })
            .catch(error => {
                console.error("Error:", error); // Handle any errors
            });


        // Update the icon image based on the theme
        if (document.body.classList.contains("dark-theme")) {
            icon.src = "../Assets/Images/sun.png";
        } else {
            icon.src = "../Assets/Images/moon.png";
        }
    };

    // On page load, check the session and set the theme
    <?php
    if (isset($_SESSION['theme']) && $_SESSION['theme'] == "dark") {
        echo "document.body.classList.add('dark-theme');";
        echo "icon.src = '../Assets/Images/sun.png';";
    } else {
        echo "document.body.classList.remove('dark-theme');";
        echo "icon.src = '../Assets/Images/moon.png';";
    }
    ?>
</script>