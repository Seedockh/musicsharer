<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Index de notre forum</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Cinzel" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $mysqli = new mysqli("musiqueadepeter.mysql.db", "musiqueadepeter", "M1ndBl457", "musiqueadepeter");
  $sql2 = 'SELECT * FROM bands ORDER BY id DESC';
  $req2 = $mysqli->query($sql2) or die('Erreur SQL !<br />'.$sql2.'<br />'.$mysqli->error);
  ?>
<header>
	<h1>GROUPES A DECOUVRIR</h1>
</header>

<section>
  <?php
    while ($data = $req2->fetch_array(MYSQLI_ASSOC)) {
      /*echo '<p>'.$data['author'].'</p>';
      echo '<p>'.$data['bandname'].'</p>';
      echo '<p>'.$data['albumname'].'</p>';
      echo '<p>'.$data['releasedate'].'</p>';
      echo '<p>'.$data['url'].'</p>';
      echo '<p>'.$data['comment'].'</p>';*/
  ?>
  <article>
    <div class="author"><p><img src="img/pin.png" width="20"> Pinned by <?php echo $data['author']; ?></p></div>
    <div class="mediainfos">
      <div class="infoslot"><p><h2><?php echo strtoupper($data['bandname']); ?></h2></p></div>
      <div class="infoslot mediatype">
        <p>Album/Song name</p>
        <h3><?php echo $data['albumname']; ?></h3>

        <?php if ($data['releasedate']) {  ?>
          <p>Release date</p>
          <h3><?php echo $data['releasedate']; ?></h3>
        <?php } ?>
      </div>
    </div>
    <iframe width="420" height="315" src="<?php echo $data['url']?>" frameborder="0" allowfullscreen></iframe>
    <?php if ($data['comment']) {  ?>
      <div class="infoslot">
        <p>Comment</p>
        <p class="comment"><?php echo $data['comment']; ?></p>
      </div>
    <?php } ?>
    <div class="marking">
      <form action="#">
        <p><label><input type="checkbox" <?php if($data['agathecheck']) echo 'checked=\"checked\" disabled=\"disabled\"'; ?> />
          <span>Mark as heard as <span class="bold">Agathe</span></span>
        </label></p>
        <p><label><input type="checkbox" <?php if($data['pierrecheck']) echo 'checked=\"checked\" disabled=\"disabled\"'; ?>/>
          <span>Mark as heard as <span class="bold">Pierre</span></span>
        </label></p>
        <p><label>
          <button class="btn waves-effect waves-light" type="submit" name="action">
          Send <i class="material-icons right">send</i></button>
        </label></p>
      </form>
    </div>
  </article>

  <?php
}  //end fetching datas
  ?>
</section>

<section><article class="mediaform">
  <h2>Pin a band/an artist</h2>
  <div class="row">
    <form class="col s12" action="insert_band.php" method="POST">
      <div class="row">
        <div class="input-field col s6">
          <input id="author" type="text" class="validate" name="author">
          <label for="author">Author*</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="bandname" type="text" class="validate" name="bandname">
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
          <input id="releasedate" type="text" class="validate" name="releasedate">
          <label for="releasedate">Release Year</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="url" type="text" class="validate" name="url">
          <label for="url">Embed URL*</label>
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

<div class="linksmenu">
  <a class="titleLinks" href="./../msg/">Notre forum d'écriture</a>
  <a class="titleLinks" href="./../msg/lire_sujet.php?id_sujet_a_lire=1">Nos premiers &eacute;changes</a>
</div>

</body>
</html>
