<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<?php
		
		ini_set('display_errors','on');
		error_reporting(E_ALL);
		?>
		<title>Mini-Projet</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="generator" content="Geany 1.33" />
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<?php 
		include('php/request.php')
		?>
	</head>

	<body>
	
    <header class="header">

      <span class="header-contenu">Projet</span>
      <a href="back.php"> <input type="button" class="header-contenu-g" value="Back"> </a>
      <a href="generator.php"> <input type="button" class="header-contenu-g" value="Générateur de données"> </a>
      <a href="index.php"> <input type="button" class="header-contenu-g" value="Accueil"> </a>
		
	  </header>
	  <pre>
      <br><br><br>
      <?php
      $db =dbConnect();
      $toutlestypes =dbRequestActif($db);
      ?>

      <FORM action="php/request.php" method="post">

        <b>Générateur de données</b> <u>étape 1</u>
        <b>Nom du modèle :</b> <input type="text" name="nom_table" placeholder="saisir..."/>
        <b>Nom du fichier :</b> <input type="text" name="nom_fichier" placeholder="saisir..."/>


        <table class="table">
          <tbody>

            <?php foreach($toutlestypes as $type) { ?>
              <tr>
                <th scope="row"><?php echo $type['type_champ'];?></th>
                <td>

                  <?php if ($type['actif'] == 1) { ?>
                    <div class="input-group mb-3">
                      <?php echo "<b>Nombre de ".$type['type_champ']." :</b>";?><input type="number" class="custom-input" name=<?php echo "nb_".$type['type_champ'];?> placeholder="saisir..."/>
                    </div>
                  <?php }else if ($type['actif'] == 0){ ?>
                    <div class="input-group mb-3">
                      <?php echo "Pour activer aller au back";?>
                    </div>
                  <?php } ?>
                
                </td>
              </tr>
            <?php } ?>
          </tbody>
			  </table>
        <div>
          <input type="submit" name="envoi" value="étape suivante"/>
        </div>

      </FORM>

    </pre>


	  <footer class="footer">
        <a>Copyright TALIBART Killian - TRUONG-ALLIE Héloïse</a>
    </footer>
  </body>
</html>