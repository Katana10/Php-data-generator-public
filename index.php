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
		//include('php/database.php')
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
	$rejouer = strtoupper('Rejouer un modele');
	echo '<b>'.$rejouer.'</b>';
	$db =dbConnect();
	$request = searchModele($db);
	?>

	<TABLE>
		<TBODY>
			<?php foreach($request as $row): ?>
			<tr>
				<td class="libelle"><?php echo $row['libelle']; ?></td>
				<td class="nom_fichier"><?php echo $row['nom_fichier']; ?></td>
				<td class="nom_table"><?php echo $row['nom_table']; ?></td>
				<td class="date_creation"><?php echo $row['date_creation']; ?></td>
				<td><FORM action="php/request3.php" method="post">
	
					<b>Nombre de données :</b> <input type="text" name="nombre" placeholder="saisir...">

					<b> Format de fichier à fournir</b>
					<input type="radio" name="format" value=".sql"/>.sql
					<input type="radio" name="format" value=".csv"/>.csv
	
					<input type="hidden" name="libelle" value="<?php echo $row['libelle']?>"/>
					<input type="submit" name="last" value="Dernière étapes"/>

					</FORM>
				</td>
			</tr>
			<?php endforeach; ?>
		</TBODY>
	</TABLE>
	

	</pre>
	<footer class="footer">
        <a>Copyright TALIBART Killian - TRUONG-ALLIE Héloïse</a>
    </footer>
    </body>
</html>
