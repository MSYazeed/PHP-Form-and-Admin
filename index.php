
<!DOCTYPE HTML>  
<html>
<head>    
<link href='https://fonts.googleapis.com/css?family=Merienda' rel='stylesheet'>
<style type="text/css">
	form   { display: table;      }
	p      { display: table-row;  }
	label  { display: table-cell; 
			 width:100px;}
	span   { display: table-cell; }
	input  { display: table-cell; 
  
			 font-family: Georgia, "Times New Roman", Times, serif;
			 background: rgba(255,255,255,.1);
			 border: none;
			 border-radius: 4px;
			 font-size: 16px;
			 margin: 0;
			 outline: 0;
			 padding: 7px;
			 width: 95%;
			 box-sizing: border-box;
			 -webkit-box-sizing: border-box;
			 -moz-box-sizing: border-box;
			 background-color: #e8eeef;
			 color:#8a97a0;
			 -webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
			 box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
		   }
	input:focus{background: #d2d9dd;}
	select { display: table-cell; 
			 
			 font-family: Georgia, "Times New Roman", Times, serif;
			 background: rgba(255,255,255,.1);
			 border: none;
			 border-radius: 4px;
			 font-size: 16px;
			 margin: 0;
			 outline: 0;
			 padding: 7px;
			 width: 100%;
			 box-sizing: border-box;
			 -webkit-box-sizing: border-box;
			 -moz-box-sizing: border-box;
			 background-color: #e8eeef;
			 color:#8a97a0;
			 -webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
			 box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
	    	}
	.error { color: #FF0000;}
	input[type="submit"],
	input[type="button"]
	{
		position: relative;
		display: block;
		color: #FFF;
		margin: 0 auto;
		background: #1abc9c;
		font-size: 14px;
		text-align: center;
		font-style: normal;
		width: 100%;
		border: 1px solid #16a085;
		border-width: 1px 1px 3px;
	}
	input[type="submit"]:hover,
	input[type="button"]:hover
	{
		background: #109177;
	}
	
	body { font-family: 'Merienda'; font-size: 14px;}

</style>
</head>
<body>  
<?php

function StartConnection()
{
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$db     = "Form";
 
 
	$connection = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $connection -> error);
	
	return $connection;
}
 
function CloseConnection($connection)
{
	$connection -> close();
}

$connected = StartConnection();
if (mysqli_connect_errno($connected))
{
    echo "Failed to connect to database: " . mysqli_connect_error();
}
	
$categories_sql = mysqli_query($connected, "SELECT * FROM categories_table ORDER BY id ASC");

CloseConnection($connected);

// define variables and set to empty values
$fnameError = $lnameError = $emailError = $addressError = $success_fail = "";
$fname = $lname = $email =  $address = $category = "";
$formIsValid = True;
$posted = False;
$messageColor = "red";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $posted = True;
  if (empty($_POST["first_name"])) {
    $fnameError   = "First Name is empty";
	$success_fail = "Your request was unsuccessful. Please fill the form again and submit.";
	$formIsValid  = False;
  } 
  else {
    $fname = test_input($_POST["first_name"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
      $fnameError   = "First Name should only contain letters";
	  $success_fail = "Your request was unsuccessful. Please fill the form again and submit.";
	  $formIsValid  = False;
    }
  }
  if (empty($_POST["last_name"])) {
    $lnameError   = "Last Name is empty";
	$success_fail = "Your request was unsuccessful. Please fill the form again and submit.";
	$formIsValid  = False;
  } 
  else {
    $lname = test_input($_POST["last_name"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
      $lnameError   = "Last Name should only contain letters";
	  $success_fail = "Your request was unsuccessful. Please fill the form again and submit.";
	  $formIsValid  = False;
    }
  }
  
  if (empty($_POST["email"])) {
    $emailError   = "Email is empty";
	$success_fail = "Your request was unsuccessful. Please fill the form again and submit.";
	$formIsValid  = False;
  } 
  else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailError   = "Invalid email format";
	  $success_fail = "Your request was unsuccessful. Please fill the form again and submit.";
	  $formIsValid  = False;
    }
	else {
	  $connected  = StartConnection(); 
	  
	  if (mysqli_connect_errno($connected))
	  {
		echo "Failed to connect to database: " . mysqli_connect_error();
	  }
	  $emailCheck = mysqli_query($connected, "SELECT email FROM entries_table WHERE email = '".$email."'");

	  if(mysqli_num_rows($emailCheck) > 0){
		$emailError   = "This email already exists in database";
		$success_fail = "Your request was unsuccessful. Please fill the form again and submit.";
		$formIsValid  = False;
	  }
	  CloseConnection($connected);
	}
  }
    
  if (empty($_POST["address"])) {
    $addressError = "Address is empty";
	$success_fail = "Your request was unsuccessful. Please fill the form again and submit.";
	$formIsValid  = False;
  } 
  else {
	$address = test_input($_POST["address"]);
    if (!preg_match("/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/",$address)){
		
      $addressError = "Address must contain letters and numbers";
	  $success_fail = "Your request was unsuccessful. Please fill the form again and submit.";
	  $formIsValid  = False;
		
	}
	
  } 
  if (isset($_POST["categories"])) {
    $category = test_input($_POST["categories"]);
  }
}  

if ($formIsValid && $posted){
	$posted = False;
	$connected = StartConnection();
	if (mysqli_connect_errno($connected))
    {
        echo "Failed to connect to database: " . mysqli_connect_error();
    }
    $my_date = date("Y-m-d H:i:s");
    //$sql= "INSERT INTO entries_table (first_name, last_name, email, address, category, date_time)VALUES ('$fname', '$lname', '$email', '$address', '$category', '$my_date')";
	mysqli_query($connected, "INSERT INTO entries_table (first_name, last_name, email, address, category, date_time)VALUES ('$fname', '$lname', '$email', '$address', '$category', '$my_date')");
	CloseConnection($connected);
	$success_fail = "Your request was sent and stored in database successfully!";
	$messageColor = "green";
	$fname = $lname = $email =  $address = $category = "";
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Please fill the Form below</h2>
<p>
	<span class="error">* required fields</span>
</p>
<br><br>
<div class="container">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <p>
	<label>First Name: *</label> 
	<input type="text" name="first_name" value="<?php echo $fname;?>">
	<span class="error"><?php echo $fnameError;?></span>
  </p>
  <br><br><br><br>
  <p>
	<label>Last Name: *</label>  
	<input type="text" name="last_name" value="<?php echo $lname;?>">
	<span class="error"><?php echo $lnameError;?></span>
  </p>
  <br><br><br><br>
  <p>
	<label>E-mail: *</label> 	
	<input type="text" name="email" value="<?php echo $email;?>">
	<span class="error"> <?php echo $emailError;?></span>
  </p>
  <br><br><br><br>
  <p>
	<label>Address: *</label> 
	<input type="text" name="address" value="<?php echo $address;?>">
	<span class="error"><?php echo $addressError;?></span>
  </p>
  <br><br><br><br>
  <p>
	<label>Category:</label>
	<select name="categories">
	<?php 
		while($row = $categories_sql->fetch_assoc()){
			echo '<option value="'.$row['category'].'">'.$row['category'].'</option>';
        }
	?>
	</select> 
  </p>
  <br><br>
  <input type="submit" name="submit" value="Submit"> 
</form>
</div>
<?php
echo "<h3 style='color:".$messageColor.";' align='center'>".$success_fail."</h3>";
?>
</body>
</html>
