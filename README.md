# pownMyApp
Simplon brief about app security

## Assignment
The goal is to design and implement an app with security breaches such as :  
- XSS,  
- SQLI,  
- CSRF.

## Set-up
App has been made using php 8.0, without any framework.  
It consists in one login.php page asking for login and password. Once submitted, the user might be redirected to the welcome.php page.  
Data are stored in a mySql database locally, in a table with the following structure :  
- id,  
- username,  
- password,  
- created_at
To test the app, user needs to set-up the database connection in the config.php file and replace ???? with related value :  
define('DB_SERVER', '????');  
define('DB_USERNAME', '????');  
define('DB_PASSWORD', '????');  
define('DB_NAME', '????');  

## Results
- XSS :  
Definition : XSS attacks enable attackers to inject client-side scripts into web pages viewed by other users. The following one is a stored XSS.  
Action / Test : A user with username "<script>alert('XSS');</script>" has been created in the Database. When logged, the welcome.php page tries to display username and thus trigger <script> with the alert('XSS').  
Counter : When displaying the username in welcome.php, "echo $_SESSION["username"];" (line 25)  must be replaced by "echo htmlspecialchars($_SESSION["username"]);"  
  
- SQLI :  
Definition : SQL injection is a code injection technique used to attack data-driven applications, in which malicious SQL statements are inserted into an entry field for execution.  
Action / Test : The username "' OR 1 = 1 OR'&ndash;&ndash;" is given and the whole user list is returned in welcome.php screen.  
Counter : Line 40 in login.php, replace "$result = mysqli_query($link, $sql);" that executes the request by a set of functions aiming at preparing and sanitize request before executing it. After execution, we can also test if result consists in only 1 line to avoid SQL injection trying to fetch multiple entries :   
  $stmt = mysqli_prepare($link, $sql). 
  mysqli_stmt_bind_param($stmt, "s", $param_username); // Sanitize and escape characteres
  $param_username = $username // Coming from $_POST;
  mysqli_stmt_execute
  if(mysqli_stmt_num_rows($stmt) == 1) // Check if results contains one and only one Database entry
  
- CSRF :  
Definition : CSRF is a type of malicious exploit of a website where unauthorized commands are submitted from a user that the web application trusts.  
Action / Test :  
Counter :
