<!DOCTYPE html>

<?php
$con = mysqli_connect("localhost", "root", "", "checkss");
include('newfunction.php');

if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['docsub'])) {
  $community = $_POST['community'];
  $dpassword = $_POST['dpassword'];
  $demail = $_POST['demail'];
  $spec = $_POST['special'];
  // $comPoints = $_POST['comPoints'];

  // Check if the community already exists
  $checkQuery = "SELECT * FROM community WHERE username='$community' OR email='$demail'";
  $checkResult = mysqli_query($con, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    header("Location: error3.php");
    exit();
  }

  // Insert the new community
  $query = "INSERT INTO community(username, password, email, spec) VALUES('$community', '$dpassword', '$demail', '$spec')";
  $result = mysqli_query($con, $query);

  if ($result) {
    // echo "<script>alert('Community added successfully!');</script>";
    echo "<script>alert('Community added Succesfully.');
              window.location.href = 'admin-panel.php';</script>";
  }
}
function isAccepted($id)
{
    global $con;
    $query = "SELECT * FROM book WHERE AppID = '$id' AND communityStatus=0";
    $result = mysqli_query($con, $query);
    return mysqli_num_rows($result) > 0;
}

// Function to check if the book is cancelled
function isCancelled($id)
{
    global $con;
    $query = "SELECT * FROM book WHERE AppID = '$id' AND userStatus = 0";
    $result = mysqli_query($con, $query);
    return mysqli_num_rows($result) > 0;
}

// For reload problem after form submission 19-29
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//   $_SESSION['form_data'] = $_POST;
//   header("Location: admin-panel.php");
//   exit();
// }
// if (isset($_SESSION['form_data'])) {
//   $form_data = $_SESSION['form_data'];
//   unset($_SESSION['form_data']);
// }
// Till here

// function validateEmail($email)
// {
//   if (empty($email)) {
//     return "Please enter the community's email address.";
//   }
//   return "";
// }
// if (isset($_POST['docsub1'])) {
//   $demail = $_POST['demail'];

//   $errors = array();

//   // Validate email
//   $emailError = validateEmail($demail);
//   if (!empty($emailError)) {
//     $errors[] = $emailError;
//   }

//   if (count($errors) === 0) {
//     $query = "select * from community where email='$demail';";
//     $result = mysqli_query($con, $query);

//     if ($result && mysqli_num_rows($result) > 0) {
//       $deleteQuery = "delete from community where email='$demail';";
//       $deleteResult = mysqli_query($con, $deleteQuery);

//       if ($deleteResult) {
//         echo "<script>alert('Community removed successfully!'); window.location.href = 'admin-panel.php#list-settings1';</script>";
//       } else {
//         echo "<script>alert('Unable to delete the community.'); window.location.href = 'admin-panel.php#list-settings1';</script>";
//       }
//     } else {
//       echo "<script>alert('Community with the provided email does not exist.');window.location.href = 'admin-panel.php#list-settings1';</script>";
//     }
//   } else {
//     $errorString = implode("\\n", $errors);
//     echo "<script>alert('$errorString'); window.location.href = 'admin-panel.php#list-settings1';</script>";
//   }
// }
mysqli_close($con);
?>
<script>
  function validateCommunityForm() {
    var community = document.getElementsByName("community")[0].value;
    var dpassword = document.getElementsByName("dpassword")[0].value;
    var cdpassword = document.getElementsByName("cdpassword")[0].value;
    var demail = document.getElementsByName("demail")[0].value;
    var spec = document.getElementsByName("special")[0].value;
    var comPoints = document.getElementsByName("comPoints")[0].value;

    if (community === "" || dpassword === "" || cdpassword === "" || demail === "" || spec === "" || comPoints === "") {
      alert("All details must be included.");
      return false; // Prevent form submission
    }

    // Check email format using a regular expression
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(demail)) {
      alert("Please enter a valid email address.");
      return false; // Prevent form submission
    }

    if (dpassword !== cdpassword) {
      alert("Passwords do not match.");
      return false; // Prevent form submission
    }
    if (isNaN(comPoints)) {
      alert("Consultancy Fees must be a numerical value.");
      return false; // Prevent form submission
    }

    // Check if Consultancy Fees contains only numbers
    if (!/^[0-9]+$/.test(comPoints)) {
      alert("Consultancy Fees must contain only numbers.");
      return false; // Prevent form submission
    }
    return true; // Form is valid and can be submitted
  }
  if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
