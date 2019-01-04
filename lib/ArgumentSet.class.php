<?php // A ADAPTER
/*
Classe permettant de vérifier et représenter des arguments reçus en mode GET.

Une valeur incorrecte pour l'un ou l'autre des arguments est considérée comme un erreur

Cette classe est une évolution de celle de l'exercice précédent :
	- utilisation du filtrage (filter_input)
	- le type de transmission (GET/POST) est un attribut de la classe. Il est fixé à l'instanciation (GET, par défaut)
	   (intérêt : pouvoir changer le mode de transmission sans devoir retravailler le code)
	- les valeurs sont regroupées dans un seul attribut de type table associative : $this->values,
		ce qui facilite la factorisation du code

*/
class ArgumentSet {
	private $inputType;  			// INPUT_GET, INPUT_POST, ...
	private $errors = array(); // associative array (map) : key : arg name (string), value : "rejected"
	private $values = array(); // associative array (map) : key : arg name (string), value : arg retained value
	private $manquant= array();
	private $nomen_long;
	private $libapet;
	private $l6_normalisee;
	private $libcom;
	private $categorie;




	/*	indicates validity of this arg set*/

	public function isValid(){
		if($this->errors["nomen_long"]=="missing"){
			if( ($this->errors["libcom"]=="missing" && $this->errors["l6_normalisee"]=="missing") || ($this->errors["libapet"]=="missing")){
				return FALSE ;
			}
			else{
				return TRUE;
			}
		}
		else{
			return TRUE;
		}

	}

	/**
	 *	return associative array (map) of errors :
	 *	entry : key : arg name (string), value : "rejected" or "missing"
	 */
	public function getErrors(){
		return $this->errors;
	}

	public function __construct($inputType=INPUT_GET){

		$this->inputType = $inputType;



		$name = 'nomen_long';
		$v = filter_input($this->inputType, $name, FILTER_SANITIZE_STRING);
		if ((is_null($v)) || ($v == ""))
			$this->errors[$name] = "missing";
		else
			$this->values[$name] = $v;

		$name = 'libapet';
		$v = filter_input($this->inputType, $name, FILTER_SANITIZE_STRING);
		if ((is_null($v)) || ($v == ""))
			$this->errors[$name] = "missing";
		else
				$this->values[$name] = $v;

		// argument 'cp' : french postal code, mandatory
		$name = 'l6_normalisee';
		$v = filter_input(INPUT_GET, $name, FILTER_VALIDATE_REGEXP,
           array('options'=> array('regexp'=>'/^[0-9]{5}|97[1-6][0-9]{3}$/')) // regular expression
      );
 		if (is_null($v))
			$this->errors[$name] = "missing";
		else if ($v === FALSE)
			$this->errors[$name] = "missing";
		else
			$this->values[$name] = $v;


		// argument 'commune', mandatory. Should be non empty string.
		// has to be to sanitized
		$name = 'libcom';
		$v = filter_input($this->inputType, $name, FILTER_SANITIZE_STRING);
		if ((is_null($v)) || ($v == ""))
			$this->errors[$name] = "missing";
		else if($v == False)
			$this->errors[$name] = "missing";
		else
			$this->values[$name] = $v;


		// argument 'taille', optional. Should be 'oui', 'non' or 'dejaMembre' default : 'n
		$name = 'categorie';
		$v = filter_input($this->inputType, $name, FILTER_UNSAFE_RAW);
		if (is_null($v))
			$this->errors[$name] = "missing";
		else if (! in_array($v, array("PME", "ETI", "GE")))
			$this->errors[$name] = "missing";
		else
			$this->values[$name] = $v;

	}

	/*
		'nom' accessor. NULL if error
	*/

	public function getNom(){
		if (isset($this->values['nomen_long']))
			return $this->values['nomen_long'];
		else
			return NULL;
	}

	public function getActivite(){
		if (isset($this->values['libapet']))
			return $this->values['libapet'];
		else
			return NULL;
	}

	public function getCommune(){
		if (isset($this->values['libcom']))
			return $this->values['libcom'];
		else
			return NULL;
	}

	public function getCp(){
		if (isset($this->values['l6_normalisee']))
			return $this->values['l6_normalisee'];
		else
			return NULL;
	}

	public function getCategorie(){
		if (isset($this->values['categorie']))
			return $this->values['categorie'];
		else
			return NULL;
	}
}
?>
