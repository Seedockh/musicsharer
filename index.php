<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Musique</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Cinzel" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  session_start();
  require 'vendor/autoload.php';
  $api = new SpotifyWebAPI\SpotifyWebAPI();

  if (isset($_SESSION['accesstoken'])) {  //if we passed through callback
    $api->setAccessToken($_SESSION['accesstoken']);
    $_SESSION['spotauth'] = true;
    /*print_r( $api->me() );
    die;*/

  } else if (isset($_GET['code'])){   //if we just passed through auth
    header('Location: spot-callback.php?code='.$_GET['code']);
  }



  $mysqli = new mysqli("host", "user", "pswd", "db");
  $sql2 = 'SELECT id,bandname,agathecheck,pierrecheck FROM bands ORDER BY id DESC';
  $req2 = $mysqli->query($sql2) or die('Erreur SQL !<br />'.$sql2.'<br />'.$mysqli->error);
  ?>
<header>
	<h1>GROUPES A DECOUVRIR</h1>
</header>

<div class="container">
  <div class="leftCol">
    <aside>
        <div class="spotifylog">
          <?php if(isset($_SESSION['spotauth'])) { ?>
            <a target="_blank" href="<?php echo $api->me()->external_urls->spotify; ?>"><img src="img/spotify.png" width="30" alt=""><span>Logged as <?php echo $api->me()->display_name; ?></span></a>
          <?php } else { ?>
            <a href="spot-auth.php"><img src="img/spotify.png" width="30" alt=""><span>Login to spotify</span></a>
          <?php } ?>
        </div>
        <div class="bandslist">
          <?php
            while ($dataLeft = $req2->fetch_array(MYSQLI_ASSOC)) {
          ?>
          <a href="#<?php echo $dataLeft['id']; ?>">
            <span class="leftlink">
              <?php if(strlen($dataLeft['bandname'])>19) {
                echo substr($dataLeft['bandname'],0,17).'...';
              } else {
                 echo $dataLeft['bandname'];
              }?>
            </span>
            <span class="rightlink">
              <?php if ($dataLeft['agathecheck'] && $dataLeft['pierrecheck']) { echo '<i class="material-icons right">check</i>'; } ?>
            </span>
          </a>
          <?php } ?>
          <a href="#form" class="addlink"><i class="material-icons right">add_circle</i> New band</a>
        </div>
      </aside>
  </div>

  <div class="rightCol">
    <section>
      <?php
        $sql3 = 'SELECT * FROM bands ORDER BY id DESC';
        $req3 = $mysqli->query($sql3) or die('Erreur SQL !<br />'.$sql3.'<br />'.$mysqli->error);
        while ($dataRight = $req3->fetch_array(MYSQLI_ASSOC)) {
      ?>

      <article>
        <a id="<?php echo $dataRight['id']; ?>"></a>
        <?php
          $deviceId = $api->getMyDevices()->devices[0]->id;
          $api->play($deviceId,['spotify:album:5ttebRYn0OFb5dnmCythXf']);
        ?>
        <div class="mediainfos">
          <div class="infoslot"><p><h2><?php
          if(strlen($dataRight['bandname'])>19) {
            echo strtoupper(substr($dataRight['bandname'],0,17).'...');
          } else {
             echo strtoupper($dataRight['bandname']);
          }?></h2></p></div>
          <div class="infoslot mediatype">
            <p class="smalltitle">Album/Song name</p>
            <h3><?php echo $dataRight['albumname']; ?></h3>

            <?php if ($dataRight['releasedate']) {  ?>
              <p class="smalltitle">Release date</p>
              <h3><?php echo $dataRight['releasedate']; ?></h3>
            <?php } ?>
          </div>
        </div>
        <iframe width="420" height="315" src="<?php echo $dataRight['url']?>" frameborder="0" allowfullscreen allowtransparency="true" allow="encrypted-media; autoplay; picture-in-picture"></iframe>
        <?php if ($dataRight['comment']) {  ?>
          <div class="infoslot">
            <p class="smalltitle">Comment</p>
            <p class="comment"><?php echo $dataRight['comment']; ?></p>
          </div>
        <?php } ?>
        <div class="marking">
          <form action="insert_mark.php" method="POST">
            <p><label><input type="checkbox" <?php if($dataRight['agathecheck']) echo 'checked=\"checked\"'; ?> name="agathecheck" value="1"/>
              <span>Mark as heard as <span class="smalltitle">Agathe</span></span>
            </label></p>
            <p><label><input type="checkbox" <?php if($dataRight['pierrecheck']) echo 'checked=\"checked\"'; ?> name="pierrecheck" value="1"/>
              <span>Mark as heard as <span class="smalltitle">Pierre</span></span>
              <input type="text" name="bandid" value="<?php echo $dataRight['id']; ?>" hidden>
            </label></p>
            <p><label>
              <button class="btn waves-effect waves-light" type="submit" name="addmark" value="Send">
              Send <i class="material-icons right">send</i></button>
            </label></p>
          </form>
        </div>
      </article>

      <?php
    }  //end fetching datas
      ?>

    <article class="mediaform">
      <a id="form"></a>
      <h2>Pin a band/an artist</h2>
      <div class="row">
        <form class="col s12" action="insert_band.php" method="POST">
          <div class="row">
            <div class="input-field col s6">
              <select id="author" class="validate" name="author" required>
                  <option value="Agathe">Agathe</option>
                  <option value="Pierre">Pierre</option>
              </select>
              <label for="author">Author*</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="bandname" type="text" class="validate" name="bandname" required>
              <label for="bandname">Band Name*</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="medianame" type="text" class="validate" name="medianame">
              <label for="medianame">Album/Song Name</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <!--<input id="releasedate" type="text" class="validate" name="releasedate">-->
              <select id="releasedate" class="validate" name="releasedate">
                  <option value="">I have no idea</option>
                <?php
                  for($i=1990;$i<=date('Y');$i++) {
                ?>
                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
              </select>
              <label for="releasedate">Release Year</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="url" type="text" class="validate" name="url" required>
              <label for="url">URL*</label>
            </div>
          </div>
              <div class="row">
                <div class="input-field col s12">
                  <textarea id="comment" class="materialize-textarea" name="comment"></textarea>
                  <label for="comment">Comment</label>
                </div>
              </div>
          <p><span class="starfields">(*) : those fields need to be filled.</span></p>
          <p><label>
            <button class="btn waves-effect waves-light" type="submit" name="action" value="Send">Let's hear this !
            <i class="material-icons right">send</i></button>
          </label></p>
        </form>
      </div>
    </article></section>
  </div>
</div>

<footer>
    <a class="titleLinks" href="./../msg/">Notre forum d'écriture</a>
    <a class="titleLinks" href="./../msg/lire_sujet.php?id_sujet_a_lire=1">Nos premiers &eacute;changes</a>
</footer>

<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
   const elems = document.querySelectorAll('select');
   const options = "";
   var instances = M.FormSelect.init(elems, options);
  });
</script>

</body>
</html>
