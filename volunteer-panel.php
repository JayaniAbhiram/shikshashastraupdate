<!DOCTYPE html>
<?php
include ('connect.php');
?>
<?php
include('function.php');
include('newfunction.php');
// $con = mysqli_connect("localhost", "root", "", "checkss");
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

$pid = $_SESSION['pid'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$fname = $_SESSION['fname'];
$gender = $_SESSION['gender'];
$lname = $_SESSION['lname'];
$contact = $_SESSION['contact'];


if (isset($_POST['app-submit'])) {
  // Check if any required field is empty
  if (empty($_POST['community']) || empty($_POST['appdate']) || empty($_POST['apptime'])) {
      echo "<script>alert('Please fill in all required fields.');</script>";
  } else {
      $pid = $_SESSION['pid'];
      $username = $_SESSION['username'];
      $fname = $_SESSION['fname'];
      $lname = $_SESSION['lname'];
      $gender = $_SESSION['gender'];
      $contact = $_SESSION['contact'];
      $community = $_POST['community'];
      $email = $_SESSION['email'];

      $appdate = $_POST['appdate'];
      $apptime = $_POST['apptime'];
      $cur_date = date("Y-m-d");
      date_default_timezone_set('Asia/Kathmandu');
      $cur_time = date("H:i:s");
      $apptime1 = strtotime($apptime);
      $appdate1 = strtotime($appdate);

      // Calculate the date one month from now
      $oneMonthFromNow = date("Y-m-d", strtotime("+1 month"));

      if ($appdate1 < strtotime($oneMonthFromNow)) {
          if (date("Y-m-d", $appdate1) >= $cur_date) {
              if ((date("Y-m-d", $appdate1) == $cur_date && date("H:i:s", $apptime1) > $cur_time) || date("Y-m-d", $appdate1) > $cur_date) {
                  $check_query = mysqli_query($con, "SELECT apptime FROM book WHERE community='$community' AND appdate='$appdate' AND apptime='$apptime' AND (userStatus='1' AND communityStatus='1')");

                  if (mysqli_num_rows($check_query) == 0) {
                      $query = mysqli_query($con, "insert into book(pid,fname,lname,gender,email,contact,community,appdate,apptime,userStatus,communityStatus) values($pid,'$fname','$lname','$gender','$email','$contact','$community','$appdate','$apptime','1','1')");

                      if ($query) {
                          echo "<script>alert('Your booking was successful.');</script>";
                      } else {
                          echo "<script>alert('Unable to process your request. Please try again!');</script>";
                      }
                  } else {
                      echo "<script>alert('We are sorry to inform that the community is not available at this time or date. Please choose a different time or date!');</script>";
                  }
              } else {
                  echo "<script>alert('Select a time or date in the future!');</script>";
              }
          } else {
              echo "<script>alert('Select a time or date in the future!');</script>";
          }
      } else {
          echo "<script>alert('Select a date within one month from now!');</script>";
      }
  }
}



if (isset($_GET['cancel'])) {
  $query = mysqli_query($con, "update book set userStatus='0' where AppID = '" . $_GET['AppID'] . "'");
  if ($query) {
    // echo "<script>alert('Your book successfully cancelled');</script>";
    echo "<script>alert('Your book was successfully cancelled.');
              window.location.href = 'volunteer-panel.php';</script>";
  }
}
function get_specs()
{
  // $con = mysqli_connect("localhost", "root", "", "checkss");
  $query = mysqli_query($con, "select username, spec from community");
  $docarray = array();
  while ($row = mysqli_fetch_assoc($query)) {
    $docarray[] = $row;
  }

  $options = '';
  foreach ($docarray as $doc) {
    $options .= '<option value="' . $doc['username'] . '">' . $doc['spec'] . '</option>';
  }

  return $options;
}
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $pwd = $_POST['password'];

  $query = "UPDATE volunteer SET password='$pwd' WHERE email='$email'";
  $data = mysqli_query($con, $query);
  if ($data) {
    echo " <script> alert('password changed')</script>";
  } else {
    echo "Failed to change password";
  }
}

// Function to check if the book is reviewed
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
?>
<script>
  function validateBookingForm() {
    var spec = document.getElementById('spec').value;
    var community = document.getElementById('community').value;
    var comPoints = document.getElementById('comPoints').value;
    var appdate = document.querySelector('[name=appdate]').value;
    var apptime = document.getElementById('apptime').value;

    if (spec === "" || community === "" || appdate === "" || apptime === "") {
      alert("Please select all required fields.");
      return false;
    }

    return true;
  }
