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
    <title> Consultation des fiches de frais </title>
    <link rel="stylesheet" href="css/connexion.css">
    <link rel="stylesheet" href="css/pages.css">

</head>
<body id="Affiche_fiche">


 <div class="card">
<?php


include 'Connexion_bdd.php';

  $query = $pdo->query ("select quantite , mois from `lignefraisforfait` where idVisiteur = '".$_SESSION["id"]."'");
  $query2 = $pdo->query ("select libelle , mois , montant from `lignefraishorsforfait` where idVisiteur = '".$_SESSION["id"]."'");

  $resultat = $query->fetchAll();
  $resultat2 = $query2->fetchAll();
  $quantite = array();
  $lebelle = array();
  $mois = array();
  $mois2 = array();
  $montant = array();

    foreach ($resultat as $key => $variable)
    {
      array_push($quantite, $resultat[$key]["quantite"]);
      array_push($mois, $resultat[$key]["mois"]);
  }
    foreach ($resultat2 as $key2 => $variable2)
    {
        array_push($lebelle, $resultat2[$key2]["libelle"]);
        array_push($mois2, $resultat2[$key2]["mois"]);
        array_push($montant, $resultat2[$key2]["montant"]);
    }


      if(isset($_POST["modifetp"]) && isset($_POST["modifkm"]) && isset($_POST["modifnui"]) && isset($_POST["modifrep"]) && isset($_POST["buttonmodif"])){

        $sql8 = ("UPDATE lignefraisforfait SET quantite = '".$_POST["modifrep"]."' WHERE idVisiteur = '".$_SESSION["id"]."' and mois = '".$mois[$_POST["buttonmodif"]-1]."' and idFraisForfait = 'Rep' ");
        $stmt8= $pdo->prepare($sql8);
        $stmt8->execute();

            
          $sql7 = ("UPDATE lignefraisforfait SET quantite = '".$_POST["modifnui"]."' WHERE idVisiteur = '".$_SESSION["id"]."' and mois = '".$mois[$_POST["buttonmodif"]-1]."' and idFraisForfait = 'Nui' ");
          $stmt7= $pdo->prepare($sql7);
          $stmt7->execute();
            
            $sql5 = ("UPDATE lignefraisforfait SET quantite = '".$_POST["modifetp"]."' WHERE idVisiteur = '".$_SESSION["id"]."' and mois = '".$mois[$_POST["buttonmodif"]-1]."' and idFraisForfait = 'ETP' ");
            $stmt5= $pdo->prepare($sql5);
            $stmt5->execute();
            
            $sql6 = ("UPDATE lignefraisforfait SET quantite = '".$_POST["modifkm"]."' WHERE idVisiteur = '".$_SESSION["id"]."' and mois = '".$mois[$_POST["buttonmodif"]-1]."' and idFraisForfait = 'Km' ");
            $stmt6= $pdo->prepare($sql6);
            $stmt6->execute();

    
  
        }

        if(isset($_POST["button"]) && isset($mois[$_POST['button']-1])){
            $pdo->query ("delete from lignefraisforfait where mois = '".$mois[$_POST['button']-1]."' and idVisiteur = '".$_SESSION["id"]."'");
            $pdo->query ("delete from fichefrais where mois = '".$mois[$_POST['button']-1]."' and idVisiteur = '".$_SESSION["id"]."'");
            
        }
        if(isset($_POST["button2"]) && isset($mois2[$_POST['button2']])){
            $pdo->query ("delete from lignefraishorsforfait where montant = '".$montant[$_POST['button2']]."' and libelle = '".$lebelle[$_POST['button2']]."' and idVisiteur = '".$_SESSION["id"]."' and mois = '".$mois2[$_POST['button2']]."'");
        }



        $query = $pdo->query ("select quantite , mois from `lignefraisforfait` where idVisiteur = '".$_SESSION["id"]."'");
        $query2 = $pdo->query ("select libelle , mois , montant from `lignefraishorsforfait` where idVisiteur = '".$_SESSION["id"]."'");
        $query3 = $pdo->query ("select cv from `vehicule` where iduser = '".$_SESSION["id"]."'");

          $resultat = $query->fetchAll();
          $resultat2 = $query2->fetchAll();
          $resultat3 = $query3->fetchAll();
          $quantite = array();
          $lebelle = array();
          $mois = array();
          $mois2 = array();
          $montant = array();
          $cv = array();

            foreach ($resultat as $key => $variable)
            {
                array_push($quantite, $resultat[$key]["quantite"]);
                array_push($mois, $resultat[$key]["mois"]);
            }
              foreach ($resultat2 as $key2 => $variable2)
              {
                  array_push($lebelle, $resultat2[$key2]["libelle"]);
                  array_push($mois2, $resultat2[$key2]["mois"]);
                  array_push($montant, $resultat2[$key2]["montant"]);
              }
                foreach ($resultat3 as $key3 => $variable3)
                {
                    array_push($cv , $resultat3[$key3]["cv"]);
                }

        $query4 = $pdo->query ("select typedevehicule , multiplication , addition  from `vehicule` INNER JOIN `typevehicule` ON vehicule.typevehiculeV = typevehicule.id_vehicule INNER JOIN `bareme` ON bareme.type = typevehicule.id_vehicule where iduser = '".$_SESSION['id']."'");

        $resultat4 = $query4->fetchAll();

        $type = array();
        $multiplication = array();
        $addition = array();
          foreach ($resultat4 as $key4 => $variable4)
          {
              array_push($type , $resultat4[$key4]["typedevehicule"]);
              array_push($multiplication , $resultat4[$key4]["multiplication"]);
              array_push($addition , $resultat4[$key4]["addition"]);
          }
          /* for ($i = 0;count($quantite);$i++){
            
        } */
        $etape = 0;
        $kilométrique = 1;
        $nuitee = 2;
        $repas = 3;

    echo '<center><br><h2 class="titre_elements_present">Afficher les éléments présents dans le forfait</h2><center>
    <table>
      <thead>
        <tr>
          <th><br>&nbsp&nbsp&nbsp&nbsp&nbspForfait étape</th>
          <th><br>&nbsp&nbsp&nbsp&nbsp&nbspForfait Kilométrique</th>
          <th><br>&nbsp&nbsp&nbsp&nbsp&nbspNuitée</th>
          <th><br>&nbsp&nbsp&nbsp&nbsp&nbspHôtel Repas</th><br>
          <th><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspDate
          <th><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMontant Remboursé</th>
        </tr>
      </thead>';
