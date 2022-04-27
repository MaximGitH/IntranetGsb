<html>

<?php
if(!isset($_SESSION)){
    session_start();
}
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
    $_SESSION['prenom'] = $_POST['pseudo'];
    $_SESSION['mdp'] = $_POST['mdp'];

    include 'Connexion_bdd.php';
    // Requ�te pour tester la connexion

    $query = $pdo->query("SELECT id FROM `utilisateur` where login = '".$_SESSION['prenom']."'");
    $query2 = $pdo->query("SELECT id FROM `utilisateur` where mdp = '".hash('sha256', $_SESSION['mdp'])."'");
    $query3 = $pdo->query("SELECT role FROM `utilisateur` where login = '".$_SESSION['prenom']."' and mdp = '".hash('sha256', $_SESSION['mdp'])."'");
    echo hash('sha256', 'gsb');

    $resultat = $query->fetchAll();
    $resultat2 = $query2->fetchAll();
    $resultat3 = $query3->fetchAll();


    $lelogin = null;
    foreach ($resultat as $key => $variable)
    {
        $lelogin = $resultat[$key]['id'];
    }

    $lemdp = null;
    foreach ($resultat2 as $key2 => $variable2)
    {
        $lemdp = $resultat2[$key2]['id'];
    }

    $lerang = null;
    foreach ($resultat3 as $key3 => $variable3)
    {
        $lerang = $resultat3[$key3]['role'];
    }

    $_SESSION['role'] = $lerang;
    $_SESSION['l&mI'] = null;
    $_SESSION['CI'] = null;
    $repetelogin = null;
    if(isset($_POST['captcha'])){
        if($_POST['captcha']==$_SESSION['code']){
            if($lelogin == $lemdp and $lelogin != null and $lemdp != null){
                if($lerang == 0){
                    header('Location: Accueil.php');  
                    print ("Connecté en tant que visiteur");
                    print("<form action='login.php' method='post' ><input type='submit' href='login.php' /></form>");
                    
                    
                }
                
                
                else{
                    header('Location: Accueil.php');  
                    print ("Connecté en tant que comptable");
                    
                }
                $_SESSION["id"] = $lemdp;
                
            }
            else{
                $_SESSION['l&mI'] = 'oui';
                    include("Page_connexion.php");
                    
                
            }
            
        } else {
            $_SESSION['CI'] = 'oui';
                include("Page_connexion.php");
        }
    }
    else{
    }





}
?>

</html>