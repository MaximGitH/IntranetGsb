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
 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Choix d'un véhicule </title>
    <link rel="stylesheet" href="css/connexion.css">
    <link rel="stylesheet" href="css/pages.css">
</head>
<body id="Vehicule">
 <div class="card">

<?php 



include 'Connexion_bdd.php';

$query2 = $pdo->query ("select marque , cv  from `vehicule` where iduser = '".$_SESSION["id"]."'");
$query3 = $pdo->query ("select typedevehicule  from `typevehicule` inner join `vehicule` on vehicule.typevehiculeV = typevehicule.id_vehicule where iduser = '".$_SESSION["id"]."'");

$resultat2 = $query2->fetchAll();
$resultat3 = $query3->fetchAll();
$marque = null;
$cv = null;
$type = null;

    foreach ($resultat2 as $key2 => $variable2)
    {
        $marque = $resultat2[$key2]["marque"];
        $cv = $resultat2[$key2]["cv"];
    }

    foreach ($resultat3 as $key3 => $variable)
    {
        $type = $resultat3[$key3]["typedevehicule"];
    }


if(isset($_POST['validation'])){
    
    
    if(strlen($marque) == 0 and strlen($cv) == 0){
        $sql = ("insert into vehicule (cv,marque,iduser,typevehiculeV) VALUES ('".$_POST["cv"]."','".$_POST["marque"]."','".$_SESSION["id"]."'".$_POST['type'].")");
        $stmt= $pdo->prepare($sql);
        $stmt->execute();
    }

    else{
        
        $sql5 = ("UPDATE vehicule SET cv = '".$_POST["cv"]."',typevehiculeV = '".$_POST['type']."' , marque = '".$_POST["marque"]."' where iduser = '".$_SESSION["id"]."'");
        $stmt5= $pdo->prepare($sql5);
        $stmt5->execute();
    }
    
    
    
}

$query2 = $pdo->query ("select marque , cv , typevehiculeV  from `vehicule` where iduser = '".$_SESSION["id"]."'");

$resultat2 = $query2->fetchAll();
$marque = null;
$cv = null;
$vehicule = null;

    foreach ($resultat2 as $key2 => $variable2)
    {
        $marque = $resultat2[$key2]["marque"];
        $cv = $resultat2[$key2]["cv"];
        $vehicule = $resultat2[$key2]["typevehiculeV"];
    }

    $query2 = $pdo->query ("select marque , cv  from `vehicule` where iduser = '".$_SESSION["id"]."'");
    $query3 = $pdo->query ("select typedevehicule  from `typevehicule` inner join `vehicule` on vehicule.typevehiculeV = typevehicule.id_vehicule where iduser = '".$_SESSION["id"]."'");

    $resultat2 = $query2->fetchAll();
    $resultat3 = $query3->fetchAll();
    $marque = null;
    $cv = null;
    $type = null;

        foreach ($resultat2 as $key2 => $variable2)
            {
                $marque = $resultat2[$key2]["marque"];
                $cv = $resultat2[$key2]["cv"];
            }

            foreach ($resultat3 as $key3 => $variable)
            {
                $type = $resultat3[$key3]["typedevehicule"];
        }


    if(strlen($marque) != 0 and strlen($cv) != 0 and strlen($vehicule) != 0){
        echo "</br></br></br></br></br></br>";   
        echo'<center><span class="tag is-primary" style="font-size:20px">
        Vous avez enregistr&#233; une <strong> '.$type.' </strong> dont la marque est : <strong> '.$marque.'  </strong> et les chevaux fiscaux s eleve a  : <strong> '.$cv.' <strong>
        </span></center></br>';
    }

        else{
            echo'<center><span class="tag is-danger">
            Vous avez pas encore enregistré de voiture.
            </span></center></br>';
        }


?>
    <form action="Vehicule.php" method="post">
        <center>
            <div class="container"></br></br>
                <div class="notification is-primary">
                        <input name ="marque" type="text" placeholder="Remplissez la marque" style="text-align:center;border-radius:10px;border-color:black"><br></br></br>
                        <input name ="cv" type="text" placeholder="Donnez le nombre de chevaux" style="text-align:center;border-radius:10px;border-color:black" size="28"><br></br>
                        <p class="titre_choix_véhicule"> Choix du véhicule </p>
                        <select name="type">
                            <option value="1">Voiture</option>
                            <option value="2">Moto</option>
                            </select></br></br>
                        <button name ="validation" value = "validation" type="submit" class="bouton_valider_affiche_fiche">Enregistrer</button>
                        <button name ="validation" value = "validation" type="submit" class="bouton_valider_affiche_fiche">Modifier</button>

                    </div>
                </div>
                </center>
                </form>
            </div>
        </div>
    </body>








    <script>
// Déclaration des variables ///
const phrase_recapitulatif_voiture = document.querySelector(".tag");

const titre_Choix_Voiture = document.querySelector(".titre_choix_véhicule");

///////////////////////////////


// ADDEventListener On lie l'événement resize à la fonction//
window.addEventListener('resize', redimensionnement, false);


/// RESPONSIVE DESIGN ///

// Fonction exécutée au redimensionnement, elle est executée à chaque écoute de changement de dimension de la fenêtre //
function redimensionnement() {

  if("matchMedia" in window) { // Détection
    if(window.matchMedia('(min-width:400px) and (max-width: 570px)').matches) {
        phrase_recapitulatif_voiture.style.fontSize = "13px";
        phrase_recapitulatif_voiture.style.transition = "0.7s";
        phrase_recapitulatif_voiture.style.webkitTransition = "0.7s";
        titre_Choix_Voiture.style.fontSize = "13px";
        titre_Choix_Voiture.style.transition = "0.7s";
        titre_Choix_Voiture.style.webkitTransition = "0.7s";
    } 
    else if(window.matchMedia('(min-width:570px) and (max-width: 900px)').matches){
        phrase_recapitulatif_voiture.style.fontSize = "15px";
        phrase_recapitulatif_voiture.style.transition = "0.7s";
        phrase_recapitulatif_voiture.style.webkitTransition = "0.7s";
        titre_Choix_Voiture.style.fontSize = "15px";
        titre_Choix_Voiture.style.transition = "0.7s";
        titre_Choix_Voiture.style.webkitTransition = "0.7s";
    }
    else if(window.matchMedia('(min-width:900px) and (max-width: 1270px)').matches){
        phrase_recapitulatif_voiture.style.fontSize = "17px";
        phrase_recapitulatif_voiture.style.transition = "0.7s";
        phrase_recapitulatif_voiture.style.webkitTransition = "0.7s";
        titre_Choix_Voiture.style.fontSize = "17px";
        titre_Choix_Voiture.style.transition = "0.7s";
        titre_Choix_Voiture.style.webkitTransition = "0.7s";
    }
    else{
        phrase_recapitulatif_voiture.style.fontSize = "20px";
        phrase_recapitulatif_voiture.style.transition = "0.7s";
        phrase_recapitulatif_voiture.style.webkitTransition = "0.7s";
        titre_Choix_Voiture.style.fontSize = "20px";
        titre_Choix_Voiture.style.transition = "0.7s";
        titre_Choix_Voiture.style.webkitTransition = "0.7s";
    }
  }
}

</script>

</html>
<?php }else{
    echo "<center><h2>erreur de connexion veuillez vous reconnecter</h2></center>";
}
?>