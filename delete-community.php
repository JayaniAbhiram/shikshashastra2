<?php
include ('connect.php');
?>
<?php
// $con = mysqli_connect("localhost", "root", "", "checkss");
error_reporting(0);
$email=$_GET['email'];
$query= "DELETE FROM community WHERE email='$email'";

$data=mysqli_query($con, $query);
if($data){
    echo" <script>alert('Community Deleted Successfully');window.location.href = 'admin-panel.php#list-settings1';</script>";
}
else{
    echo"<script> alert('Unable to delete community');window.location.href = 'admin-panel.php#list-settings1';</script>";
}
?>