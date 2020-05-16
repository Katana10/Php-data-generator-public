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
        include('php/request.php');
        //require_once('php/database.php');
		?>
	</head>

	<body>
	
    <header class="header-back">
		<span class="header-contenu">Projet</span>
        <a href="back.php"> <input type="button" class="header-contenu-g" value="Back"> </a>
		<a href="generator.php"> <input type="button" class="header-contenu-g" value="Générateur de données"> </a>
		<a href="index.php"> <input type="button" class="header-contenu-g" value="Accueil"> </a>
		
	</header>
    <?php
    $db =dbConnect();
    
    
	$toutlestypes =dbRequestActif($db);
	
    ?>
	<FORM action="back.php" method="post">
		<div class="container">
			<table class="table">
				<tbody>
					<?php foreach($toutlestypes as $type) {?>
						<tr>
							<th scope="row"><?php echo $type['type_champ'];?></th>
							<td>
								<div class="input-group mb-3">
									<select class="custom-select" name=<?php echo $type['type_champ'];?>>
										<option value='Actif' <?php if ($type['actif'] == 1){ echo "selected";}?>>Actif</option>"
										<option value='Inactif'<?php if ($type['actif'] == 0){ echo "selected";}?>>Inactif</option>";
											
									
									</select>
								</div>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
			<div class="row">
				<div class="form-check col">
					<input type="checkbox" name="check">
					<label class="form-check-label" for="check">Valider la saisie</label>
				</div>	
				<div class="col">
					<button type="submit" class="btn btn-primary" id="maj" >Mettre à jour en appuyant deux fois</button>
				</div>
			</div>
		</div>
	</FORM>
	<FORM action="back.php" method="post">
		<h4>Voulez vous inscrire un nouveau type de champ</h4>
		<input type="text" name="type_champ" placeholder="saisir..."/>
		<select class="custom-select" name="actif">
			<option value='Actif' select>Actif</option>
			<option value='Inactif'>Inactif</option>
		<input type="submit" name="create" value="Création"/>
	</FORM>
	<?php
	if (isset($_POST['create'])){
		$db =dbConnect();
        try{
          
          
          $statement = $db->prepare("INSERT INTO type_champ (type_champ, actif) VALUES (?,?)");
   
          $statement->execute([$_POST['type_champ'], $_POST['actif']]);        
        }catch (PDOException $exception){
          error_log('Request error: '.$exception->getMessage());
          return false;
        }
	}
	#Obligé de mettre un radio pour éviter un ping pong entre les valeurs à cause du reload des valeurs
	if (isset($_POST['check'])){
		$i = 0;
		#Remet les bonnes valeurs dans le tableau après saisie
		foreach ($toutlestypes as $types){
			switch ($_POST[$types['type_champ']]) {
				case 'Actif':
					if ($types['actif'] != '1') $toutlestypes[$i]['actif'] = '1';
				break;

				case 'Inactif':
					if ($types['actif'] != '0') $toutlestypes[$i]['actif'] = '0';
				break;
			}
			$i += 1;
		}

		#Envoie une requête à la base de donnée pour Update chaque type
		foreach($toutlestypes as $types) {
			
			$result = dbUpdateActif($db, $types['type_champ'], (int)$types['actif']);
			
			if (!$result){
				echo "Problème d'update de la base de donnée";
				exit(1);
			}
		}
	}
	?>

    <footer class="footer">
        <a>Copyright TALIBART Killian - TRUONG-ALLIE Héloïse</a>
    </footer>
    </body>
</html>