for($nbrquantite =4;count($quantite) >= $nbrquantite;$nbrquantite = $nbrquantite + 4){
    if(isset($type[0])){
        
    if($type[0] == "voiture" ){
        if($cv[0] <= 3){
            $renbousementkm = $quantite[$kilométrique] * $multiplication[0]+$addition[0];
        }
        if($cv[0] == 4){
            $renbousementkm = $quantite[$kilométrique] * $multiplication[1]+$addition[1];
        }
        if($cv[0] == 5){
            $renbousementkm = $quantite[$kilométrique] * $multiplication[2]+$addition[2];
        }
        if($cv[0] == 6){
            $renbousementkm = $quantite[$kilométrique] * $multiplication[3]+$addition[3];
        }
        if($cv[0] > 6){
            $renbousementkm = $quantite[$kilométrique] * $multiplication[4]+$addition[4];
        }
    }
    else if($type[0] == "moto"){
        if($cv[0] <= 2){
            $renbousementkm = $quantite[$kilométrique] * $multiplication[0]+$addition[0];
        }
        if($cv[0] == 3){
            $renbousementkm = $quantite[$kilométrique] * $multiplication[1]+$addition[1];
        }
        if($cv[0] > 4){
            $renbousementkm = $quantite[$kilométrique] * $multiplication[2]+$addition[2];
        }
    }
    }
    else{
        $renbousementkm = $quantite[$kilométrique];
    }
    
    $renbousementnuit = $quantite[$nuitee] * 40;
    $renbousementrepas = $quantite[$repas] *15;
    $renbousement = $renbousementkm+$renbousementnuit+$renbousementrepas;
    
  echo '<tbody>
    <tr>
      <td><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'

      .$quantite[$etape].'</td>
      <td><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'

      .$quantite[$kilométrique].'</td>
      <td><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'

      .$quantite[$nuitee].'</td>
      <td><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'

      .$quantite[$repas].'</td>
      <td><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'

      .$mois[$repas].'</td>
      <td><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'

      .$renbousement.'</td>

      <form action="Affiche_fiche.php" method="post">

      <button class="bouton_valider_affiche_fiche" name ="button" type="submit" value="'.$nbrquantite.'">Supprimer</button>
      </form>
    </tr>
    <tr>
';
  if(date('Ym') <= $mois[$repas]){;
  echo'
      <form action="Affiche_fiche.php" method="post">
      <br>
      &nbsp&nbsp<input class="select-text" name ="modifetp" placeholder="Modifier forfait étape" style="text-align:center"></input></td>
      &nbsp&nbsp<input class="select-text" name ="modifkm" placeholder="Modifier forfait km" style="text-align:center"></input></td>
      &nbsp&nbsp<input class="select-text" name ="modifnui" placeholder="Modifier forfait nuitée" style="text-align:center"></input></td>
      &nbsp&nbsp<input class="select-text" name ="modifrep" placeholder="Modifier forfait resto" style="text-align:center"></input></td>
      </td>

      &nbsp&nbsp<button class="bouton_valider_affiche_fiche" name ="buttonmodif" type="submit" value="'.$nbrquantite.'">Modifier</button>
      </form>
   ';};echo'
    </tr>
<tr></tr>



  </tbody>
';
  $etape = $etape + 4;
  $kilométrique = $kilométrique + 4;
  $nuitee = $nuitee + 4;
  $repas = $repas + 4;}'
</table>

</center>';

  echo '<center>

<table>
<br></br></br></br>
<h2 class="titre_nouvel_element_frais_hors_forfait">Nouvel élément Frais Hors Frais</h2>
  <thead><br>
      <th>Libelle&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
      <th>&nbsp&nbspMois&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
      <th>Montant&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
 
  </thead>';
  for($nbrquantite2 =0;count($lebelle) > $nbrquantite2;$nbrquantite2++ ){
      
      echo '<tbody>
    <tr>
      <td>'.$lebelle[$nbrquantite2].'</td>
      <td>'.$mois2[$nbrquantite2].'</td>
      <td>'.$montant[$nbrquantite2].' euros</td>
      <form action="Affiche_fiche.php" method="post">
      <td><button class="bouton_valider_affiche_fiche" name ="button2" type="submit" value="'.$nbrquantite2.'">Supprimer</button></td>
      </form>
          
    </tr>
          
  </tbody>
';
      $etape = $etape + 4;
      $kilométrique = $kilométrique + 4;
      $nuitee = $nuitee + 4;
      $repas = $repas + 4;}'
</table>
</center>';

    
?>


</div>
</body>






<script>
  ////////////////// Déclaration des variables //////////////////
  const titre_Elements_Presents = document.querySelector(".titre_elements_present");

  const titre_Nouvel_Element_Frais_Hors_Forfait = document.querySelector(".titre_nouvel_element_frais_hors_forfait");
////////////////////////////////

  // ADDEventListener On lie l'événement resize à la fonction //
  window.addEventListener('resize', redimensionnement, false);
  /////////////////////////


  /////////////// DESIGN /////////////////
  titre_Elements_Presents.style.textShadow = "0px -1px 4px white, 0px -2px 10px white, 0px -10px 20px blue, 0px -18px 40px purple";
    
  titre_Nouvel_Element_Frais_Hors_Forfait.style.textShadow = "0px -1px 4px white, 0px -2px 10px white, 0px -10px 20px blue, 0px -18px 40px purple";
    ////////////////////////////////

  
///////////// RESPONSIVE DESIGN ////////////////

// Fonction exécutée au redimensionnement, elle est executée à chaque écoute de changement de dimension de la fenêtre //
function redimensionnement() {
  if("matchMedia" in window) { // Détection
    if(window.matchMedia('(min-width:400px) and (max-width: 700px)').matches) {
        titre_Elements_Presents.style.fontSize = "20px";
        titre_Elements_Presents.style.transition = "0.7s";
        titre_Elements_Presents.style.webkitTransition = "0.7s";
        titre_Nouvel_Element_Frais_Hors_Forfait.style.fontSize = "20px";
        titre_Nouvel_Element_Frais_Hors_Forfait.style.transition = "0.7s";
        titre_Nouvel_Element_Frais_Hors_Forfait.style.webkitTransition = "0.7s";
    } 
    else if(window.matchMedia('(min-width:700px) and (max-width: 1200px)').matches){
        titre_Elements_Presents.style.fontSize = "22px";
        titre_Elements_Presents.style.transition = "0.7s";
        titre_Elements_Presents.style.webkitTransition = "0.7s";
        titre_Nouvel_Element_Frais_Hors_Forfait.style.fontSize = "22px";
        titre_Nouvel_Element_Frais_Hors_Forfait.style.transition = "0.7s";
        titre_Nouvel_Element_Frais_Hors_Forfait.style.webkitTransition = "0.7s";
    }
    else{
        titre_Elements_Presents.style.fontSize = "24px";
        titre_Elements_Presents.style.transition = "0.7s";
        titre_Elements_Presents.style.webkitTransition = "0.7s";
        titre_Nouvel_Element_Frais_Hors_Forfait.style.fontSize = "24px";
        titre_Nouvel_Element_Frais_Hors_Forfait.style.transition = "0.7s";
        titre_Nouvel_Element_Frais_Hors_Forfait.style.webkitTransition = "0.7s";
    }
  }
}
/////////////////////////////////
</script>

</html>
<?php }else{
    echo "<center><h2>Erreur de connexion BDD</h2></center>";
}?>