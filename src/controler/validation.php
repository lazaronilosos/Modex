<?php
function nameCheck($s){
    if(empty($s)){
        return "Obavezno je popuniti ovo polje!";
    } else if(!preg_match('/^[A-Za-z]+$/',$s)){
    return "Text ne sme da sadrzi specijalne karaktere niti brojeve!";
} else{
    return false;
}
}
function usernameCheck($s){
    if(nameCheck($s)){
        return nameCheck($s);
    } else{
        $q="SELECT id FROM users WHERE username=?";
            require_once "../../config/connection.php";
            global $con;
            if($stmt=$con->prepare($q)){
            $stmt->bind_param('s',$s);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows!=0){
                return "Korisničko ime je zauzeto!";
            } else{
                return false;
            }
        } else{
            echo "SQL ERROR - coudn't prepare statement!";
        }
        $stmt->close();
    }
}

function passCheck($password) {
    if(empty($password)){
        return "Obavezno je popuniti ovo polje!";
    } else  if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', $password)) {
        return false; 
    } else {
        return "Lozinka mora posedovati barem 6 karaktera i imati barem jedno veliko, malo slovo, cifru i specijalni karakter.";
    }
}
function repassCheck($password, $repassword) {
    if(empty($repassword)){
        return "Obavezno je popuniti ovo polje!";
    } else  if ($password === $repassword) {
        return false; 
    } else {
        return "Lozinke se ne poklapaju!";
    }
}
?>