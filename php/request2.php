<!DOCTYPE html>
<html>
    <head>
        <?php
       
            ini_set('display_errors','on');
            error_reporting(E_ALL);
        ?>
        <title>Mini-Projet</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
 
    <body>
        <header class="header">
          <span class="header-contenu">Projet</span>
      
          <a href="../back.php"> <input type="button" class="header-contenu-g" value="Back"> </a>
          <a href="../generator.php"> <input type="button" class="header-contenu-g" value="Générateur de données"> </a>
          <a href="../index.php"> <input type="button" class="header-contenu-g" value="Accueil"> </a>
       
        </header>
        <?php
            
          require_once('database.php');

          if (isset($_POST["envoi2"])){
            $db =dbConnect();
            //echo $_POST['somme'];
            // $compteur=0;
            for ($i=0; $i<$_POST['somme']; $i++) {
              
              switch ($_POST['type_champ'.$i]){
                case "Varchar":
                case "Char":
                  $repertoireDestination = dirname(__FILE__)."/";
                  $nomDestination = $_FILES["monfichier".$i]["name"]."_".date("YmdHis").".txt";
                  

                  if (is_uploaded_file($_FILES["monfichier".$i]["tmp_name"])) {
                    if (rename($_FILES["monfichier".$i]["tmp_name"],$repertoireDestination.$nomDestination)) {
                    } else {
                      echo "Le déplacement du fichier temporaire a échoué"." vérifiez l'existence du répertoire ".$repertoireDestination;
                    }          
                  } else {
                    echo "Le fichier n'a pas été uploadé (trop gros ?)";
                  }
                  

                  $rep = dbChampStr($db,$_POST['nom_champ'.$i],$_POST['type_champ'.$i],$_POST['libelle'],$_POST['longueur'.$i],$nomDestination);
                  if (!$rep) {
                    echo "Erreur de connexion à la base de donnée";
                    exit();
                  }

                break;
                case "Date":
                case "DateTime":
                case "Time":
                  if ($_POST['val_min_date'.$i]>$_POST['val_max_date'.$i]){
                    $datechange = $_POST['val_max_date'.$i];
                    $_POST['val_max_date'.$i] = $_POST['val_min_date'.$i];
                    $_POST['val_min_date'.$i]= $datechange;
                    
                    $rep = dbChampDate($db,$_POST['nom_champ'.$i],$_POST['type_champ'.$i],$_POST['libelle'],$_POST['val_min_date'.$i],$_POST['val_max_date'.$i]);
                    if (!$rep) {
                      echo "Erreur de connexion à la base de donnée";
                      exit();
                    }
                  }else {
                    $rep = dbChampDate($db,$_POST['nom_champ'.$i],$_POST['type_champ'.$i],$_POST['libelle'],$_POST['val_min_date'.$i],$_POST['val_max_date'.$i]);
                    if (!$rep) {
                      echo "Erreur de connexion à la base de donnée";
                      exit();
                    }
                  }  
                break;
                case "Integer":
                case "Double-Float":
                case "TinyInt":
                  if ($_POST['val_min_nb'.$i]>$_POST['val_max_nb'.$i]){
                    $change=0;
                    $change= $_POST['val_max_nb'.$i];
                    $_POST['val_max_nb'.$i] = $_POST['val_min_nb'.$i];
                    $_POST['val_min_nb'.$i] = $change;
                    $rep =dbChampNum($db,$_POST['nom_champ'.$i],$_POST['type_champ'.$i],$_POST['libelle'],$_POST['val_min_nb'.$i],$_POST['val_max_nb'.$i]);
                    if (!$rep) {
                      echo "Erreur de connexion à la base de donnée";
                      exit();
                    }
                  }else{
                    $rep =dbChampNum($db,$_POST['nom_champ'.$i],$_POST['type_champ'.$i],$_POST['libelle'],$_POST['val_min_nb'.$i],$_POST['val_max_nb'.$i]);
                    if (!$rep) {
                      echo "Erreur de connexion à la base de donnée";
                      exit();
                    }
                  }
                  
                  
                break;
                case "Boolean":
                  
                  echo $i;
                  $rep = dbChampBool($db,$_POST['nom_champ'.$i],$_POST['type_champ'.$i],$_POST['libelle'],$_POST['valeur'.$i]);
                  if (!$rep) {
                    echo "Erreur de connexion à la base de donnée";
                    exit();
                  }
              } //fin du switch
              
            } //fin du for
            ?>
              <FORM action="../php/request3.php" method="post">
                <div class="container">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <div class="input-group mb-3">
                            <b>Nombre de données :</b> <input type="text" name="nombre" placeholder="saisir...">
                          </div>
                          <div class="input-group mb-3">
                            <b> Format de fichier à fournir</b>
                            <input type="radio" name="format" value=".sql"/>.sql
                            <input type="radio" name="format" value=".csv"/>.csv
                            
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>  
                </div>
                
                <input type="hidden" name="libelle" value="<?php echo $_POST['libelle']?>"/>
                <input type="submit" name="last" value="Dernière étapes"/>
              </FORM>
            <?php
          }
        ?>
        
        <input type="button" value="page précédente" onclick="history.go(-1)">
    </body>
</html>