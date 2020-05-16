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
    <?php require_once("database.php")?>
  </head>
 
  <body>
    <header class="header">

      <span class="header-contenu">Projet</span>
      <a href="../back.php"> <input type="button" class="header-contenu-g" value="Back"> </a>
      <a href="../generator.php"> <input type="button" class="header-contenu-g" value="Générateur de données"> </a>
      <a href="../index.php"> <input type="button" class="header-contenu-g" value="Accueil"> </a>
  
    </header>
    <?php
      if (isset($_POST['envoi'])){
        $db =dbConnect();
        $toutlestypes =dbRequestActif($db);
        $nombrechamp =0;
        try{
          
          $date = date("Y-m-d H:i:s");
          $libelle = $_POST['nom_fichier'].$date;
          $statement = $db->prepare("INSERT INTO modele (libelle,nom_fichier, nom_table, date_creation) VALUES (?,?,?,?)");
   
          $statement->execute([$libelle,$_POST['nom_fichier'],$_POST['nom_table'],$date]);        
        }catch (PDOException $exception){
          error_log('Request error: '.$exception->getMessage());
          return false;
        }
        ?>
        <FORM action="../php/request2.php" method="post" enctype="multipart/form-data">
          <div class="container">
            <table class="table">
              <tbody>
                
                <?php
                $somme =0;
                $compteur =0;
                foreach($toutlestypes as $type){
                  
                  if ($type['actif'] == 1){ ?>
                    <tr>
                      <?php
                      $somme += (int)$_POST['nb_'.$type['type_champ']];
                      
                      for ($i=0; $i<$_POST['nb_'.$type['type_champ']]; $i++){
                        
                        ?>
                        <td>
                          <div class="input-group mb-3">
                            <b>Nom du champ</b><input type="text" name="nom_champ<?php echo $compteur;?>" placeholder="<?php echo $type['type_champ'];?>"/>
                            <input type="hidden" name="type_champ<?php echo $compteur;?>" value="<?php echo $type['type_champ'] ?>"/>
                            <?php
                            

                            switch ($type['type_champ']){
                              case "Varchar":
                              case "Char":
                                ?>
                                <div>
                                  <b>Longueur :</b> <input type="number" name="longueur<?php echo $compteur;?>" placeholder="<?php echo $type['type_champ'];?>"/>
                                  <input type="hidden" name="MAX_FILE_SIZE" value="10000000" /><br>
                                  <b>Transfère le fichier</b> <input type="file" name="monfichier<?php echo $compteur;?>" accept="text/plain"/><br>
                                </div>
                                <?php
                                break;

                              case "Date":
                              case "DateTime":
                              case "Time":
                                ?>
                                <div>
                                  <b>Date min :</b> <input type="date" name="val_min_date<?php echo $compteur;?>" placeholder="<?php echo $type['type_champ'];?>"/><br>
                                  <b>Date max :</b> <input type="date" name="val_max_date<?php echo $compteur;?>" placeholder="<?php echo $type['type_champ'];?>"/><br>
                                </div>
                                <?php
                                break;

                              case "Integer":
                              case "Double-Float":
                              case "TinyInt":
                                ?>
                                <div>
                                  <b>Valeur min :</b> <input type="number" name="val_min_nb<?php echo $compteur;?>" placeholder="<?php echo $type['type_champ'];?>"/><br>
                                  <b>Valeur max :</b> <input type="number" name="val_max_nb<?php echo $compteur;?>" placeholder="<?php echo $type['type_champ'];?>"/><br>
                                </div>
                                <?php
                                break;

                              case "Boolean":
                                ?>
                                <div>
                                  <b>Valeur de chaque données:</b>
                                  <select name="valeur<?php echo $compteur;?>" >
                                    <option value="Random">All Random</option>
                                    <option value="TRUE">All True</option>
                                    <option value="FALSE">All False</option>
                                  </select>
                                
                                </div>
                                <?php
                              break;

                              default:
                                echo "c'était pour vous faire plaisir";
                            break; 
                            } //fin du switch ?> <br><br><br>
                          </div>
                        </td>  <?php
                        $compteur ++;
                      } //fin du for ?>
                    </tr> <?php
                  }  //fin du if
                
                } ?>
              </tbody>
            </table>
            <input type="hidden" name="somme" value="<?php echo $somme;?>">
            <input type="hidden" name="libelle" value="<?php echo $libelle?>"/>
            <input type="button" value="page précédente" onclick="history.go(-1)"/>
            <input type="submit" name="envoi2" value="étape suivante"/>
            </div>
          </FORM>
        <?php 
      }
    ?>

    <footer class="footer">
      <a>Copyright TALIBART Killian - TRUONG-ALLIE Héloïse</a>
    </footer>
  </body>
</html>
