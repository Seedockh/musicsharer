<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// on teste si le formulaire a été soumis
if (isset ($_POST['action']) && $_POST['action']=='Send') {
	// on teste le contenu de la variable $auteur
	if (!isset($_POST['author']) || !isset($_POST['bandname']) || !isset($_POST['url']) ) {
  	$erreur = 'Les variables nécessaires au script ne sont pas définies.';
    echo $erreur;
    foreach ($_POST as $post) { echo $post; }
	}	else {
  	if (empty($_POST['author']) || empty($_POST['bandname']) || empty($_POST['url'])) {
  		$erreur = 'Au moins un des champs est vide.';
      echo $erreur;
      foreach ($_POST as $post) { echo $post; }
  	}
	// si tout est bon, on peut commencer l'insertion dans la base
	  else {
		// on se connecte à notre base de données
      $mysqli = new mysqli("musiqueadepeter.mysql.db", "musiqueadepeter", "M1ndBl457", "musiqueadepeter");
//$mysqli = new mysqli("localhost","root","","musiqueadepeter");

      if($_POST['author']==="Agathe") { $agathecheck = 1; $pierrecheck = 0; }
      else { $agathecheck = 0; $pierrecheck = 1; }
  		// préparation de la requête d'insertion (table forum_reponses)
  		$sql = 'INSERT INTO bands(author,bandname,albumname,releasedate,url,comment,agathecheck,pierrecheck) VALUES(
        "'.$mysqli->escape_string($_POST['author']).'",
        "'.$mysqli->escape_string($_POST['bandname']).'",
        "'.$mysqli->escape_string($_POST['medianame']).'",
        "'.$mysqli->escape_string($_POST['releasedate']).'",
        "'.$mysqli->escape_string($_POST['url']).'",
        "'.$mysqli->escape_string($_POST['comment']).'",
        "'.$agathecheck.'",
        "'.$pierrecheck.'"
      )';

  		/* on lance la requête ($mysqli->query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)*/
  		$mysqli->query($sql) or die('Erreur SQL !'.$sql.'<br />'.$mysqli->error);

  		// on ferme la connexion à la base de données
  		$mysqli->close();

  		// on redirige vers la page de lecture du sujet en cours
  		//header('Location: lire_sujet.php?id_sujet_a_lire='.$_GET['numero_du_sujet']);
  		header('Location: index.php');
  		// on termine le script courant
  		exit;
	  }
	}
} else {
  echo 'Error with Action';
  foreach ($_POST as $post) { echo $post; }
}
?>
