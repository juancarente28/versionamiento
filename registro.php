<?php

require_once "configuracion.php";


$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $username_err = "Ingrese un nombre de usuario.";
    } else{
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Este mombre ya está en uso.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Upps! Algo salió mal, intenta nuevmente.";
            }

             // Close statement
             mysqli_stmt_close($stmt);
            }
        }


        if(empty(trim($_POST["password"]))){
            $password_err = "Ingrese una contraseña.";
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Esta requiere minimo 6 caracteres.";
        } else{
            $password = trim($_POST["password"]);
        }


        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Confirme su contaseña.";
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Su contraseña no coincide.";
            }
        }


        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

     
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    
            if($stmt = mysqli_prepare($link, $sql)){
             
                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
    
        
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); 


                if(mysqli_stmt_execute($stmt)){
            
                    header("location: ingresar.php");
                } else{
                    echo "Algo salió mal, intenta nuevamente.";
                }
    
                mysqli_stmt_close($stmt);
            }
        }


        mysqli_close($link);
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
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
$texto = "Registro";

echo "<p style='font-weight: bolder; font-size: 50px; color:  rgb(241, 243, 246);'>$texto</p>";
?>
<br>
    <p style="font-size: 23px; color: rgb(241, 243, 246); font-weight: bolder;">Por favor llene el formulario.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        <br>
          <label></label>
            <input type="text" placeholder="Introduce tu nombre" name="username" class="form-control" value="<?php echo $username; ?>">
            <br>
            <span class="help-block"><?php echo "<p style='color: #050451 ; font-size: 22px;'> $username_err</p>";?></span>
        </div>

        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label></label>
            <input type="password" placeholder="Introduce tu contraseña"name="password" class="form-control" value="<?php echo $password; ?>">
            <br>
            <span class="help-block"><?php echo "<p style='color: #050451 ; font-size: 22px;'> $password_err</p>";?></span>
        </div>

        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label></label>
            <input type="password" placeholder="Confirma tu contraseña" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <br>
            <span class="help-block"><?php echo  "<p style='color: #050451 ; font-size: 22px;'> $confirm_password_err</p>";?></span>
        </div>
        
        <div class="form-group">
            <input type="submit" id="inputPequeno" style= "color: #ffff; background-color: #031e01" class="btn btn-primary" value="Enviar">     
            <input type="reset"  id="inputPequeno" style= "color: #ffff; background-color: #031e01" class="btn btn-default" value="Reiniciar">
        </div>
        <p style="color: #ffff;">Ya tienes un usuario?<a href="ingresar.php" style="color: #050451;"> Ingresa aquí.</a></p></p> 
        <br>
    </form>
</div>
</body>
</html>
