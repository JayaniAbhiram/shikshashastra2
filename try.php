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

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
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
  
</body>
</html>