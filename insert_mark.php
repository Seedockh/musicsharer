<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ( isset($_POST['addmark']) && $_POST['addmark']=='Send' && isset($_POST['bandid']) ) {
  $id = $_POST['bandid'];
  $mysqli = new mysqli("musiqueadepeter.mysql.db", "musiqueadepeter", "M1ndBl457", "musiqueadepeter");

  $reqcompare = 'SELECT agathecheck,pierrecheck FROM bands WHERE id='.$id.'';
  $req = $mysqli->query($reqcompare) or die('Erreur SQL ! '.$sql.'<br />'.$mysqli->error);
  $markschecks = $req->fetch_array(MYSQLI_ASSOC);

  if ( isset($_POST['agathecheck']) ) {
    $agathecheck = ($markschecks['agathecheck']===$_POST['agathecheck']) ?
                    $markschecks['agathecheck'] : $_POST['agathecheck'];
  } else $agathecheck = 0;

  if ( isset($_POST['pierrecheck']) ) {
    $pierrecheck = ($markschecks['pierrecheck']===$_POST['pierrecheck']) ?
                    $markschecks['pierrecheck'] : $_POST['pierrecheck'];
  } else $pierrecheck = 0;

  $sql = 'UPDATE bands
          SET agathecheck='.$agathecheck.', pierrecheck='.$pierrecheck.'
          WHERE id = '.$id.'';

	$mysqli->query($sql) or die('Erreur SQL ! '.$sql.'<br />'.$mysqli->error);
  $mysqli->close();

  header('Location: index.php');
	exit;

} else {
  echo 'Error with Addmark';
  foreach ($_POST as $post) { echo $post; }
}
?>
