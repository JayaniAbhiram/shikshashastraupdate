<!DOCTYPE html>
<?php
include ('connect.php');
?>
<?php
// $con = mysqli_connect("localhost", "root", "", "checkss");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
error_reporting(0);
$un = $_GET['un'];
$sp = $_GET['sp'];
$em = $_GET['em'];
$df = $_GET['df'];
$pw = $_GET['pw'];
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="home-content" id="list-settings">
        <div class="form-container">
            <form class="form-group" method="GET" action="update-community.php">
                <div class="form-row">
                    <div class="form-group1">
                        <label for="community">Community Name:</label>
                        <input type="text" value="<?php echo "$un" ?>" class="form-control" name="community">
                    </div>
                    <div class="form-group1">
                        <label for="special">Specialization:</label>
                        <select name="special" class="form-control" id="special">
                            <option value="" disabled>Select Specialization</option>
                            <option value="Primary" <?php if ($sp === "Primary") echo "selected"; ?>>Primary</option>
                            <option value="Secondary" <?php if ($sp === "Secondary") echo "selected"; ?>>Secondary</option>
                            <option value="Senior_Secondary" <?php if ($sp === "Senior_Secondary") echo "selected"; ?>>Senior Secondary</option>
                            <option value="Undergraduation - Science" <?php if ($sp === "Undergraduation - Science") echo "selected"; ?>>Undergraduation - Science</option>
                            <option value="Undergraduation - Commerce" <?php if ($sp === "Undergraduation - Commerse") echo "selected"; ?>>Undergraduation - Commerce</option>
                            <option value="Undergraduation - Arts" <?php if ($sp === "Undergraduation - Arts") echo "selected"; ?>>Undergraduation - Arts</option>
                            <!-- <option value="Gate" <?php if ($sp === "Gate") echo "selected"; ?>>Gate</option> -->
                            <!-- <option value="C_Programming" <?php if ($sp === "C_Programming") echo "selected"; ?>>C Programming</option>
                            <option value="Web_Development" <?php if ($sp === "Web_Development") echo "selected"; ?>>Web Development</option>
                            <option value="Dynamic_Programming" <?php if ($sp === "Dynamic_Programming") echo "selected"; ?>>Dynamic Programming</option> -->
                        </select>
                    </div>
                </div>
                <div class="form-group1">
                    <label for="demail">Email ID:</label>
                    <input type="email" value="<?php echo "$em" ?>" class="form-control" name="demail" id="demail">
                </div>
                <div class="form-row">
                    <div class="form-group1">
                        <label for="dpassword">Password:</label>
                        <input type="text" value="<?php echo "$pw" ?>" class="form-control" name="dpassword" id="dpassword">
                    </div>
                </div>
                <div class="form-group1">
                    <label for="comPoints">Consultancy Fees:</label>
                    <input type="text" value="<?php echo "$df" ?>" class="form-control" name="comPoints" id="comPoints">
                </div>
                <div class="form-group1">
                    <button type="docsub" name="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php
if (isset($_GET['submit'])) {
    $community = $_GET['community'];
    $password = $_GET['dpassword'];
    $demail = $_GET['demail'];
    $special = $_GET['special'];
    $comPoints = $_GET['comPoints'];

    $query = "UPDATE community SET username='$community',password='$password',email='$demail',spec='$special', comPoints='$comPoints' WHERE email='$demail'";
    $data = mysqli_query($con, $query);

    if ($data) {
        echo "<script>alert('Details updated successfully');window.location.href = 'admin-panel.php#list-settings1';</script>";
    } else {
        echo "Failed to update details: " . mysqli_error($con);
    }
}
?>