</script>
<html lang="en">

<head>
  <script src="https://kit.fontawesome.com/2323653b3c.js" crossorigin="anonymous"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Volunteer Dashboard</title>
  <link rel="stylesheet" href="style_3.css">
  <link rel="stylesheet" href="style4_1.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <style>
    .status-reviewed {
      color: green;
      font-weight: bold;
    }

    .status-canceled {
      color: red;
      font-weight: bold;
    }
  </style>


<body>
  <!-- dashboard -->
  <div class="sidebar">
    <div class="logo-details">
      <!-- <i class='bx bx-book'></i> -->
      <img src="img/logo-no-background.png" alt="Description of the image" style="height:80px;">
      <span class="logo_name"><a href="volunteer-panel.php"> Shiksha Shastra</a></span>
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
          <span class="links_name">Book Community</span>
        </a>
      </li>
      <li>
        <a href="#list-app" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">
          <i class='bx bx-list-ul'></i>
          <span class="links_name">Past Activities</span>
        </a>
      </li>
      <li>
        <a href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">
          <i class='bx bx-detail'></i>
          <span class="links_name">Feedback</span>
        </a>
      </li>
      <li>
        <a href="#list-change-password" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">
          <i class='bx bx-detail'></i>

          <span class="links_name">Change Password</span>
        </a>
      </li>
      <li>
        <a href="#uploaddocuments" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">
          <i class='bx bx-detail'></i>

          <span class="links_name">Upload Documents</span>
        </a>
      </li>
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
        <span class="admin">
          <?php
          $greeting = " Welcome , " . $username;
          echo $greeting;
          ?>
        </span>
      </div>
    </nav>
    <!-- Default contents and dashboard contents -->
    <div class="home-content" id="list-dash">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <span class="fa-stack fa-2x">
              <i class="fa fa-square fa-stack-2x text-primary"></i>
              <i class="fa fa-users fa-stack-1x fa-inverse"></i>
            </span>
            <h4>Book My Slot</h4>

            <p class="cl-effect-1">
              <a href="#app-hist" onclick="clickDiv('#list-doc-list')">
                Book Slot
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
            <h4>My Slots</h4>

            <p class="cl-effect-1">
              <a href="#app-hist" onclick="clickDiv('#list-pat-list')">
                Past Activities
              </a>
            </p>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <span class="fa-stack fa-2x">
              <i class="fa fa-square fa-stack-2x text-primary"></i>
              <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i>
            </span>
            <h4>Feedbacks</h4>

            <p>
              <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                View Feedbacks List
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
    <!-- Book Booking section -->
    <div class="home-content" id="list-doc">
      <div class="hcontent">
        <h4>Book a Slot</h4>
        <form class="form-group" method="post" action="volunteer-panel.php" onsubmit="return validateBookingForm();">
          <div>
            <label for="spec">Specialization:</label>
          </div>
          <div class="selspec">
            <select name="spec" class="form-control" id="spec">
              <option value="" disabled selected>Select Specialization</option>
              <?php
              display_specs();
              ?>
            </select>
          </div>
          <script>
            document.getElementById('spec').onchange = function () {
              let spec = this.value;
              let docs = [...document.getElementById('community').options];

              docs.forEach((el, ind, arr) => {
                arr[ind].setAttribute("style", "");
                if (el.getAttribute("data-spec") !== spec) {
                  arr[ind].setAttribute("style", "display: none");
                }
              });

              // Reset community selection and fees when specialization changes
              document.getElementById('community').selectedIndex = 0;
              document.getElementById('comPoints').value = '';
            };

            document.getElementById('community').onchange = function () {
              var selection = document.querySelector(`[value="${this.value}"]`).getAttribute('data-value');
              document.getElementById('comPoints').value = selection;
            };
          </script>

          <div>
            <label for="community">Communiies</label>
          </div>
          <div class="sdoc">
            <select name="community" class="form-control" id="community">
              <option value="" disabled selected>Select Communites</option>

              <?php display_docs(); ?>
            </select>
          </div>
          <script>
            document.getElementById('community').onchange = function updateFees(e) {
              var selection = document.querySelector(`[value="${this.value}"]`).getAttribute('data-value');
              document.getElementById('comPoints').value = selection;
            };
          </script>
          <!-- <div>
            <label for="consultancyfees">
              Consultancy Fees
            </label>
          </div>
          <div class="Fees">
            <input class="form-control" type="text" name="comPoints" id="comPoints" readonly="readonly" />
          </div> -->
          <div>
            <label>Date</label>
          </div>
          <div class="apdate">
            <input type="date" class="form-control datepicker" name="appdate">
          </div>
          <div>
            <label>Time</label>
          </div>
          <div class="Stime">
            <select name="apptime" class="form-control" id="apptime">
              <option value="" disabled selected>Select Time</option>
              <option value="08:00:00">8:00 AM</option>
              <option value="10:00:00">10:00 AM</option>
              <option value="12:00:00">12:00 PM</option>
              <option value="14:00:00">2:00 PM</option>
              <option value="16:00:00">4:00 PM</option>
            </select>
          </div><br>
          <center>
            <div class="btn">
              <input type="submit" name="app-submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
            </div>
          </center>
        </form>
      </div>
    </div>
    <!-- Booking history section -->
    <div class="home-content" id="list-app">
      <div class="table-container">
        <table class="app-table"  >
          <thead>
            <tr>
              <th scope="col">Community Name</th>
              <!-- <th scope="col">Feedback</th> -->
              <th scope="col">Date</th>
              <th scope="col">Time</th>
              <th scope="col">Current Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody  >
            <?php
            // $con = mysqli_connect("localhost", "root", "", "checkss");
            global $con;

            $query = "SELECT AppID, community, comPoints, appdate, apptime, userStatus, communityStatus FROM book WHERE fname ='$fname' AND lname='$lname';";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_array($result)) {
              $community = $row['community'];
              $comPoints = $row['comPoints'];
              $appdate = $row['appdate'];
              $apptime = $row['apptime'];
              $userStatus = $row['userStatus'];
              $communityStatus = $row['communityStatus'];
              $AppID = $row['AppID'];

              // Check if book is reviewed or cancelled
              $accepted = isAccepted($AppID);
              $cancelled = isCancelled($AppID);
              ?>
              <tr>
                <th scope="row">
                  <?php echo $community; ?>
                </th>
                <!-- <td> -->
                  <?php 
                  // echo $comPoints; 
                  ?> 
                <!-- </td> -->
                <td>
                  <?php echo $appdate; ?>
                </td>
                <td>
                  <?php echo $apptime; ?>
                </td>
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
                <td>
                  <?php if (!$cancelled && !$accepted) { ?>
                    <a href="volunteer-panel.php?AppID=<?php echo $row['AppID'] ?>&cancel=update"
                      onClick="return confirm('Are you sure you want to cancel this book?')"
                      title="Cancel Booking">
                      <button class="btn btn-primary">Cancel</button>
                    </a>
                  <?php } ?>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>


    <!-- Prescription section -->
    <div class="home-content" id="list-pres">
      <div>

        <table class="pres-table"  >
          <thead>
            <tr>

              <th scope="col">Community Name</th>
              <th scope="col">Booking ID</th>
              <th scope="col">Booking Date</th>
              <th scope="col">Booking Time</th>
              <th scope="col">Points</th>
              <!-- <th scope="col">Points</th> -->
              <th scope="col">Remarks</th>
            </tr>
          </thead>
          <tbody  >
            <?php

            // $con = mysqli_connect("localhost", "root", "", "checkss");
            global $con;

            $query = "select community,AppID,appdate,apptime,feedpoints,feedback from feedback where pid='$pid';";

            $result = mysqli_query($con, $query);
            if (!$result) {
              echo mysqli_error($con);
            }


            while ($row = mysqli_fetch_array($result)) {
              ?>
              <tr>
                <td>
                  <?php echo $row['community']; ?>
                </td>
                <td>
                  <?php echo $row['AppID']; ?>
                </td>
                <td>
                  <?php echo $row['appdate']; ?>
                </td>
                <td>
                  <?php echo $row['apptime']; ?>
                </td>
                
                <td>
                  <?php echo $row['feedpoints']; ?>
                </td>
                <td>
                  <?php echo $row['feedback']; ?>
                </td>
                </form>


              </tr>
            <?php }
            ?>
          </tbody>
        </table>
        <br>
      </div>
    </div>
    <!-- Change Password section -->
    <div class="home-content" id="list-change-password">
      <div class="change-password-form">

        <center>
          <h4 style="font-size:30px;">Change Password</h4>
        </center>
        <form class="form-group" method="post" action="volunteer-panel.php">
          <div>
            <label for="email">Email:</label>
          </div>
          <div>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div>
            <label for="new-password">New Password:</label>
          </div>
          <div>
            <input type="password" name="password" class="form-control" required>
          </div><br>
          <div class="btn">
            <input type="submit" name="submit" value="Change Password" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>

    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>


    <div class="home-content" id="uploaddocuments">
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #e0e0e0;">
        <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 90%; max-width: 600px;">
            <h1 style="text-align: center; color: #333;">Upload Volunteer Documents</h1>
            <form action="volunteer-panel.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 15px;">
                <label for="name" style="font-weight: bold; color: #555;">Name:</label>
                <input type="text" name="name" id="name" required style="border: 1px solid #ddd; border-radius: 4px; padding: 8px;">

                <label for="gmail" style="font-weight: bold; color: #555;">Gmail:</label>
                <input type="email" name="gmail" id="gmail" required style="border: 1px solid #ddd; border-radius: 4px; padding: 8px;">

                <label for="file1" style="font-weight: bold; color: #555;">Choose File 1 (Aadhar Card):</label>
                <input type="file" name="file1" id="file1" required style="border: 1px solid #ddd; border-radius: 4px; padding: 8px;">

                <label for="file2" style="font-weight: bold; color: #555;">Choose File 2 (12th Mark Sheet):</label>
                <input type="file" name="file2" id="file2" required style="border: 1px solid #ddd; border-radius: 4px; padding: 8px;">

                <label for="file3" style="font-weight: bold; color: #555;">Choose File 3 (Graduation Certificate):</label>
                <input type="file" name="file3" id="file3" required style="border: 1px solid #ddd; border-radius: 4px; padding: 8px;">

                <button type="submit" name="upload" style="background-color: #28a745; color: #fff; border: none; border-radius: 4px; padding: 10px 20px; cursor: pointer; font-size: 16px; transition: background-color 0.3s;">
                    Upload Files
                </button>
            </form>
            <?php
            if (isset($_POST['upload'])) {
                $name = $_POST['name'];
                $gmail = $_POST['gmail'];

                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "checkss";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Check if name or gmail already exists
                $checkQuery = "SELECT id FROM volunteer_documents WHERE name = ? OR gmail = ?";
                $stmtCheck = $conn->prepare($checkQuery);
                $stmtCheck->bind_param("ss", $name, $gmail);
                $stmtCheck->execute();
                $stmtCheck->store_result();

                if ($stmtCheck->num_rows > 0) {
                    echo "<script>showAlert('Documents already uploaded with this name or Gmail.');</script>";
                } else {
                    // Directory for uploads
                    $uploadDir = 'uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    // File paths
                    $file1Path = $file2Path = $file3Path = '';

                    // File 1 upload
                    if (isset($_FILES['file1'])) {
                        $file1Path = $uploadDir . basename($_FILES['file1']['name']);
                        move_uploaded_file($_FILES['file1']['tmp_name'], $file1Path);
                    }

                    // File 2 upload
                    if (isset($_FILES['file2'])) {
                        $file2Path = $uploadDir . basename($_FILES['file2']['name']);
                        move_uploaded_file($_FILES['file2']['tmp_name'], $file2Path);
                    }

                    // File 3 upload
                    if (isset($_FILES['file3'])) {
                        $file3Path = $uploadDir . basename($_FILES['file3']['name']);
                        move_uploaded_file($_FILES['file3']['tmp_name'], $file3Path);
                    }

                    // Insert into database
                    $insertQuery = "INSERT INTO volunteer_documents (name, gmail, file1_path, file2_path, file3_path) VALUES (?, ?, ?, ?, ?)";
                    $stmtInsert = $conn->prepare($insertQuery);
                    $stmtInsert->bind_param("sssss", $name, $gmail, $file1Path, $file2Path, $file3Path);

                    // Execute and check success
                    if ($stmtInsert->execute()) {
                        echo "<script>showAlert('Documents successfully submitted and inserted into the database.');</script>";
                    } else {
                        echo "<p style='color: #dc3545; text-align: center;'>Error: " . $stmtInsert->error . "</p>";
                    }

                    $stmtInsert->close();
                }

                // Close connections
                $stmtCheck->close();
                $conn->close();
            }
            ?>
        </div>
    </div>
      
    </div>








  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
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
      document.querySelectorAll(".home-content").forEach(function (section) {
        if (section.id !== "list-dash") {
          section.style.display = "none";
        }
      });

      // Toggle sidebar
      sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else {
          sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
      };

      // Handle click events for navigation links
      links.forEach(function (link) {
        link.addEventListener("click", function (event) {
          event.preventDefault();
          const targetSection = document.querySelector(this.getAttribute("href"));
          sections.querySelectorAll(".home-content").forEach(function (section) {
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