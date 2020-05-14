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
        <div class="container">
            <?php
            if (isset($_POST['last'])){
                $db = dbConnect();
                $rep = dbCreation($db, $_POST['libelle']);
                $info = dbRequestModele($db, $_POST['libelle']);
                $nb_champ =count($rep);
                $lefichier = $info[0]['nom_fichier'];
                $latable = $info[0]['nom_table'];
                if ($_POST['format'] == ".sql"){
                    $f = fopen($lefichier.$_POST['format'], "w+") or die('Fichier non accessible (liste.txt)');
                    fputs($f, "INSERT INTO ".$latable." (");
                }else if ($_POST['format'] == ".csv"){
                    $f = fopen($lefichier.$_POST['format'], "w+") or die('Fichier non accessible (liste.txt)');
                }
                for ($i=0; $i<$nb_champ; $i++){
                    $nom[$i] = $rep[$i]['nom_champ'];
                    $type[$i] = $rep[$i]['type_champ'];
                    if ($_POST['format'] == ".sql"){
                        if ($i+1 !=$nb_champ){
                            fputs($f, $nom[$i].", ");
                        }else{
                            fputs($f, $nom[$i].")\n VALUES\n");
                        }
                    }else if ($_POST['format'] == ".csv"){
                        if ($i+1 !=$nb_champ){
                            fputs($f, $nom[$i].", ");
                        }else{
                            fputs($f, $nom[$i]."\n");
                        }
                    }
                    
                }
                // var_dump($nom);
                // var_dump($type);
                $donnee =array($nom);
                
                $nombre = $_POST['nombre']*$nb_champ + $nb_champ;
                $donnee= array();
                for ($i=0;$i<$nombre;$i ++){
                    
                    switch ($type[$i%$nb_champ]){
                    case "Varchar":
                    case "Char":
                        $longueur[$i%$nb_champ] = $rep[$i%$nb_champ]['longueur'];
                        $fichier[$i%$nb_champ] = $rep[$i%$nb_champ]['fichier'];
                        $valeurdeladonee =createStrFile($fichier[$i%$nb_champ]);
                    break;
                    case "Date":
                    case "DateTime":
                    case "Time":
                        $val_min_date[$i%$nb_champ] = $rep[$i%$nb_champ]['val_min_date'];
                        $val_max_date[$i%$nb_champ] = $rep[$i%$nb_champ]['val_max_date'];
                        $MIN = strtotime($val_min_date[$i%$nb_champ]);
                        $MAX = strtotime($val_max_date[$i%$nb_champ]);
                        $int= mt_rand($MIN,$MAX);
                        if ($type[$i%$nb_champ] == "DateTime"){
                        $valeurdeladonee = date("Y-m-d H:i:s",$int);
                        }else {
                        $valeurdeladonee = date("Y-m-d",$int);
                        }
                    break;
                    case "Integer":
                    case "Double-Float":
                    case "TinyInt":
                        $val_min_nb[$i%$nb_champ] = $rep[$i%$nb_champ]['val_min_nb'];
                        $val_max_nb[$i%$nb_champ] = $rep[$i%$nb_champ]['val_max_nb'];
                        $valeurdeladonee = mt_rand($val_min_nb[$i%$nb_champ],$val_max_nb[$i%$nb_champ]);
                    break;
                    case "Boolean":
                        $valeur[$i%$nb_champ] = $rep[$i%$nb_champ]['list_txt'];
                        
                        if ($valeur[$i%$nb_champ]== "Random"){
                            $int = rand(0,1);
                            
                            if ($int == 0){
                                $valeurdeladonee = "FALSE";
                            }else if ($int == 1){
                                $valeurdeladonee = "TRUE";
                            }
                        }else{
                            $valeurdeladonee = $valeur[$i%$nb_champ];
                        }
                        
                        
                    break;
                    }
                    if ($_POST['format'] == ".sql"){
                        if (($i+1)%$nb_champ ==1){
                            fputs($f, '("'.$valeurdeladonee.'"');
                        }else if (($i+1)%$nb_champ ==0){
                            if (($i+1) == $nombre){
                                fputs($f, ',"'.$valeurdeladonee.'");');
                            }else{
                                fputs($f, ',"'.$valeurdeladonee.'"),');
                                fputs($f, "\n");
                            }
                        }else{
                            fputs($f, ',"'.$valeurdeladonee.'"');
                        }
                    }else if($_POST['format'] == ".csv"){
                        if (($i+1)%$nb_champ !=0){
                            fputs($f, '"'.$valeurdeladonee.'",');
                        }else if (($i+1)%$nb_champ ==0){
                            fputs($f, '"'.$valeurdeladonee.'"');
                            fputs($f, "\n");
                            
                        }
                    }  
                }
                //$f = str_replace(",\n", ";", $f[$_POST['nombre']-1]);
                
                fclose($f);
                //téléchargement($lefichier);
 
            }
            ?>
            <a href="../php/<?php echo $lefichier.$_POST['format'];?>" download="<?php echo $lefichier.$_POST['format'];?>">Télécharger le dossier</a>
  
        </div>

        <footer class="footer">
            <a>Copyright TALIBART Killian - TRUONG-ALLIE Héloïse</a>
        </footer>
    </body>
</html>