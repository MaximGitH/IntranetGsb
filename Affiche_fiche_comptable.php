<?php 
include 'Pdf.php';
if(isset($_POST['pdf'])){
    creerpdf($_POST['etppdf'],$_POST['kmpdf'],$_POST['nuipdf'],$_POST['reppdf'],$_POST['moispdf'],$_POST['renboursementpdf'],$_POST['nompdf'],$_POST['prenompdf']);
}
include 'Menu.php';


if(!isset($_SESSION)){
    session_start();
}

if($_SESSION['id'] !== 'non'){
    ?>


<html>
    <link rel="stylesheet" href="./css/connexion.css">
    <link rel="stylesheet" href="./css/pages.css">

    <body id="Affiche_fiche_comptable">
 <div class="card">
<?php

include 'Connexion_bdd.php';


    $query = $pdo->query ("select idVisiteur ,quantite , mois from `lignefraisforfait`");
    $query2 = $pdo->query ("select libelle , mois , montant  from `lignefraishorsforfait`");

    $resultat = $query->fetchAll();
    $resultat2 = $query2->fetchAll();

    $quantite = array();
    $lebelle = array();
    $mois = array();
    $mois2 = array();
    $montant = array();
    $id = array();

    foreach ($resultat as $key => $variable)
    {
        array_push($quantite, $resultat[$key]["quantite"]);
        array_push($mois, $resultat[$key]["mois"]);
        array_push($id, $resultat[$key]["idVisiteur"]);
    }
    foreach ($resultat2 as $key2 => $variable2)
    {
        
        array_push($lebelle, $resultat2[$key2]["libelle"]);
        array_push($mois2, $resultat2[$key2]["mois"]);
        array_push($montant, $resultat2[$key2]["montant"]);
    }


    if(isset($_POST["modifetp"]) && isset($_POST["modifkm"]) && isset($_POST["modifnui"]) && isset($_POST["modifrep"]) && isset($_POST["buttonmodif"])){
        
        $sql5 = ("UPDATE lignefraisforfait SET quantite = '".$_POST["modifetp"]."' WHERE idVisiteur = '".$id[$_POST["buttonmodif"]-1]."' and mois = '".$mois[$_POST["buttonmodif"]-1]."' and idFraisForfait = 'ETP' ");
        $stmt5= $pdo->prepare($sql5);
        $stmt5->execute();
        
        $sql6 = ("UPDATE lignefraisforfait SET quantite = '".$_POST["modifkm"]."' WHERE idVisiteur = '".$id[$_POST["buttonmodif"]-1]."' and mois = '".$mois[$_POST["buttonmodif"]-1]."' and idFraisForfait = 'Km' ");
        $stmt6= $pdo->prepare($sql6);
        $stmt6->execute();
        
        $sql7 = ("UPDATE lignefraisforfait SET quantite = '".$_POST["modifnui"]."' WHERE idVisiteur = '".$id[$_POST["buttonmodif"]-1]."' and mois = '".$mois[$_POST["buttonmodif"]-1]."' and idFraisForfait = 'Nui' ");
        $stmt7= $pdo->prepare($sql7);
        $stmt7->execute();
        
        $sql8 = ("UPDATE lignefraisforfait SET quantite = '".$_POST["modifrep"]."' WHERE idVisiteur = '".$id[$_POST["buttonmodif"]-1]."' and mois = '".$mois[$_POST["buttonmodif"]-1]."' and idFraisForfait = 'Rep' ");
        $stmt8= $pdo->prepare($sql8);
        $stmt8->execute();
    }

    if(isset($_POST["button"]) && isset($mois[$_POST['button']-1])){
        $pdo->query ("delete from lignefraisforfait where mois = '".$mois[$_POST['button']-1]."' and idVisiteur = '".$id[$_POST["button"]-1]."'");
        $pdo->query ("delete from fichefrais where mois = '".$mois[$_POST['button']-1]."' and idVisiteur = '".$id[$_POST["button"]-1]."'");
        
    }
    if(isset($_POST["button2"]) && isset($mois2[$_POST['button2']])){
        $pdo->query ("delete from lignefraishorsforfait where montant = '".$montant[$_POST['button2']]."' and libelle = '".$lebelle[$_POST['button2']]."' and mois = '".$mois2[$_POST['button2']]."'");
    }
    if(isset($_POST["buttonconfirme2"]) && isset($mois2[$_POST['buttonconfirme2']])){
        $sql9 = ("UPDATE lignefraishorsforfait SET etat = 'valide' where libelle ='".$lebelle[$_POST['buttonconfirme2']]."' and montant ='".$montant[$_POST['buttonconfirme2']]."'");
        $stmt9= $pdo->prepare($sql9);
        $stmt9->execute();
    }
    if(isset($_POST["buttonrefuse2"]) && isset($mois2[$_POST['buttonrefuse2']])){
        $sql10 = ("UPDATE lignefraishorsforfait SET etat = 'refus' where libelle ='".$lebelle[$_POST['buttonrefuse2']]."' and montant ='".$montant[$_POST['buttonrefuse2']]."'");
        $stmt10= $pdo->prepare($sql10);
        $stmt10->execute();
    }
    if(isset($_POST["buttonconfirme"]) && isset($mois[$_POST['buttonconfirme']-1])){
        $sql9 = ("UPDATE fichefrais SET etat = 'valide' where mois ='".$mois[$_POST['buttonconfirme']-2]."'and idVisiteur ='".$id[$_POST['buttonconfirme']-2]."'");
        $stmt9= $pdo->prepare($sql9);
        $stmt9->execute();
    }
    if(isset($_POST["buttonrefuse"]) && isset($mois[$_POST['buttonrefuse']-1])){
        $sql10 = ("UPDATE fichefrais SET etat = 'refus' where mois ='".$mois[$_POST['buttonrefuse']-2]."'and idVisiteur ='".$id[$_POST['buttonrefuse']-2]."'");
        $stmt10= $pdo->prepare($sql10);
        $stmt10->execute();
    }



    $query = $pdo->query ("select quantite , l.mois , nom , prenom  from lignefraisforfait l inner join fichefrais f on l.idVisiteur = f.idVisiteur inner join utilisateur u on u.id = f.idVisiteur");
    $query2 = $pdo->query ("select libelle , mois , montant , etat from `lignefraishorsforfait`");
    $query3 = $pdo->query ("select cv  from `vehicule`");
    $query4 = $pdo->query ("select etat from `fichefrais` where type = 'frais'");
    $query5 = $pdo->query ("select typedevehicule , multiplication , addition  from `vehicule` INNER JOIN `typevehicule` ON vehicule.typevehiculeV = typevehicule.id_vehicule INNER JOIN `bareme` ON bareme.type = typevehicule.id_vehicule where iduser = '".$_SESSION['id']."'");


    $resultat = $query->fetchAll();
    $resultat2 = $query2->fetchAll();
    $resultat3 = $query3->fetchAll();
    $resultat4 = $query4->fetchAll();
    $resultat5 = $query5->fetchAll();

    $type = array();
    $multiplication = array();
    $addition = array();
    $quantite = array();
    $lebelle = array();
    $mois = array();
    $mois2 = array();
    $montant = array();
    $cv = array();
    $etat = array();
    $etat2 = array();
    $nom = array();
    $prenom = array();

    foreach ($resultat as $key => $variable)
    {
        array_push($quantite, $resultat[$key]["quantite"]);
        array_push($mois, $resultat[$key]["mois"]);
        array_push($nom, $resultat[$key]["nom"]);
        array_push($prenom, $resultat[$key]["prenom"]);
        
    }
    foreach ($resultat2 as $key2 => $variable2)
    {
        array_push($etat, $resultat2[$key2]["etat"]);
        array_push($lebelle, $resultat2[$key2]["libelle"]);
        array_push($mois2, $resultat2[$key2]["mois"]);
        array_push($montant, $resultat2[$key2]["montant"]);
    }
    foreach ($resultat3 as $key3 => $variable3)
    {
        array_push($cv , $resultat3[$key3]["cv"]);
    }
    foreach ($resultat4 as $key4 => $variable4)
    {
        array_push($etat2, $resultat4[$key4]["etat"]);
    }
    foreach ($resultat5 as $key5 => $variable5)
    {
        array_push($type , $resultat5[$key5]["typedevehicule"]);
        array_push($multiplication , $resultat5[$key5]["multiplication"]);
        array_push($addition , $resultat5[$key5]["addition"]);
    }
/* for ($i = 0;count($quantite);$i++){
    
} */      
    $etape = 1;
    $kilométrique = 2;
    $nuitee = 3;
    $repas = 4;
    $i = 0;

    echo '<div class = "block"><center><h2 class="titre_comptable_1">Eléments présents dans le forfait : Consultation des fiches visiteurs </h2>
    <table>
    <thead>
    
    <th><br>&nbsp&nbsp&nbsp&nbsp&nbsp      Forfait étape</th>
    <th><br>&nbsp&nbsp&nbsp&nbsp&nbsp      Forfait Kilométrique</th>
    <th><br>&nbsp&nbsp&nbsp&nbsp&nbsp      Nuitée</th>
    <th><br>&nbsp&nbsp&nbsp&nbsp&nbsp      Hôtel Repas</th><br>
    <th><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp      Date
    <th><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp      Montant Remboursé</th>

  </thead>';
for($nbrquantite =4;count($quantite) >= $nbrquantite;$nbrquantite = $nbrquantite +4 ){
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
    $renbousementrepas = $quantite[$repas] * 15;
    $renbousement = $renbousementkm+$renbousementnuit+$renbousementrepas;
    
  echo '<tbody>
    <tr>
      <td>'.$quantite[$etape].'</td>
      <td>'.$quantite[$kilométrique].'</td>
      <td>'.$quantite[$nuitee].'</td>
      <td>'.$quantite[$repas].'</td>
      <td>'.$mois[$repas].'</td>
      <td>'.$renbousement.'</td>

      <form action="Affiche_fiche_comptable.php" method="post">

      <td><button name ="button" type="submit" value="'.$nbrquantite.'">supprimer</button></td>
<tr>';
  if($etat2[$i] == 'valide'){
      echo'<td><button   class="bouton_valider_affiche_fiche"  name ="buttonconfirme" type="submit" value="'.($nbrquantite).'"> Confirmer</button></td>';
  }
  else{
      echo'<td><button  class="bouton_valider_affiche_fiche"name ="buttonconfirme" type="submit" value="'.($nbrquantite).'"> Confirmer</button></td>';
  }
  
  if($etat2[$i] == 'refus'){
      echo'<td><button  class="bouton_valider_affiche_fiche" name ="buttonrefuse" type="submit" value="'.($nbrquantite).'">  Refuser</button></td>';
  }
  else{
      echo'<td><button  class="bouton_valider_affiche_fiche" name ="buttonrefuse" type="submit" value="'.($nbrquantite).'">  Refuser</button></td>';
  }
  
  echo'
<td><button  class="bouton_valider_affiche_fiche" name ="pdf" type="submit" >PDF</button></td>  

   <td><input style="display: none;"  name ="etppdf"  value='.$quantite[$etape].'></input></td>  
<td><input style="display: none;" name ="kmpdf"  value='.$quantite[$kilométrique].'></input></td>  
<td><input style="display: none;" name ="nuipdf"  value='.$quantite[$nuitee].'></input></td>  
<td><input style="display: none;" name ="reppdf" value='.$quantite[$repas].'></input></td>  
<td><input style="display: none;" name ="moispdf"  value='.$mois[$repas].'></input></td>  
<td><input style="display: none;" name ="renboursementpdf"  value='.$renbousement.'></input></td>  
<td><input style="display: none;" name ="nompdf"  value='.$nom[$repas].'></input></td>  
<td><input style="display: none;" name ="prenompdf"  value='.$prenom[$repas].'></input></td> 
   
      </tr></form>

    </tr>

    <tr>
';
  if(date('Ym') <= $mois[$repas]){;
  echo'
      <form action="Affiche_fiche_comptable.php" method="post">
      <td><input name ="modifetp"></input></td>
      <td><input name ="modifkm"></input></td>
      <td><input name ="modifnui"></input></td>
      <td><input name ="modifrep"></input></td>
      <td></td>
      
      <td><button  class="bouton_valider_affiche_fiche" name ="buttonmodif" type="submit" value="'.$nbrquantite.'">Modifier</button></td>
      </form>
   ';};echo'
    </tr>
<tr></tr>



  </tbody>
';
  $i = $i + 1;
  $etape = $etape + 4;
  $kilométrique = $kilométrique + 4;
  $nuitee = $nuitee + 4;
  $repas = $repas + 4;}'
</table>
</center></div>';
  
  
  
  echo '<center><br>
<table>
<br>
<h2 class="titre_comptable_2">Eléments hors forfait : Visiteur(s)</h2>
  <thead>
    <tr>
    <br>
      <th>Libelle&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
      <th>Mois&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
      <th>Montant&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
    </tr>
  </thead>';
  for($nbrquantite2 =0;count($lebelle) > $nbrquantite2;$nbrquantite2++ ){
      
      echo '<tbody>
    <tr>
      <td>'.$lebelle[$nbrquantite2].'</td>
      <td>'.$mois2[$nbrquantite2].'</td>
      <td>'.$montant[$nbrquantite2].' euro(s)</td>
      <form action="Affiche_fiche_comptable.php" method="post">
      <td>&nbsp&nbsp&nbsp<button  class="bouton_valider_affiche_fiche" name ="button2" type="submit" value="'.$nbrquantite2.'">Supprimer</button></td>';
      if($etat[$nbrquantite2] == 'valide'){
          echo'<td><button   class="bouton_valider_affiche_fiche"  name ="buttonconfirme2" type="submit" value="'.$nbrquantite2.'"> Confirmer</button></td>';
      }
      else{
          echo'<td><button  class="bouton_valider_affiche_fiche" name ="buttonconfirme2" type="submit" value="'.$nbrquantite2.'"> Confirmer</button></td>';
      }
      
      if($etat[$nbrquantite2] == 'refus'){
          echo'<td><button  class="bouton_valider_affiche_fiche" name ="buttonrefuse2" type="submit" value="'.$nbrquantite2.'">  Refuser</button></td>';
      }
      else{
          echo'<td><button  class="bouton_valider_affiche_fiche" name ="buttonrefuse2" type="submit" value="'.$nbrquantite2.'">  Refuser</button></td>';
      }
      echo'
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

  <!-- <form action="Affiche_fiche_comptable.php" method="post">  
     
    <input type="text"  >  
    <input type="submit" name="pdf" value="55">
  </form>  --> 




</div>
</div>
</body>







<script>
// Déclaration des variables //
    const titre_comptable = document.querySelector(".titre_comptable_1");
    const titre_comptable_2 = document.querySelector(".titre_comptable_2");
//////////////////////////////

// ADDEventListener On lie l'événement resize à la fonction //
  window.addEventListener('resize', redimensionnement, false);
//////////////////////////////////////////////////


///////////////// DESIGN DE LA PAGE /////////////

    titre_comptable.style.textDecoration = "underline dotted";
    titre_comptable.style.textShadow = "0px 0px 4px white, 4px 0px 10px white, 0px 0px 20px white";
    titre_comptable.style.marginTop = "30px";
    titre_comptable.style.color = "#131688";

    titre_comptable_2.style.color = "#131688";
    titre_comptable_2.style.textDecoration = "underline dotted";
    titre_comptable_2.style.textShadow = "0px 0px 4px white, 4px 0px 10px white, 0px 0px 20px white";
    titre_comptable_2.style.marginTop = "30px";
    titre_comptable_2.style.marginBottom = "12px";
  ///////////////////////////////////////////  


////////////// RESPONSIVE DESIGN ///////////////////////

// Fonction exécutée au redimensionnement, elle est executée à chaque écoute de changement de dimension de la fenêtre //
function redimensionnement() {
  if("matchMedia" in window) { // Détection
    if(window.matchMedia('(min-width:400px) and (max-width: 600px)').matches) {
        titre_comptable.style.fontSize = "16px";
        titre_comptable.style.transition = "0.7s";
        titre_comptable.style.webkitTransition = "0.7s";
        titre_comptable_2.style.fontSize = "16px";
        titre_comptable_2.style.transition = "0.7s";
        titre_comptable_2.style.webkitTransition = "0.7s";
    } 
    else if(window.matchMedia('(min-width:600px) and (max-width: 800px)').matches){
        titre_comptable.style.fontSize = "19px";
        titre_comptable.style.transition = "0.7s";
        titre_comptable.style.webkitTransition = "0.7s";
        titre_comptable_2.style.fontSize = "19px";
        titre_comptable_2.style.transition = "0.7s";
        titre_comptable_2.style.webkitTransition = "0.7s";
    }
    else if(window.matchMedia('(min-width:800px) and (max-width: 1200px)').matches){
        titre_comptable.style.fontSize = "22px";
        titre_comptable.style.transition = "0.7s";
        titre_comptable.style.webkitTransition = "0.7s";
        titre_comptable_2.style.fontSize = "22px";
        titre_comptable_2.style.transition = "0.7s";
        titre_comptable_2.style.webkitTransition = "0.7s";
    }
    else{
        titre_comptable.style.fontSize = "24px";
        titre_comptable.style.transition = "0.7s";
        titre_comptable.style.webkitTransition = "0.7s";
        titre_comptable_2.style.fontSize = "24px";
        titre_comptable_2.style.transition = "0.7s";
        titre_comptable_2.style.webkitTransition = "0.7s";
    }
  }
}
/////////////////////////////////////////////
</script>

</html>
<?php }else{
    echo "<center><h2>erreur de connexion veuillez vous reconnecter</h2></center>";
}?>