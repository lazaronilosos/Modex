
<?php
require_once '../controler/validation.php'; 
//require_once '../../config/twigSetup.php';

// Initialize variables and error messages
 $username = $password= '';
$usernameErr=$passError='*';
$valid = true;

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize variables from POST data
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';


    

    if ( nameCheck($username)) {
     
        $valid = false;
        $username="";
    }

  
    if (passCheck($password)) {

        $valid = false;
        $password="";
    }

    

    // If all validations pass, insert into the database
    if ($valid) {
        require_once '../../config/connection.php'; // Adjust the path as needed
        
        // Prepare and execute the insert statement
        $stmt = $con->prepare("SELECT id,`password` FROM users WHERE username=?");
        $stmt->bind_param('s',$username); //OVDE SI STIGAO 
        $stmt->execute();
        $stmt->bind_result($id,$hashed);
        $stmt->store_result();
        if($stmt->num_rows==0){
            $usernameErr="Pogrešno ste uneli korisničko ime!";
        } else{
            $stmt->fetch();
            if(password_verify($password,$hashed)){
                header('Location:../controler/logincontrol.php?id='.$id);
                exit();
            } else{
                $passError="Netačno uneta lozinka!";
            }
        }
} else{
    $usernameErr='Unos nije validan!';
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/styes.css">
</head>
<body>
    <div class="container">
        <div class="paper">
            <div class="form-container">
                <h1>Uloguj se</h1>
                <form action="../view/login.php" method="post">
                    <div class="polje">
                        <label for="username">Korisničko ime</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username) ?>" required>
                        <span> <?php echo htmlspecialchars($usernameErr) ?> </span>
                    </div>
                    <div class="polje">
                        <label for="password">Lozinka</label>
                        <input type="password" id="password" name="password" required>
                        <span><?php echo htmlspecialchars($passError) ?></span>
                    </div>
                    <button type="submit">Uloguj se</button>
                    <span><a href="register.php" class="home-link">Nemaš nalog? Registruj se</a></span>
                </form>
                <a href="../../public/index.php" class="home-link">Idi na naslovnu</a>
            </div>
        </div>
    </div>
</body>
</html>

