<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="style5.css">
    <link rel="stylesheet" type="text/css" href="style5_1.css">
    <title>community-login</title>
    
    <script>
        function myMenuFunction() {
            var i = document.getElementById("navMenu");

            if (i.className === "nav-menu") {
                i.className += " responsive";
            } else {
                i.className = "nav-menu";
            }
        }
        function redirectToVolunteerLogin() {
            window.location.replace("index.php"); 
            return false; // Add this line to prevent the default behavior           
        }
        function redirectToCommunityLogin() {
            window.location.replace("community-login.php");
            return false;
        }
        function redirectToAdminLogin() {
            window.location.replace("admin-login.php");
            return false;
        }
        function showForm(formId) {
            var forms = document.getElementsByClassName("register-container");
            for (var i = 0; i < forms.length; i++) {
                forms[i].style.display = "none";
            }

            var form = document.getElementById(formId);
            form.style.display = "block";
        }
    </script>
</head>

<body>

    <div class="wrapper">
        <nav class="nav" style="position:absolute;">
            <div class="nav-logo">
            <a href="index.php"><img src="img\logo-no-background.png" alt="" style="width:100px; margin-top:10px;">
                    <span style="width:300px;font-size:30px;">Shiksha Shastra</span>
            </div>
            <div class="nav-menu" id="navMenu">
            <ul>
                    <li><a href="index.php" class="mobile-only">Volunteer</a></li>
                    <li><a href="community-login.php" class="mobile-only">Community</a></li>
                    <li><a href="admin-login.php" class="mobile-only">Admin</a></li>
                </ul>
            </div>
            <!-- <div class="nav-button">
                <button class="btn white-btn" id="registerBtn" onclick="redirectToVolunteerLogin()">Volunteer</button>
                <button class="btn white-btn" id="registerBtn" onclick="redirectToCommunityLogin()">Community</button>
                <button class="btn white-btn" id="registerBtn" onclick="redirectToAdminLogin()">Admin</button>
            </div> -->
            <div class="nav-menu-btn">
                <i class="bx bx-menu" onclick="myMenuFunction()"></i>
            </div>
        </nav>

        <div class="register-container" id="loginCommunity">
            <div class="top">
                <header>Login as Community</header>
            </div>
            <form action="function1.php" method="POST" onsubmit="return validateCommunityForm();">
                <div class="two-forms">
                    <div class="input-box">
                        <input type="text" class="form-control" placeholder="User Name *" name="username3" />
                        <i class="bx bx-user"></i><br><br>
                    </div>
                    <div class="input-box">
                        <input type="password" class="form-control" placeholder="Password *" name="password3" />
                        <i class="bx bx-lock-alt"></i>
                    </div>
                </div>
                <div class="input-box">
                    <input type="submit" class="btnRegister" name="docsub1" value="Login" />
                </div>
            </form>

            <div style="margin-top:50px;text-align:center;">
                <p>Don't have an account ....???</p>
                <a href="contactus.php" style="display: inline-block; background-color: orange; color: black; padding: 15px 25px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;margin-top:10px;">Register here</a>
            <br>
    </div>


            <a href="joinus.php" style="display: inline-block; background-color: #4CAF50; color: white; padding: 15px 25px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 10px;margin-top:100px;margin-left:180px;">Back To Home</a>
        </div>


    </div>

</body>

</html>