<?php 
if(!isset($_SESSION)){
    session_start();
}
?>
<html>
<head>
    <meta http-equiv="refresh" content="3000;url=Page_connexion.php" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/menu.css">
    <script src="JS/scriptI.js" defer></script>
</head>
<body>

    
       
     <header>
    

      <div class="slot"></div>
        
<nav class="menu">

    <div class="logo">
        <img src="images/logo2.png"><!-- Image du logo -->
    </div>

            <div class="icone_menu"> &equiv; </div> <!-- Icone du menu -->
            <ul class="liens-menus"><!-- Tous les liens du menu -->
                <li>
                <?php 
				 if($_SESSION['role'] !== 2){
				     ?>
				 
                    <a href = 'Accueil.php'>Accueil</a>
                    
                    
                    <?php 
                   if($_SESSION['role'] == 0){
                       echo "<a href = 'Remplir_fiche.php'>Remplir une fiche de frais</a> ";
                       echo "<a href = 'Affiche_fiche.php' class=''><img id='logo3' class='mini-logo'>Consulter mes fiches de frais </a>";
                       echo "<a href = 'Vehicule.php' class=''><img id='logo5' class='mini-logo' >Saisir un véhicule</a>";
                   }
                   else if ($_SESSION['role'] == 1){
                       echo "<a href = 'Affiche_fiche_comptable.php' class=''><img id='logo3' class='mini-logo'>Consulter/v&#233;rifier les fiches de frais</a>";
                   }
                   ?>
                    
                    <a href = 'Page_connexion.php' class=''><img id="logo4" class="mini-logo">Déconnexion</a>
                    <?php 
                    }
                    else{
                        echo'<a href = "Accueil.php" class=""><img id="logo1" class="mini-logo" >Accueil</a>
                            ';
                    }
                    ?>
                </li>

            </ul>
</nav>
</header>

    </body>
<script>
// Déclaration des variables //
    var icone_menu = document.querySelector(".icone_menu");
    var liens_menu = document.querySelector(".liens-menus");
    var liens = document.querySelectorAll(".liens-menus li");
///////////////////////////////
    
// ADDEventListener //
    icone_menu.addEventListener('click', ()=>{ // Lorsque l'on clique sur l'icone du menu //
        liens_menu.classList.toggle("open");// RESPONSIVE DESIGN => Il s'agit d'une sorte d'interrupteur, il permet ainsi d'ouvrir le menu en appelant la classe CSS open //
        Apparition_liens();//Appel de la fonction //
        Changement_Bouton();//Appel de la fonction //
    }); 


/////// DESIGN ///////
    // Fonction pour changer la couleur de l'icone du menu en fonction de l'ouverture/fermeture du menu //
function Changement_Bouton() {
    if(liens_menu.classList.contains("open")){// Si le menu est ouvert alors... //
        icone_menu.style.color = 'white';
    }else {
        icone_menu.style.color = 'rgb(7, 5, 46)';
    }
}
////////////////////////


//// RESPONSIVE DESIGN /////
function Apparition_liens() { //Animate pour l'apparition des liens //
    liens.forEach(liens => {
        liens.classList.toggle("apparition");
    });
}
//////////////////////////

    </script>
</html>
