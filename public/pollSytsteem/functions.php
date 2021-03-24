<?php
function pdo_connect_mysql()
{
    // Update the details below with your MySQL details
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'phppoll';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // If there is an error with the connection, stop the script and display the error.
        die ('Failed to connect to database!');
    }
}

// Template header, feel free to customize this
function template_header($title)
{
    echo <<<EOT

<!DOCTYPE html> 
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="Style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	
	<body>
	
  
    
</body>

EOT;
}

//Template footer
function template_footer()
{
    echo <<<EOT
  <nav class="nav">
    	<div class="navBtn">
            <a href="index.php" class="navLink greenText">
            <i class="fas fa-poll-h"></i> Polls</a>
    	</div>
    	<div class="navBtn">
    	    	<a href="create.php" class="navLink blueText">
            <i class="fa fa-plus" aria-hidden="true"></i>Add</a>
        </div>
        
    </nav>
</body>
</html>
EOT;
}

?>