<?php

session_start();


if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: menu.php");
    exit;
}


require_once "configuracion.php";


$username = $password = "";
$username_err = $password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){


    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese su usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
 
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingrese su contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                          
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            header("location: menu.php");
                        } else{
                            $password_err = "La contraseña ingresada es invalida.";
                        }
                    }
                } else{
                    $username_err = "El usuario ingresado no está registrado.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">         
      </style>
  </head>
  <body>
  <header>
          <div class="content">
              
          <div class="menu container">
              <a href="menu.html" class="logo"><img src="img/nombre.png"height="50px" alt=""></a>
              <input type="checkbox" id="menu" />     
          </div>                     
  </header>

  <div class="login">
		<div class="login-screen">
          
			<div class="login-form">

            <p style="font-size: 30 px; color: rgb(241, 243, 246); font-weight: bolder;"></p>
    <br>

    <?php
$texto = "Ingreso";

echo "<p style='font-weight: bolder; font-size: 50px; color:  rgb(241, 243, 246);'>$texto</p>";
?>
<br>
<p style="font-size: 23px; color: rgb(241, 243, 246); font-weight: bolder;">Por favor ingrese sus datos de registro.</p>
<br>
   
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label></label>
            <input type="text" placeholder="Introduce tu nombre" name="username" class="form-control" value="<?php echo $username; ?>">
            <br>
            <span class="help-block"><?php echo  "<p style='color: #050451 ; font-size: 22px;'> $username_err</p>";?></span>       

            
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label></label>
            <input type="password" placeholder="Introduce tu contraseña" name="password" class="form-control">
            <br>
            <span class="help-block"><?php echo "<p style='color: #050451 ; font-size: 22px;'> $password_err</p>";?></span>
        </div>
       
        <div class="form-group">
            <input type="submit" style= "color: #ffff; background-color: #031e01" class="btn btn-primary" value="Ingresar">
        </div>

        <p>No estás registrado? <a href="registro.php" style="color: #050451;">Registrate aquí.</a>.</p>
    </form>
</div>
</body>
</html>