<?php 
include 'Menu.php';
include 'bas_de_page.php';
if(!isset($_SESSION)){
    session_start();
}

if($_SESSION['id'] !== 'non'){
?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/connexion.css">
    <title>Accueil</title>
</head>
<body id="SeConnecter">
<div class="">
    <div class="card">

<?php 


include 'Connexion_bdd.php';

$query = $pdo->query ("select nom , prenom , role from `utilisateur` where id = '".$_SESSION["id"]."'");

$resultat = $query->fetchAll();

    foreach ($resultat as $key => $variable)
    {
        $nom = $resultat[$key]["nom"];
        $prenom = $resultat[$key]["prenom"];
        $rang = $resultat[$key]["role"];
    }



    $query = $pdo->query ("select nom , prenom , role from `utilisateur` where id = '".$_SESSION["id"]."'");

    $resultat = $query->fetchAll();

    foreach ($resultat as $key => $variable)
    {
        $nom = $resultat[$key]["nom"];
        $prenom = $resultat[$key]["prenom"];
        $rang = $resultat[$key]["role"];
    }
        if($rang == 0){
            $status = "visiteur";
        }
            else if($rang == 1){
                $status = "comptable";
            }
                else{
                    $status = "admin";
    }

    echo "</br></br></br></br></br></br></br></br></br></br></br></br></br></br>";
    echo "<center><h1>Bienvenue sur votre espace,  ". $nom ."  ". $prenom ." ! </h1></center></br>";
    echo "</br></br>";
    echo "<center><p>Vous êtes : <u><strong> ". $status ."  </u></strong></p></center></br>";

?>

</div>

</div>
    </body>








    
<script>
// Déclaration des variables //
    var titre_bienvenue = document.getElementsByTagName("h1")[0];

    var profil = document.getElementsByTagName("p")[0];
///////////////////////////////


// ADDEventListener On lie l'événement resize à la fonction //
    window.addEventListener('resize', redimensionnement, false);


/// DESIGN ////
    profil.style.fontSize = "21px";
////////////


////// RESPONSIVE DESIGN //////
    // Fonction exécutée au redimensionnement, elle est executée à chaque écoute de changement de dimension de la fenêtre //
function redimensionnement() {

  if("matchMedia" in window) { // Détection
    if(window.matchMedia('(min-width:400px) and (max-width: 600px)').matches){
        titre_bienvenue.style.fontSize = "21px";
        titre_bienvenue.style.transition = "0.7s";
        titre_bienvenue.style.webkitTransition = "0.7s";
    } 
    else if(window.matchMedia('(min-width:600px) and (max-width: 900px)').matches){
        titre_bienvenue.style.fontSize = "25px";
        titre_bienvenue.style.transition = "0.7s";
        titre_bienvenue.style.webkitTransition = "0.7s";
    }
    else if(window.matchMedia('(min-width:900px) and (max-width: 1270px)').matches){
        titre_bienvenue.style.fontSize = "28px";
        titre_bienvenue.style.transition = "0.7s";
        titre_bienvenue.style.webkitTransition = "0.7s";
        profil.style.fontSize = "19px";
        profil.style.transition = "0.7s";
        profil.style.webkitTransition = "0.7s";
    }
    else{
        titre_bienvenue.style.fontSize = "32px";
        titre_bienvenue.style.transition = "0.7s";
        titre_bienvenue.style.webkitTransition = "0.7s";
        profil.style.fontSize = "21px";
        profil.style.transition = "0.7s";
        profil.style.webkitTransition = "0.7s";
    }
  }
}
///////////////////////////////
</script>

</html>
<?php }else{
    echo "<center><h2>Erreur dans la connexion, essayez de vous reconnecter.</h2></center>";
}?>