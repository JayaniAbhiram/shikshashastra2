<!DOCTYPE html>
<?php
include('connect.php');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
error_reporting(0);
$un = $_GET['un'];
$sp = $_GET['sp'];
$em = $_GET['em'];
$df = $_GET['df'];
$pw = $_GET['pw'];
$st = $_GET['st']; // Get state
$ct = $_GET['ct']; // Get city
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Community</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function populateCities() {
            const stateCities = {
                "Andhra Pradesh": ["Visakhapatnam", "Vijayawada", "Guntur", "Nellore", "Tirupati"],
                "Arunachal Pradesh": ["Itanagar", "Naharlagun", "Pasighat", "Tawang", "Ziro"],
                "Assam": ["Guwahati", "Silchar", "Dibrugarh", "Jorhat", "Tezpur"],
                "Bihar": ["Patna", "Gaya", "Bhagalpur", "Muzaffarpur", "Darbhanga"],
                "Chhattisgarh": ["Raipur", "Bilaspur", "Korba", "Durg", "Rajnandgaon"],
                "Goa": ["Panaji", "Margao", "Vasco da Gama", "Mapusa", "Ponda"],
                "Gujarat": ["Ahmedabad", "Vadodara", "Surat", "Rajkot", "Gandhinagar"],
                "Haryana": ["Chandigarh", "Gurugram", "Faridabad", "Karnal", "Ambala"],
                "Himachal Pradesh": ["Shimla", "Dharamshala", "Manali", "Kullu", "Solan"],
                "Jharkhand": ["Ranchi", "Jamshedpur", "Dhanbad", "Bokaro", "Deoghar"],
                "Karnataka": ["Bengaluru", "Mysore", "Hubli", "Mangalore", "Belgaum"],
                "Kerala": ["Thiruvananthapuram", "Kochi", "Kozhikode", "Kollam", "Kannur"],
                "Madhya Pradesh": ["Bhopal", "Indore", "Jabalpur", "Gwalior", "Ujjain"],
                "Maharashtra": ["Mumbai", "Pune", "Nagpur", "Thane", "Nashik"],
                "Manipur": ["Imphal", "Churachandpur", "Thoubal", "Jiribam", "Ukhrul"],
                "Meghalaya": ["Shillong", "Tura", "Jowai", "Bajengdoba", "Williamnagar"],
                "Mizoram": ["Aizawl", "Lunglei", "Champhai", "Kolasib", "Serchhip"],
                "Nagaland": ["Kohima", "Dimapur", "Wokha", "Mokokchung", "Tuensang"],
                "Odisha": ["Bhubaneswar", "Cuttack", "Rourkela", "Sambalpur", "Berhampur"],
                "Punjab": ["Chandigarh", "Amritsar", "Ludhiana", "Jalandhar", "Patiala"],
                "Rajasthan": ["Jaipur", "Udaipur", "Jodhpur", "Kota", "Bikaner"],
                "Sikkim": ["Gangtok", "Namchi", "Pelling", "Mangan", "Rongli"],
                "Tamil Nadu": ["Chennai", "Coimbatore", "Madurai", "Salem", "Tiruchirappalli"],
                "Telangana": ["Hyderabad", "Warangal", "Nizamabad", "Karimnagar", "Khammam"],
                "Tripura": ["Agartala", "Udaipur", "Kailasahar", "Dharmanagar", "Belonia"],
                "Uttar Pradesh": ["Lucknow", "Kanpur", "Agra", "Varanasi", "Meerut"],
                "Uttarakhand": ["Dehradun", "Haridwar", "Rishikesh", "Nainital", "Roorkee"],
                "West Bengal": ["Kolkata", "Howrah", "Durgapur", "Siliguri", "Asansol"]
            };

            const stateSelect = document.getElementById("state");
            const citySelect = document.getElementById("city");
            const selectedState = stateSelect.value;

            citySelect.innerHTML = '<option value="" disabled selected>Select City</option>';

            if (stateCities[selectedState]) {
                stateCities[selectedState].forEach(function (city) {
                    const option = document.createElement("option");
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
            }
        }

        window.onload = function() {
            populateCities();
            document.getElementById("state").value = "<?php echo $st; ?>";
            populateCities();
            document.getElementById("city").value = "<?php echo $ct; ?>";
        };
    </script>
</head>

<body>
    <div class="home-content" id="list-settings">
        <div class="form-container">
            <form class="form-group" method="GET" action="update-community.php">
                <div class="form-row">
                    <div class="form-group1">
                        <label for="community">Community Name:</label>
                        <input type="text" value="<?php echo htmlspecialchars($un); ?>" class="form-control" name="community">
                    </div>
                    <div class="form-group1">
                        <label for="special">Specialization:</label>
                        <select name="special" class="form-control" id="special">
                            <option value="" disabled>Select Specialization</option>
                            <option value="Primary" <?php if ($sp === "Primary") echo "selected"; ?>>Primary</option>
                            <option value="Secondary" <?php if ($sp === "Secondary") echo "selected"; ?>>Secondary</option>
                            <option value="Senior_Secondary" <?php if ($sp === "Senior_Secondary") echo "selected"; ?>>Senior Secondary</option>
                            <option value="Undergraduation - Science" <?php if ($sp === "Undergraduation - Science") echo "selected"; ?>>Undergraduation - Science</option>
                            <option value="Undergraduation - Commerce" <?php if ($sp === "Undergraduation - Commerce") echo "selected"; ?>>Undergraduation - Commerce</option>
                            <option value="Undergraduation - Arts" <?php if ($sp === "Undergraduation - Arts") echo "selected"; ?>>Undergraduation - Arts</option>
                        </select>
                    </div>
                </div>
                <div class="form-group1">
                    <label for="demail">Email ID:</label>
                    <input type="email" value="<?php echo htmlspecialchars($em); ?>" class="form-control" name="demail" id="demail">
                </div>
                <div class="form-row">
                    <div class="form-group1">
                        <label for="dpassword">Password:</label>
                        <input type="text" value="<?php echo htmlspecialchars($pw); ?>" class="form-control" name="dpassword" id="dpassword">
                    </div>
                </div>
                <div class="form-group1">
                    <label for="comPoints">Consultancy Fees:</label>
                    <input type="text" value="<?php echo htmlspecialchars($df); ?>" class="form-control" name="comPoints" id="comPoints">
                </div>
                <div class="form-row">
                    <div class="form-group1">
                        <label for="state">State:</label>
                        <select class="form-control" name="state" id="state" onchange="populateCities()">
                            <option value="" disabled selected>Select State</option>
                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                            <option value="Assam">Assam</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Goa">Goa</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Manipur">Manipur</option>
                            <option value="Meghalaya">Meghalaya</option>
                            <option value="Mizoram">Mizoram</option>
                            <option value="Nagaland">Nagaland</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Sikkim">Sikkim</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Telangana">Telangana</option>
                            <option value="Tripura">Tripura</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Uttarakhand">Uttarakhand</option>
                            <option value="West Bengal">West Bengal</option>
                        </select>
                    </div>

                    <div class="form-group1">
                        <label for="city">City:</label>
                        <select class="form-control" name="city" id="city">
                            <option value="" disabled selected>Select City</option>
                        </select>
                    </div>
                </div>
                <div class="form-group1">
                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
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
    $state = $_GET['state'];
    $city = $_GET['city'];

    $query = "UPDATE community SET username='$community', password='$password', email='$demail', spec='$special', comPoints='$comPoints', state='$state', city='$city' WHERE email='$demail'";
    $data = mysqli_query($con, $query);

    if ($data) {
        echo "<script>alert('Details updated successfully');window.location.href = 'admin-panel.php#list-settings1';</script>";
    } else {
        echo "Failed to update details: " . mysqli_error($con);
    }
}
?>
