<!DOCTYPE html>
<!-- Chris Schultz-->
<html>
	<head>
		<title>Lab 4 -User Registration and Login</title>
	</head>
	<body>
		<br><br>
		<hl>
		
		<?php
			$pageNum = "0";
			if( isset($_GET["page"]) )	{
				$pageNum = $_GET["page"];
				settype($pageNum, "integer");
			}
			else{
				$pageNum = 1;
			}

			if($pageNum > 3 || $pageNum < 1){
				echo("<strong>Error...this page does not exist!</strong></body></html>");
				die();
			}

			if($pageNum == 1){
		?>
		<!-- Setup the form for  registerin new user-->
		<form method="get" 
			action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<br><br><br><br>
			<input type="hidden" name="page" value="2">
			<p><label>Username: 
				<input type="text" name="username">
			</label></p>
			<p><label>Password:
				<input type="text" name="password">
			</label></p>
			<p><input type="submit" value="Register"></p>				
		</form>
		
		<!-- Setup the form for login new user-->
		<form method="get" 
			action="<?php echo $_SERVER['PHP_SELF']; ?>">				
			<input type="hidden" name="page" value="3">
			<p><label>Username: 
				<input type="text" name="username">
			</label></p>
			<p><label>Password:
				<input type="text" name="password">
			</label></p>
			<p><input type="submit" value="Login"></p>				
		</form>
		
		<?php
		} //end page setup
		
		else if ($pageNum == 2)	{ //if the register button was clicked
			$username = $password = "";
			if (isset($_GET["username"]) && $_GET["username"] != "" && isset($_GET["password"])	&& $_GET["password"] != "") {
				$username = $_GET["username"];
				$password = $_GET["password"];
				
				$error = 'Connect failure';	//mysql error 					
				$dbUser = 'root';
				$dbPassword = 'chrisvm';
				$dbName = 'lab4';
				$host = 'localhost';
				
				$conn = new mysqli($host, $dbUser, $dbPassword , $dbName); //start a connection to the database

				if ($conn->connect_error) { //cound't connect
					die("Connection failed: " . $conn->connect_error);
				} 				

				//see if the user exists already in the database
				$sqlQuery = "SELECT username, password FROM User WHERE username='" . $username . "'";
				$results = $conn->query($sqlQuery);

				if ($results->num_rows > 0) { //if they exist
					echo "User already in database";
				} 
				else { //otherwise they don't exist so add them
					$sqlQuery = "INSERT INTO User (username, password)
						VALUES ('" . $username . "', '" . $password . "')";
					if ($conn->query($sqlQuery) === TRUE) {
						echo "Success";
					} 
					else {
						echo "Error: " . $sqlQuery . "<br>" . $conn->error;
					}
				}
				$conn->close(); 

			}
			else{ //didn't find any form data
				echo("<p><strong>Error...your info was not received properly...!</strong></p></body></html>");
				die();
			}
	?>	
		<form method="get" 
			action="<?php echo $_SERVER['PHP_SELF']; ?>">
			
			<input type="hidden" name="page" value="1">
			<p><input type="submit" value="Back to Page 1"></p>
		</form>			
	<?php
		} //if the  login button was pressed
		else if ($pageNum == 3) {
			$username = $password = "";
			if (isset($_GET["username"]) 
				&& $_GET["username"] != ""
				&& isset($_GET["password"])
				&& $_GET["password"] != "")
			{
				$username = $_GET["username"];
				$password = $_GET["password"];
				
				$error = 'Could not connect.';
				
				$host = 'localhost';
				$dbUser = 'root';
				$dbPassword = 'chrisvm';

				$dbName = 'lab4';				
				$conn = new mysqli($host, $dbUser, $dbPassword , $dbName); //start a new connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 				
				//check the database if the user already exists
				$sqlQuery = "SELECT username, password FROM User WHERE username=' " . $username . " ' AND password='" . $password . "' " ;
				$results = $conn->query($sqlQuery);
				
				//if they exist
				if ($results->num_rows > 0) 	{
					echo "Successfully loggeed in";
				}
				else{ //they don't exist
					echo "Failed to login";
				} }
			else{ //form wasn't filled out correctly
				echo("<p><strong>Error...your info was not received properly...!</strong></p></body></html>");
				die();
			}
		?>
			<form method="get" 
				action="<?php echo $_SERVER['PHP_SELF']; ?>">
				
				<input type="hidden" name="page" value="1">
				<p><input type="submit" value="Back to Page 1"></p>
			</form>			
		<?php
			}
		?>
	</body>
</html>
