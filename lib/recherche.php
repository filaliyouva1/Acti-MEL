<?php



		require_once("requette.php"); 
		$configContext = array('http' => array('proxy' => 'tcp://cache.univ-lille1.fr:3128','request_fulluri' => true));
		stream_context_set_default($configContext);

		$chaine=file_get_contents($url); //en url

		$data=json_decode($chaine, true);
		$nb=$data["nhits"];//Le nombre de résultat
		$resultats=$data["records"]; // table [indice]=>une entreprise, indice compris entre 0 et "nhits"
		//un entreprise : table, regarde entreprise["fields"]

		$liste_entreprises=array(); // tableau [indice]=>objet entreprise issu du résultat de la recherche;


		foreach($data["records"] as $var){
			$entreprise=array();//une entreprise parmi les nb entreprises trouvé
			$siret= $var["fields"]["siret"];
			$nomen_long= $var["fields"]["nomen_long"];
			$l6_normalisee=$var["fields"]["l6_normalisee"];
			$libcom= $var["fields"]["libcom"];
			$libtefet=$var["fields"]["libtefet"];
			$activite=$var["fields"]["activite"];
			$coordonnes=$var["fields"]["coordonnees"];
			if (array_key_exists('categorie', $var["fields"])){
				$categorie=$var["fields"]["categorie"];}
			else {
				$categorie="Pas mentionné";
				}
			if (array_key_exists('libnj', $var["fields"])){
				if (array_key_exists('categorie', $var["fields"])){
					$libnj=$var["fields"]["libnj"];}
			}
			else {
				$libnj="Pas mentionné";
				}
			array_push($entreprise, $siret, $nomen_long,$l6_normalisee, $libcom,  $libtefet, $activite, $coordonnes, $categorie, $libnj);//empilement des informations de l'entreprise
			array_push($liste_entreprises, $entreprise);//empilement de l'entreprise dans le tableau des entreprises

			}
			$res="";
			foreach($liste_entreprises as $en){
			$res.="<tr data-siret=\"".$en[0]."\""." data-lat=\"".$en[6][0]."\""." data-lon=\"".$en[6][1]."\">\n";
			$res.="<td class=\"nomen_long\">".$en[1]."</td>\n"
			."	<td class=\"l6_normalisee\">".$en[2]."</td>\n"
			."	<td class=\"activite\">".$en[5]."</td>\n"
			."	<td class=\"categorie\">".$en[7]."</td>\n"
			."	<td class=\"libtefet\">".$en[4]."</td>\n"
			."	<td class=\"libnj\">".$en[8]."</td>\n"
			."</tr>\n";
			}


		?>
