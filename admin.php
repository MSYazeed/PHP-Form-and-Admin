
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
	table {
		border: 1px solid #ccc;
		border-collapse: collapse;
		margin: 0;
		padding: 0;
		width: 100%;
		table-layout: fixed;
	}
	table caption {
		font-size: 1.5em;
		margin: .5em 0 .75em;
	}
	table tr {
		background: #f8f8f8;
		border: 1px solid #ddd;
		padding: .35em;
	}
	table th,
	table td {
		padding: .625em;
		text-align: center;
	}
	table th {
		font-size: .85em;
		letter-spacing: .1em;
		text-transform: uppercase;
	}
	a {
		color: #000000;
		text-decoration: none;
	}
	a:hover {
		color: #109177;
	}
	.container1 {
		margin: 0 auto;
		width: 150px;
	}
	.exporting {
		margin: 0 auto;
		width: 100px;
	}
</style>
</head>
<body>  

<h2>Find all database entries shown below</h2>
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
	
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	$order = "";
	$sortingBy = "id_sort";
	$entries_sql = "SELECT * FROM entries_table";
	
	if (isset($_GET['order'])){
		$order = ($_GET['order']=='ASC')?'ASC':'DESC';
	}
	
	if (isset($_GET['sort'])){
		switch($_GET['sort']){
			
			case 'first_name_sort': 	$entries_sql   .= " ORDER BY first_name " .$order; 
										$sortingBy 		= "first_name_sort";
										break;
			case 'last_name_sort':		$entries_sql   .= " ORDER BY last_name "  .$order;
										$sortingBy 		= "last_name_sort";
										break;
			case 'email_sort':	  		$entries_sql   .= " ORDER BY email " 	  .$order;	
										$sortingBy 		= "email_sort";
										break;
			case 'address_sort':  		$entries_sql   .= " ORDER BY address " 	  .$order;
										$sortingBy 		= "address_sort";
										break;
			case 'category_sort': 		$entries_sql   .= " ORDER BY category "   .$order;
										$sortingBy 		= "category_sort";
										break;
			case 'datetime_sort': 		$entries_sql   .= " ORDER BY date_time "  .$order;
										$sortingBy 		= "datetime_sort";
										break;
			default:					$entries_sql   .= " ORDER BY id "  		  .$order;
										$sortingBy 		= "id_sort";
		}
	}
	else {
		$order = "ASC";
	}
	 
	
	
	$connected = StartConnection();
	if (mysqli_connect_errno($connected))
	{
		echo "Failed to connect to database: " . mysqli_connect_error();
	}
	
	
	// =============================================== Paginator 1 ===========================================
	$numOfEntries = mysqli_query($connected, "SELECT * FROM entries_table");
	$numRows = mysqli_num_rows($numOfEntries);
	// number of rows to show per page
	$rowsPerPage = 10 ;

	// number of pages
	$numberOfPages = ceil($numRows / $rowsPerPage);

	
	// get the current page or set a default
	if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
		$currentPage = (int) $_GET['currentpage'];
	} 
	else {
		$currentPage = 1;
	} 
	
	if ($currentPage > $numberOfPages) {
		$currentPage = $numberOfPages;
	} 
	if ($currentPage < 1) {
		$currentPage = 1;
	} 
	$offset = ($currentPage - 1) * $rowsPerPage;
	
	$entries_sql .= " LIMIT $offset, $rowsPerPage";
	
	$range = 1;

	
	// =============================================== Paginator 1 ===========================================
	
	if(isset($_POST["Export"])){ 
		header('Content-Type: text/csv; UTF-8');
		header('Content-Disposition: attachment; filename=Exported Entries.csv');
		header("Pragma: no-cache");
		header("Expires: 0");
		$conn = StartConnection();
		ob_get_clean();
		$output = fopen('php://output', 'w');
	
		fputcsv($output, ['Entery ID', 'First Name', 'Last Name', 'Email', 'Address', 'Category', 'Joining Date']);
		$rows = mysqli_query($conn, $entries_sql);
		while ($row = mysqli_fetch_assoc($rows)) {
			fputcsv($output, [$row["id"], $row["first_name"], $row["last_name"], $row["email"], $row["address"], $row["category"], date("m/d/y g:i A", strtotime($row["date_time"]))]);
		}
		fclose($output);
		mysqli_close($conn);
		
		exit();
			
	} 
	CloseConnection($connected);
	
	$connected = StartConnection();
	if (mysqli_connect_errno($connected))
	{
		echo "Failed to connect to database: " . mysqli_connect_error();
	}
	
	$entries = mysqli_query($connected, $entries_sql);
	
	CloseConnection($connected);
	
	if ($entries->num_rows > 0) {
		
		
		echo "<table border='1' class='entries_table'>
				

				<thead>
				<tr>";
		if($sortingBy == 'id_sort' && $order == 'DESC'){
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=id_sort&amp;order=ASC&amp;currentpage=$currentPage'>Entery ID</a></th>";
			
		}
		else {
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=id_sort&amp;order=DESC&amp;currentpage=$currentPage'>Entery ID</a></th>";
			
		}
		if($sortingBy == 'first_name_sort' && $order == 'DESC'){
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=first_name_sort&amp;order=ASC&amp;currentpage=$currentPage'>First Name</a></th>";
		}
		else{
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=first_name_sort&amp;order=DESC&amp;currentpage=$currentPage'>First Name</a></th>";

		}
		if($sortingBy == 'last_name_sort' && $order == 'DESC'){
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=last_name_sort&amp;order=ASC&amp;currentpage=$currentPage'>Last Name</a></th>";
		}
		else{
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=last_name_sort&amp;order=DESC&amp;currentpage=$currentPage'>Last Name</a></th>";

		}
		if($sortingBy == 'email_sort' && $order == 'DESC'){
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=email_sort&amp;order=ASC&amp;currentpage=$currentPage'>Email</a></th>";
		}
		else{
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=email_sort&amp;order=DESC&amp;currentpage=$currentPage'>Email</a></th>";

		}
		if($sortingBy == 'address_sort' && $order == 'DESC'){
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=address_sort&amp;order=ASC&amp;currentpage=$currentPage'>Address</a></th>";
		}
		else{
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=address_sort&amp;order=DESC&amp;currentpage=$currentPage'>Address</a></th>";

		}
		if($sortingBy == 'category_sort' && $order == 'DESC'){
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=category_sort&amp;order=ASC&amp;currentpage=$currentPage'>Category</a></th>";
		}
		else{
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=category_sort&amp;order=DESC&amp;currentpage=$currentPage'>Category</a></th>";

		}
		if($sortingBy == 'datetime_sort' && $order == 'DESC'){
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=datetime_sort&amp;order=ASC&amp;currentpage=$currentPage'>Joining Date</a></th>";
		}
		else{
			echo		"<th><a href='".htmlspecialchars($_SERVER["PHP_SELF"])."?sort=datetime_sort&amp;order=DESC&amp;currentpage=$currentPage'>Joining Date</a></th>";

		}
		echo	"</tr>
				 </thead>
				 <tbody>";
		while($row = $entries->fetch_assoc()) {
			echo "<tr><td>" .$row["id"]. "</td><td>" .$row["first_name"]. "</td><td>" .$row["last_name"]. "</td><td>" .$row["email"]. "</td><td>" .$row["address"]. "</td><td>" .$row["category"]. "</td><td>" .$row["date_time"]. "</td></tr>";
		}
		echo "</tbody>
			  </table>";
	}
	// =============================================== Paginator 2 ===========================================
	echo "<div class = 'container1'>";
	if ($currentPage > 1) {
		echo " <a class='link' href='".htmlspecialchars($_SERVER['PHP_SELF'])."?sort=$sortingBy&amp;order=$order&amp;currentpage=1'><<</a> ";
		$prevPage = $currentPage - 1;
		echo " <a href='".htmlspecialchars($_SERVER['PHP_SELF'])."?sort=$sortingBy&amp;order=$order&amp;currentpage=$prevPage'><</a> ";
	}
	
	for ($i = ($currentPage - $range); $i < (($currentPage + $range) + 1); $i++) {
		if (($i > 0) && ($i <= $numberOfPages)) {
			if ($i == $currentPage) {
				echo " [<b>$i</b>] ";
			} 
			else {
				echo " <a href='".htmlspecialchars($_SERVER['PHP_SELF'])."?sort=$sortingBy&amp;order=$order&amp;currentpage=$i'>$i</a> ";
			}
		}
		else{
			continue;
		}
	} 
	
	if ($currentPage != $numberOfPages) {
		$nextPage = $currentPage + 1;
		echo " <a href='".htmlspecialchars($_SERVER['PHP_SELF'])."?sort=$sortingBy&amp;order=$order&amp;currentpage=$nextPage'>></a> ";
		echo " <a href='".htmlspecialchars($_SERVER['PHP_SELF'])."?sort=$sortingBy&amp;order=$order&amp;currentpage=$numberOfPages'>>></a> ";
	}
	echo "</div>";
	// =============================================== Paginator 2 ===========================================
	
	
	
	
?>
<form name="exporting" action="" method="post" class="exporting">
    <input type="submit" name="Export" value="Export table to CSV (Paginated)">
</form>
</body>
</html>