function validateDeleteCommunityForm() {
  var email = document.getElementsByName('demail')[0].value;
  
  if (email.trim() === '') {
    alert('Please enter the community\'s email address.');
    return false; // Prevent form submission
  }
  
  // Rest of your validation logic
  // ...
}
</script>
<html lang="en" dir="ltr">

<head>
  <script src="https://kit.fontawesome.com/2323653b3c.js" crossorigin="anonymous"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- <link rel="stylesheet" href="style_3.css"> -->
  <link rel="stylesheet" href="admin_style.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/boxicons/2.0.7/css/boxicons.min.css">

</head>

<body style="background-color:red;">
  <!-- dashboard -->
  <div class="sidebar">
    <div class="logo-details">
      <!-- <i class='bx bx-plus-medical'></i> -->
      <i class='bx bx-book'></i>

      <span class="logo_name"><a href="#"> Shiksha Shastra</a></span>
    </div>
    <ul class="nav-links">
      <li>
        <a class="active" href="#list-dash">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="#list-doc" id="list-doc-list">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">Communities list</span>
        </a>
      </li>
      <li>
        <a href="#list-pat" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">Volunteers list</span>
        </a>
      </li>
      <li>
        <a href="#list-app" id="list-app-list" role="tab" data-toggle="list" aria-controls="home">
          <i class='bx bx-detail'></i>
          <span class="links_name">Booking Details</span>
        </a>
      </li>
      <li>
        <a href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">
          <i class='bx bx-table'></i>
          <span class="links_name">Feedback details</span>
        </a>
      </li>
      <li>
        <a href="#list-settings" id="list-adoc-list" role="tab" data-toggle="list" aria-controls="home">
          <i class='bx bxs-book-add'></i>
          <span class="links_name">Add Communitiy</span>
        </a>
      </li>
      <!-- <li>
        <a href="volunteerDetailsDocuments.php" id="list-adoc-list" role="tab" data-toggle="list" aria-controls="home">
          <i class='bx bxs-book-add'></i>
          <span class="links_name">view volunteer documents</span>
        </a>
      </li> -->
      

      
      <button style="margin-left:50px;"><a href="volunteerDetailsDocuments.php">view Documents</button>
      <li class="log_out">
        <a href="logout.php" onclick="logout()">
          <i class='bx bx-log-out'></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <!-- sections  -->
  <div class="section-container" id="sections">
    <!-- navbar -->
    <nav>
      <div class="welcome">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="admin">Welcome Admin</span>
      </div>
    </nav>
    <!-- Default contents and also dashboard contents -->
    <div class="home-content" id="list-dash" style="background-image: url(img/bg_image.jpg);">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <span class="fa-stack fa-2x">
              <i class="fa fa-square fa-stack-2x text-primary"></i>
              <i class="fa fa-users fa-stack-1x fa-inverse"></i>
            </span>
            <h4> Communitis List</h4>
            <script>
              function clickDiv(id) {
                document.querySelector(id).click();
              }
            </script>
            <p class="links cl-effect-1">
              <a href="#list-doc" onclick="clickDiv('#list-doc-list')">
                View Communities
              </a>
            </p>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <span class="fa-stack fa-2x">
              <i class="fa fa-square fa-stack-2x text-primary"></i>
              <i class="fa fa-users fa-stack-1x fa-inverse"></i>
            </span>
            <h4>Volunteers List</h4>

            <p class="cl-effect-1">
              <a href="#app-hist" onclick="clickDiv('#list-pat-list')">
                View Volunteers
              </a>
            </p>
            
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <span class="fa-stack fa-2x">
              <i class="fa fa-square fa-stack-2x text-primary"></i>
              <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i>
            </span>
            <h4>Booking Details</h4>

            <p class="cl-effect-1">
              <a href="#app-hist" onclick="clickDiv('#list-app-list')">
                View Bookings
              </a>
            </p>
          </div>
        </div>

      </div>
      
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <span class="fa-stack fa-2x">
              <i class="fa fa-square fa-stack-2x text-primary"></i>
              <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i>
            </span>
            <h4>Feedback List</h4>

            <p>
              <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                View Feedbacks
              </a>
            </p>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <span class="fa-stack fa-2x">
              <i class="fa fa-square fa-stack-2x text-primary"></i>
              <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
            </span>
            <h4>Manage Communities</h4>

            <p>
              <a href="#app-hist" onclick="clickDiv('#list-adoc-list')">Add Community</a>
              &nbsp|<a href="#list-doc" onclick="clickDiv('#list-doc-list')">Delete & Edit Community</a>
            </p>
          </div>
        </div>
      </div>
    </div>
    <!-- Community List contents-->
    <div class="home-content" id="list-doc">
      <div>
        <form class="form-group" action="communitysearch.php" method="post">
          <div class="dsearch">
            <div class="email-field">
              <input type="text" name="community_contact" placeholder="Enter Email ID" class="form-control">
            </div>
            <div class="submit-btn">
              <input type="submit" name="community_search_submit" class="btn btn-primary" value="Search">
            </div>
          </div>
        </form>
      </div>
      <div class="table-container">
      <table class="community-table">
        
        
        <thead>
          <tr>
            <th scope="col">Community Name</th>
            <th scope="col">Specialization</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <!-- <th scope="col">Feedback</th> -->
            <th scope="col">Manage Communities</th>
          </tr>
        </thead>
        <tbody>
          <!-- Table rows with dynamic data -->
          <?php
          $con = mysqli_connect("localhost", "root", "", "checkss");
          global $con;
          $query = "select * from community";
          $result = mysqli_query($con, $query);
          while ($row = mysqli_fetch_array($result)) {
            // $username = $row['username'];
            // $spec = $row['spec'];
            // $email = $row['email'];
            // $password = $row['password'];
            // $comPoints = $row['comPoints'];
            echo "
          <tr>
          <td>".$row['username']."</td>
          <td>".$row['spec']."</td>
          <td>".$row['email']."</td>
          <td>".$row['password']."</td>
          
          <td><a href='update-community.php?un=$row[username]&sp=$row[spec]&em=$row[email]& pw=$row[password]'><input type='submit' value='update' class='btn btn-primary'>
          <a href='delete-community.php? email=$row[email]'><input type='submit' value='DELETE' class='btn btn-primary'></td>
        </tr>";
          }
          // &pw=$row[password]
          ?>
        </tbody>
        
      </table>
        </div>
    </div>
    <!-- List volunteers section  -->
    <div class="home-content" id="list-pat">
      <div>
        <form class="form-group" action="volunteersearch.php" method="post">
          <div class="psearch">
            <div class="email-field">
              <input type="text" name="volunteer_contact" placeholder="Enter Contact" class="form-control">
            </div>
            <div class="submit-btn">
              <input type="submit" name="volunteer_search_submit" class="btn btn-primary" value="Search">
            </div>
          </div>
        </form>
      </div>
      <div class="table-container">
    
      <table class="volunteer">
        
        <thead>
          <tr>
            <th scope="col">Volunteer Id</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Email</th>
            <th scope="col">Contact</th>
            <!-- <th scope="col">Password</th> -->
          </tr>
        </thead>
        
        <tbody>
          <!-- Table rows with dynamic data -->
          <?php
          $con = mysqli_connect("localhost", "root", "", "checkss");
          global $con;
          $query = "select * from volunteer";
          $result = mysqli_query($con, $query);
          while ($row = mysqli_fetch_array($result)) {
            $pid = $row['pid'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $gender = $row['gender'];
            $email = $row['email'];
            $contact = $row['contact'];
            $password = $row['password'];

            echo "<tr>
            <td>$pid</td>
            <td>$fname</td>
            <td>$lname</td>
            <td>$gender</td>
            <td>$email</td>
            <td>$contact</td>
          </tr>";
          }

          ?>
        </tbody>
       
        
      </table>
      
        </div>
      <br>
    </div>
    <!-- List Bookings section -->
    <div class="home-content" id="list-app">
      <div>
        <form class="form-group" action="appsearch.php" method="post">
          <div class="appsearch">
            <div class="email-field">
              <input type="text" name="app_contact" placeholder="Enter Contact" class="form-control">
            </div>
            <div class="submit-btn"><input type="submit" name="app_search_submit" class="btn btn-primary" value="Search">
            </div>
          </div>
        </form>
      </div>
      <div class="table-container">
      <table class="app-table">
       
        <thead>
          <tr>
            <th scope="col">Booking ID</th>
            <th scope="col">Volunteer ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Email</th>
            <th scope="col">Contact</th>
            <th scope="col">Community Name</th>
            <!-- <th scope="col">Feedback</th> -->
            <th scope="col">Booking Date</th>
            <th scope="col">Booking Time</th>
            <th scope="col">Booking Status</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $con = mysqli_connect("localhost", "root", "", "checkss");
          global $con;

          $query = "select * from book;";
          $result = mysqli_query($con, $query);
          while ($row = mysqli_fetch_array($result)) {
            $id = $row['AppID'];
            $accepted = isAccepted($id);
            $cancelled = isCancelled($id);
        ?>
            <tr>
                <td><?php echo $row['AppID']; ?></td>
                <td><?php echo $row['pid']; ?></td>
                      <td><?php echo $row['fname']; ?></td>
                      <td><?php echo $row['lname']; ?></td>
                      <td><?php echo $row['gender']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td><?php echo $row['contact']; ?></td>
                      <td><?php echo $row['community']; ?></td>
                      
                      <td><?php echo $row['appdate']; ?></td>
                      <td><?php echo $row['apptime']; ?></td>
                <td>
                    <?php
                    if ($cancelled) {
                        echo "Cancelled";
                    } elseif ($accepted) {
                        echo "Accepted";
                    } else {
                        echo "Active";
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
                  
      </table>
                  </div>
      <br>
    </div>
    <!-- feedback list contents-->
    <div class="home-content" id="list-pres">

      <div>
      <div class="table-container">

        <table class="pres-table">
          
          <thead>
            <tr>
              <th scope="col">Community</th>
              <th scope="col">Volunteer ID</th>
              <th scope="col">Booking ID</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Booking Date</th>
              <th scope="col">Booking Time</th>
              <th scope="col">Points</th>
              <!-- <th scope="col">feedpoints</th> -->
              <th scope="col">Remarks</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $con = mysqli_connect("localhost", "root", "", "checkss");
            global $con;
            $query = "select * from feedback";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
              $community = $row['community'];
              $pid = $row['pid'];
              $AppID = $row['AppID'];
              $fname = $row['fname'];
              $lname = $row['lname'];
              $appdate = $row['appdate'];
              $apptime = $row['apptime'];
              // $disease = $row['disease'];
              $feedpoints = $row['feedpoints'];
              $pres = $row['feedback'];


              echo "<tr>
            <td>$community</td>
            <td>$pid</td>
            <td>$AppID</td>
            <td>$fname</td>
            <td>$lname</td>
            <td>$appdate</td>
            <td>$apptime</td>
            
            <td>$feedpoints</td>
            <td>$pres</td>
          </tr>";
            }

            ?>
          </tbody>
          
        </table>
          </div>
        <br>
      </div>
    </div>
    <!-- Add community section -->
    <div class="home-content" id="list-settings">
      <div class="form-container">
        <form class="form-group" method="post" action="admin-panel.php" onsubmit="return validateCommunityForm();">
          <div class="form-row">
            <div class="form-group1">
              <label for="community">Community Name:</label>
              <input type="text" class="form-control" name="community" onkeydown="return alphaOnly(event);">
            </div>
            <div class="form-group1">
              <label for="special">Specialization:</label>
              <select name="special" class="form-control" id="special">
                <option value="" disabled selected>Select Specialization</option>
                <option value="Primary">Primary</option>
                <option value="Secondary - Education">Secondary</option>
                <option value="Senior_Secondary">Senior Secondary</option>
                <option value="Undergraduation - Science">Undergraduation - Science</option>
                <option value="Under_graduation - Commerce">Undergraduation - Commerce</option>
                <option value=".UnderGraduation - Arts">UnderGraduation - Arts</option>
                <!-- <option value="Gate">Gate</option>
                <option value="C_Programming">C Programming</option>
                <option value="Web_Development">Web Development</option>
                <option value="Dynamic_Programming">Dynamic Programming</option> -->
              </select>
            </div>
          </div>
          <div class="form-group1">
            <label for="demail">Email ID:</label>
            <input type="email" class="form-control" name="demail" id="demail">
          </div>
          <div class="form-row">
            <div class="form-group1">
              <label for="dpassword">Password:</label>
              <input type="password" class="form-control" name="dpassword" id="dpassword">
            </div>
            <div class="form-group1">
              <label for="cdpassword">Confirm Password:</label>
              <input type="password" class="form-control" name="cdpassword" id="cdpassword">
            </div>
          </div>
          <!-- <div class="form-group1">
            <label for="comPoints">Feedback</label>
            <input type="text" class="form-control" name="comPoints" id="comPoints">
          </div> -->
          <div class="form-group1">
            <button type="submit" name="docsub" class="btn btn-primary">Add Community</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- <script>
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".sidebarBtn");
  sidebarBtn.onclick = function() {
    sidebar.classList.toggle("active");
    if (sidebar.classList.contains("active")) {
      sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
    } else
      sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
  }
</script> -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const sidebarBtn = document.querySelector(".sidebarBtn");
      const sidebar = document.querySelector(".sidebar");
      const sections = document.querySelector("#sections");
      const links = document.querySelectorAll(".nav-links li a");
      // Show the dashboard section by default
      document.getElementById("list-dash").style.display = "block";
      document.getElementById("list-doc").style.display = "none";
      document.querySelector(".nav-links li a.active").classList.remove("active");
      document.querySelector(".nav-links li a[href='#list-dash']").classList.add("active");

      // Hide other sections when the page loads
      document.querySelectorAll(".home-content").forEach(function(section) {
        if (section.id !== "list-dash") {
          section.style.display = "none";
        }
      });

      // Toggle sidebar
      sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else {
          sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
      };

      // Handle click events for navigation links
      links.forEach(function(link) {
        link.addEventListener("click", function(event) {
          event.preventDefault();
          const targetSection = document.querySelector(this.getAttribute("href"));
          sections.querySelectorAll(".home-content").forEach(function(section) {
            section.style.display = "none";
          });
          targetSection.style.display = "block";
          document.querySelector(".nav-links li a.active").classList.remove("active");
          this.classList.add("active");
        });
      });
    });
    // logout button code
    function logout() {
      event.preventDefault();
      window.location.href = "logout.php"; // Redirect to logout.php
    }
    // default page contents js
    function clickDiv(id) {
      document.querySelector(id).click();
    }
  </script>

  



</body>

</html>