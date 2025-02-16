<?php
session_start();
if (isset($_SESSION['email'])) {
    header("location:Index.php");

}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            /* background-color: #1d1a1a; */
            padding: 20px;

        }


        .login-container {
            /* height: calc(30vh + 10vh ); */
            background-color: #ffffff;
            max-width: calc(30% + 5vh);
            margin: 20vh auto auto auto;
            
            /* padding: 20px; */
            /* border-radius: 4px; */
            /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
            padding: 15px 40px;
            border: none;
            outline: none;
            color: white;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 12px;
        }
        .login-container::after {
            content: "";
            z-index: -1;
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: black;
            left: 0;
            top: 0;
            border-radius: 10px;
        }
        .login-container::before {
            content: "";
            background: linear-gradient(45deg,
                    #FF0000, #FF7300, #fffb00, #48ff00,
                    #00ffd5, #002bff, #ff00c8, #ff0000);
            position: absolute;
            top: -2px;
            left: -2px;
            background-size: 600%;
            z-index: -1;
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            filter: blur(60px);
            animation: glowing 20s linear infinite;
            transition: opacity .3s ease-in-out;
            border-radius: 10px;
            opacity: 1;
        }
        @keyframes glowing {
            0% {
                background-position: 0 0;
            }

            50% {
                background-position: 400% 0;
            }

            100% {
                background-position: 0 0;
            }
        }
        .login-container h2 {
            text-align: center;
            color:rgb(255, 255, 255);
        }

        .login-container input[type="email"],
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 85%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #cccccc;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .login-container p {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="../Controller/AuthController.php" method="post">
            <div style="display:flex;justify-content:center;align-items:center">
                <input type="text" name="email" placeholder="email" required>
            </div>
            <div style="display:flex;justify-content:center;align-items:center">
                <input type="password" width="100%" name="password" id="password" placeholder="Password" required>
                <div style="display:flex;justify-content:center;align-items:center;">
                    <span id="span" style="color:black;position:absolute;margin-right:50px;margin-bottom:8px"
                        onclick="show()">Show</span>
                </div>
            </div>
            <div style="display:flex;justify-content:center;align-items:center">
                <input class="btn btn-success" style="width:50%" id="submit" name="login" type="submit" value="Log In">
            </div>
        </form>
        <p>Don't have an account? <a style="text-decoration:none" href="signup.php">Sign up</a></p>
    </div>
</body>

</html>
<script>
    function show() {
        var input = document.getElementById('password')
        var span = document.getElementById('span').innerHTML
        console.log(span)
        if (span == 'Show') {
            input.type = "text";
            document.getElementById('span').innerHTML = "Hide"
        }
        else {
            input.type = "password";
            document.getElementById('span').innerHTML = "Show"
        }
    }
</script>