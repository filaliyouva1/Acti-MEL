<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
    <head>
        <meta charset="UTF-8" />
        <title>Recherche d'entreprise</title>
       <link rel="stylesheet" media="screen" type="text/css" title="Exemple" href="style/projet-page_accueil.css"/>

       <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
       <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
       <script src="script/sc2.js"></script>
    </head>

  <body class="mainbody">

    <div class="spinner">
      <div class="double-bounce1"></div>
      <div class="double-bounce2"></div>
    </div>
      <div class="formulaire">
        <img src="img/logo.png">
        <form method="GET" action="index.php">

              <input type="text" name="nomen_long" id="nomen_long" placeholder="Entrez un nom d'entreprise "/><br />
              <input type="text" name="libapet" id="libapet" placeholder="Secteur d'activité"/><br />
              <input type="text" name="l6_normalisee" id="l6_normalisee" placeholder="Code Postal"/><br />
              <input type="text" name="libcom" id="libcom" placeholder="Commune"/><br />
              <div class="radio">
                PME
                <input type="radio" name="categorie" id="categorie" value="PME"/><br />
              </div>
              <div class="radio">
                ETI
                <input type="radio" name="categorie" id="categorie" value="ETI"/><br />
              </div>
              <div class="radio">
                GE
                <input type="radio" name="categorie" id="categorie" value="GE"/><br />
              </div>



           <button type="submit" name="valid" value="envoyer">Rechecher</button><br />
           <button type="reset" >Effacer</button><br />
      </form><br />

  </div>
        <div id="cartecampus"></div>
        <?php
		        require_once('lib/ArgumentSet.class.php');

		        $argSet = new ArgumentSet(INPUT_GET);

		        if ($argSet->isValid()) {
              $nom=$argSet->getNom();
              $activite=$argSet->getActivite();
              $cp=$argSet->getCp();
              $commune=$argSet->getCommune();
              $categorie=$argSet->getCategorie();


              require("lib/requette.php");

              }

        ?>

          <div id="cartecampus"></div>

  			<table id="entreprises" border="1">
  			<thead>
  				<tr>
  					<td>Nom de l'entreprise</td>
  					<td>Adresse</td>
  					<td>Activite</td>
  					<td>Categorie</td>
  					<td>Tranche d'effectif</td>
  					<td>Nature juridique</td>
  				</tr>
  			</thead>
  			<tbody>
  				<?php
  					echo $res ;
  				?>

  			</tbody>

  		</table>



  </body>
</html>
