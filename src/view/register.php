<?php
require_once '../controler/validation.php'; 
require_once "../../config/connection.php";


 // Make sure $con is in the global scope

if (!$con) {
    die("Database connection not established.");
}

$name = $surname = $username = $password = $repassword = '';
$nameErr = $surnameErr = $usernameErr = $passwordErr = $repasswordErr = '';
$valid = true;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $repassword = isset($_POST['repassword']) ? trim($_POST['repassword']) : '';
    
    
    if ($nameError = nameCheck($name)) {
        $nameErr = $nameError;
        $valid = false;
        $name="";
    }
    
    
    if ($surnameError = nameCheck($surname)) {
        $surnameErr = $surnameError;
        $valid = false;
        $surname="";
    }
    
    
    if ($usernameErr = usernameCheck($username)) {
        $usernameErr = $usernameErr;
        $valid = false;
        $username="";
    }
    
    
    if ($passError = passCheck($password)) {
        $passwordErr = $passError;
        $valid = false;
        $password="";
    }
    
    
    if ($repassError = repassCheck($password, $repassword)) {
        $repasswordErr = $repassError;
        $valid = false;
        $repassword="";
    }
    
    
    if ($valid) {
        global $con;
       
        $stmt = $con->prepare("INSERT INTO users (username, surname, name, password, role) VALUES (?, ?, ?, ?, 'user')");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security
        
        if ($stmt) {
            $stmt->bind_param("ssss", $username, $surname, $name, $hashedPassword);
            if ($stmt->execute()) {
               header('Location:login.php');
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $con->error;
        }
        
        $con->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/styes.css">
</head>
<body>
    <div class="container">
        <div class="paper">
            <div class="form-container">
                <h1>Registruj se</h1>
                <form action="register.php" method="post">
                    <div class="polje">
                        <label for="name">Ime</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                        <span class="error"><?php echo $nameErr; ?></span>
                    </div>
                    <div class="polje">
                        <label for="surname">Prezime</label>
                        <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($surname); ?>" required>
                        <span class="error"><?php echo $surnameErr; ?></span>
                    </div>
                    <div class="polje">
                        <label for="username">Korisničko ime</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                        <span class="error"><?php echo $usernameErr; ?></span>
                    </div>
                    <div class="polje">
                        <label for="password">Lozinka</label>
                        <input type="password" id="password" name="password" required>
                        <span class="error"><?php echo $passwordErr; ?></span>
                    </div>
                    <div class="polje">
                        <label for="repassword">Ponovi lozinku</label>
                        <input type="password" id="repassword" name="repassword" required>
                        <span class="error"><?php echo $repasswordErr; ?></span>
                    </div>
                    <button type="submit">Registruj se</button><span><a href="login.php" class="home-link">Već poseduješ nalog? Uloguj se</a></span>
                </form>
                <a href="../../public/index.php" class="home-link">Idi na naslovnu</a>
            </div>
        </div>
    </div>
</body>
</html>
</html>
