<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once "connection.php";
$state_id = $_POST["state_id"];

$result = mysqli_query($conn,"SELECT * FROM cities where state_id = $state_id");
?>
<option value="">Select City</option>

<?php
    while($row = mysqli_fetch_array($result)) {
?>
        <option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>
<?php
    }
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $("#city-label").prop("hidden", false); 
    });
</script>