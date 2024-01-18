<?php
    session_start();
    if (!isset($_SESSION['logged_in'])) {
        header('Location: login.php');
        exit();
    }
    $urlid = $_GET['id'];
    if($urlid!=$_SESSION['login_id'])
    {
    header('Location: login.php');
        exit();
    }
?>
<?php
    if((isset($_GET['msg'])) && $_GET['msg']=="editstudentsuccess")
    {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
            $(document).ready(function(){
                console.log("hello");
                $("#editstudentmessage").html("<h3>Student Updated Successfully</h3>").fadeIn();
                    setTimeout(function(){
                    $("#editstudentmessage").fadeOut();
                }, 3000);
                
            });
        </script>
        
        <?php
    }
?>
<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
    include("index.php");
    $id = $_GET['id'];
    // echo $id;
    include("connection.php");
    $checksql = "select * from user where (id = '$id')";
    $result = $conn->query($checksql);
    if($result->num_rows>0)
    {
        $row = $result->fetch_assoc();
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $username = $row['username'];
        $email = $row['email'];
        $mobno = $row['mobile_number'];  
        $country = $row['country'];
        $state = $row['state'];
        $city = $row['city'];
    }
    $statesql = "select * from states where (country_id = $country and id=$state)";
    $stateresult = $conn->query($statesql);
    while($row = $stateresult->fetch_assoc())
    {
        $selectedstate = $row['name'];
    }

    $citysql = "select * from cities where (state_id = $state and id=$city)";
    $cityresult = $conn->query($citysql);
    while($row = $cityresult->fetch_assoc())
    {
        $selectedcity = $row['name'];
    }
?>

<script>
      $(document).ready(function() {
      // Check if the page is being reloaded
      if (performance.navigation.type === 1) {
        // Modify the URL on page reload
        history.replaceState({}, document.title, "studentdashboard.php?id=<?php echo $id;?>");
      }
    });
    $(document).ready(function(){
        $("#title").text("Student details");
        $("#formcontainer > h2:first").text("Student Details");
        $("#formcontainer > h2:first").after("<a href='logout.php' type='button' class='btn btn-primary' id='logoutbtn' style='margin-left: 1000px;'>Logout</a>");

        // $("#formcontainer > h2:first").after("<div style='text-align:center' id='editstudentmessage' class='text-success'>hello</div>");
        $("#radio-btn").hide();
        $(".pwd").hide();
        $(".cnfpwd").hide();
        $("#signinmsg").hide();
        $("#fname").attr('value','<?php echo $firstname; ?>');
        $("#lname").attr('value','<?php echo $lastname; ?>');
        $("#uname").attr('value','<?php echo $username; ?>');
        $("#email").attr('value','<?php echo $email; ?>');
        $("#number").attr('value',<?php echo $mobno;?>);
        $("#submitbtn1").hide();
        // $("#country-dropdown").hide();
        $("#state-dropdown").show();
        $("#city-dropdown").show();
        

        $("#country-dropdown option[value='<?php echo $country;?>']").attr('selected', true);

        var selectedstate = <?php echo json_encode($selectedstate); ?>;
        var state = <?php echo json_encode($state); ?>;
        $("#state-dropdown").append('<option value="' + state + '">' + selectedstate + '</option>')
        $("#state-dropdown option[value='" + state + "']").attr('selected', true); 

        var selectedcity = <?php echo json_encode($selectedcity); ?>;
        var city = <?php echo json_encode($city); ?>;

        $("#city-dropdown").append('<option value="' + city + '">' + selectedcity + '</option>')
        $("#city-dropdown option[value='" + city + "']").attr('selected', true); 
        
        $("#country-dropdown").prop('disabled', true);
        $("#state-dropdown").prop('disabled', true);
        $("#city-dropdown").prop('disabled', true);

        $("#country-label").prop('hidden', false);
        $("#state-label").prop('hidden', false);
        $("#city-label").prop('hidden', false);

        $("input").prop('disabled', true);
        $("#editstudentbtn").prop('hidden', false);
        $("#editstudentbtn").on("click", function(){
            $("#title").text("Edit Student");
            $("#formcontainer > h2:first").text("Edit Student Details");
            $("#editstudentbtn").prop('hidden', true);
            $("input").prop('disabled', false);
            $("#submitstudentbtn").prop('hidden', false);
            $("#country-dropdown").prop('disabled', false);
            $("#state-dropdown").prop('disabled', false);
            $("#city-dropdown").prop('disabled', false);
        });
        $('#submitstudentbtn').on("click", function(){

            // console.log("working");
            
            $('.formaction').attr('action', 'editstudent.php?id=<?php echo $id;?>&msg=editstudentsuccess');
            $(".formaction").submit();
        });
        

        // $("#submitstudentbtn").after("<a href='logout.php' type='button' class='btn btn-primary' id='logoutbtn'>Logout</a>")


    });


</script>