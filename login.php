<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="login.php" method="post">
        <h1>Authentification</h1>
        <label for="">Login :</label><br>
        <input type="text" name="login" id="login"><br>
        <label for="">Password :</label><br>
        <input type="password" name="password" id="password"><br>
        <button type="submit">s'authentifier</button>
    </form>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        include "connection.php";
        $login = $_POST['login'];
        $password = $_POST['password'];
        if(empty($login) && empty($password)){
            echo "Veuillez saisir un login et un mot de passe";
        }else{
            $stm=$conn->prepare("SELECT * FROM CompteProprietaire WHERE loginProp=:login AND motPasse=:password");
            $stm->bindParam(':login',$login);
            $stm->bindParam(':password',$password);
            $stm->execute();
            $compte=$stm->fetch(PDO::FETCH_ASSOC);
            if(!$compte){
                echo "Erreur de login/mot de passe.";
            }else{
                session_start();
                $_SESSION['login'] = $login;
                header('Location: dashboard.php');
            }
        }
        
    }
    
?>