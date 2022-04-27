<?php 
include 'Menu.php';
include 'bas_de_page.php';
if(!isset($_SESSION)){
    session_start();
}

if($_SESSION['id'] !== 'non'){
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(!isset($_POST['Repas']) or !isset($_POST['Nuit']) or !isset($_POST['Etape']) or !isset($_POST['Km']) or $_POST['Km'] == null or $_POST['Etape'] == null
        or $_POST['Nuit'] == null or $_POST['Repas'] == null){
    }
    
        
    
    
    include 'Connexion_bdd.php';
    
    $query = $pdo->query ("select idVisiteur , mois , type from `fichefrais` where idVisiteur = '".$_SESSION["id"]."' and mois =  '".date('Ym')."'   ");
    
    $query2 = $pdo->query ("select idVisiteur , mois from `lignefraisforfait` where idVisiteur = '".$_SESSION["id"]."' and mois =  '".date('Ym')."'   ");
    
    $query3 = $pdo->query ("select idVisiteur , mois from `lignefraishorsforfait` where idVisiteur = '".$_SESSION["id"]."' and mois =  '".date('Ym')."'   ");
    
    $resultat = $query->fetchAll();
    $resultat2 = $query2->fetchAll();
    $resultat3 = $query3->fetchAll();
    //existe l'id et le mois dans fichefrais
    $existe = null;
    $existe2 = null;
    $existe22 = null;
    //existe l'id et le mois dans lignefraisforfait
    $existe3 = null;
    $existe4 = null;
    //existe l'id et le mois dans lignefriashorsforfait
    $existe5 = null;
    $existe6 = null;
    foreach ($resultat as $key => $variable)
    {
        $existe = $resultat[$key]["idVisiteur"];
        $existe2 = $resultat[$key]["mois"];
        $existe22 = $resultat[$key]["type"];
    }
    foreach ($resultat2 as $key => $variable2)
    {
        $existe3 = $resultat2[$key]["idVisiteur"];
        $existe4 = $resultat2[$key]["mois"];
    }
    foreach ($resultat3 as $key => $variable3)
    {
        $existe5 = $resultat3[$key]["idVisiteur"];
        $existe6 = $resultat3[$key]["mois"];
    }
    if($existe22[0] != 'frais' and $existe22[0] != 'horsfrais'){
            
        
        if(strlen($existe) == 0 and strlen($existe2) == 0 ){
            
            if($_POST['valider'] == "valider" ){
            $sqlexiste = ("insert into fichefrais (`idVisiteur`,`mois`,`type`) VALUES ('".$_SESSION["id"]."','".date('Ym')."','frais')");
            }
            else{
            $sqlexiste = ("insert into fichefrais (`idVisiteur`,`mois`,`type`) VALUES ('".$_SESSION["id"]."','".date('Ym')."','horsfrais')");
            }
            
            $stmte = $pdo->prepare($sqlexiste);
            $stmte->execute();
        }
    }
    
    if($_POST['valider'] == "valider"){
        
        if(strlen($existe3) == 0 and strlen($existe4) == 0){
            
        
        $sql = ("insert into lignefraisforfait VALUES ('".$_SESSION["id"]."','".date('Ym')."','ETP','".$_POST['Etape']."')");
        $stmt= $pdo->prepare($sql);
        $stmt->execute();
        $sql2 = ("insert into lignefraisforfait VALUES ('".$_SESSION["id"]."','".date('Ym')."','KM','".$_POST['Km']."')");
        $stmt2= $pdo->prepare($sql2);
        $stmt2->execute();
        $sql3 = ("insert into lignefraisforfait VALUES ('".$_SESSION["id"]."','".date('Ym')."','NUI','".$_POST['Nuit']."')");
        $stmt3= $pdo->prepare($sql3);
        $stmt3->execute();
        $sql4 = ("insert into lignefraisforfait VALUES ('".$_SESSION["id"]."','".date('Ym')."','REP','".$_POST['Repas']."')");
        $stmt4= $pdo->prepare($sql4);
        $stmt4->execute();
        }
        else{
            $sql5 = ("UPDATE lignefraisforfait SET quantite = '".$_POST['Etape']."' WHERE idVisiteur = '".$_SESSION["id"]."' and mois = '".date('Ym')."' and idFraisForfait = 'ETP' ");
            $stmt5= $pdo->prepare($sql5);
            $stmt5->execute();
            
            $sql6 = ("UPDATE lignefraisforfait SET quantite = '".$_POST['Km']."' WHERE idVisiteur = '".$_SESSION["id"]."' and mois = '".date('Ym')."' and idFraisForfait = 'Km' ");
            $stmt6= $pdo->prepare($sql6);
            $stmt6->execute();
            
            $sql7 = ("UPDATE lignefraisforfait SET quantite = '".$_POST['Nuit']."' WHERE idVisiteur = '".$_SESSION["id"]."' and mois = '".date('Ym')."' and idFraisForfait = 'Nui' ");
            $stmt7= $pdo->prepare($sql7);
            $stmt7->execute();
            
            $sql8 = ("UPDATE lignefraisforfait SET quantite = '".$_POST['Repas']."' WHERE idVisiteur = '".$_SESSION["id"]."' and mois = '".date('Ym')."' and idFraisForfait = 'Rep' ");
            $stmt8= $pdo->prepare($sql8);
            $stmt8->execute();
        }
        
        
        
    }

    else{

        if(isset($_POST['Libelle']) and isset($_POST['montant'])){
         $sql = ("insert into lignefraishorsforfait (`idVisiteur`,`mois`,`libelle`,`montant`)  VALUES ('".$_SESSION["id"]."','".date('Ym')."','".$_POST['Libelle']."','".$_POST['montant']."')");
         $stmt= $pdo->prepare($sql);
         $stmt->execute();
    }
         
        /*if(strlen($existe5) == 0 and strlen($existe6) == 0){
        $sql = ("insert into lignefraishorsforfait (`idVisiteur`,`mois`,`libelle`,`montant`)  VALUES ('".$_SESSION["id"]."','".date('Ym')."','".$_POST['Libelle']."','".$_POST['montant']."')");
        $stmt= $pdo->prepare($sql);
        $stmt->execute();
    }

        else{

            $sql2 = ("UPDATE lignefraishorsforfait SET libelle = '".$_POST['Libelle']."' , montant = '".$_POST['montant']."' WHERE idVisiteur = '".$_SESSION["id"]."' and mois = '".date('Ym')."'");
            $stmt2= $pdo->prepare($sql2);
            $stmt2->execute();
        }*/
        
       
    }
    $_POST['Repas'] = null;
    $_POST['Nuit'] = null;
    $_POST['Etape'] = null;
    $_POST['Km'] = null;

    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Remplissage des fiches de frais</title>
    <link rel="stylesheet" href="css/connexion.css">
    <link rel="stylesheet" href="css/pages.css">


</head>

<body id="Renseignement_fiche">

        

        
             <div class="card">
            <form method="post">
                <center>

                <h2 class="titre_remplir_fiche">Remplir ma fiche du mois de Avril </h2>
              
                <br /></br>
                    <div class="titres_devant_les_champs">
                        Repas Restaurant : <input class="select-text" type="text" name="Repas" value="" style="text-align:center;font-weight:bold"/> <br><br>
                        Nuitée à l'hôtel : <input class="select-text" type="text" name="Nuit" value="" style="text-align:center;font-weight:bold"/> <br><br>
                        Forfait Étape : <input class="select-text" type="text" name="Etape" value="" style="text-align:center;font-weight:bold"/> <br><br>
                        Forfait Kilométrique : <input class="select-text" type="text" name="Km" value="" style="text-align:center;font-weight:bold"/>
                    </div>
                <br />
                <div class="slot"></div>
                <button class="bouton_valider_affiche_fiche" type="submit" name="valider" value="valider">valider</button>
                <button class="bouton_valider_affiche_fiche" name="Effacer">Effacer</button>

                <!-- <input  class="button_valider" type="submit" name="valider" value="valider"  /> -->
            </form>
        </div>
        </center>
        <div class="card">
            <FORM method="post">

            <center>
                <br><br></br>
                <h2 class="titre_remplir_fiche">Nouvel élément Frais Hors Frais</h2>
                <br />
               
                <br />

               
                <br /><br />
                <div class="titres_devant_les_champs">
                Libelle : <input class="select-text" type="text" name="Libelle" value="" style="text-align:center;font-weight:bold"/>
                Montant : <input class="select-text" type="text" name="montant" value="" style="text-align:center;font-weight:bold"/>
                </div>
                <br /><br />
                <div class="slot"></div>
                <button class="bouton_valider_affiche_fiche" type="submit" name="valider" value="valider2">valider</button>
                <!-- <input class="button_valider" type="submit" name="valider" value="valider"  /> -->


                <!-- <input class="button_valider" type="submit" name="valider" value="valider"  /> -->


                </center>
            </FORM>
        </div>
    </div>

    <!-- ======= scripts ====== -->
    
</body>









<script>
/// Déclaration des variables ///
    const titre_champs = document.querySelector(".titres_devant_les_champs");

    const titre_champs_1 = document.querySelector(".titres_devant_les_champs_1");
////////////////////////////////

    // ADDEventListener On lie l'événement resize à la fonction //
window.addEventListener('resize', redimensionnement, false);


///// RESPONSIVE DESIGN /////
    // Fonction exécutée au redimensionnement, elle est executée à chaque écoute de changement de dimension de la fenêtre //
function redimensionnement() {

  if("matchMedia" in window) { // Détection
    if(window.matchMedia('(min-width:400px) and (max-width: 600px)').matches){
        titre_champs.style.fontSize = "14px";
        titre_champs.style.transition = "0.7s";
        titre_champs.style.webkitTransition = "0.7s";
        titre_champs_1.style.fontSize = "14px";
        titre_champs_1.style.transition = "0.7s";
        titre_champs_1.style.webkitTransition = "0.7s";
    }
    else{
        titre_champs.style.fontSize = "17px";
        titre_champs.style.transition = "0.7s";
        titre_champs.style.webkitTransition = "0.7s";
        titre_champs_1.style.fontSize = "17px";
        titre_champs_1.style.transition = "0.7s";
        titre_champs_1.style.webkitTransition = "0.7s";
    }
  }
}
/////////////////////////////////
</script>

</html>
<?php }else{
    echo "<center><h2>erreur de connexion veuillez vous reconnecter</h2></center>";
    
}?>