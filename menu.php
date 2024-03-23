<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>carpeta de bienvenida</title>
    <link rel="stylesheet" href="style.css">
    </style>

    <header>
          <div class="content">
              
          <div class="menu container">
              <a href="menu.html" class="logo"><img src="img/nombre.png"height="50px" alt=""></a>
              <input type="checkbox" id="menu" />     
              </label>
            <nav class="navbar1">
                <ul>
                    <ul>
                    <li style=><a href="salir.php">REGRESAR</a></li>
                    </ul>                      
                </ul>
            </nav>               
          </div>                          
  </header>

  </head>

<body>
<div class="page-header">
    <h3>Hola <span><?php echo htmlspecialchars($_SESSION["username"]); ?></span> Bienvenido.</h3>
</div>
</body>
</html>