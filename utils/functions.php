<?php

	define("MYSQL_DATE_FORMAT", "Y-m-d h:m:s");

	require_once(ROOT . "/exceptions/HttpStatusException.php");
    require_once(ROOT . "/utils/controller/IController.php");

	function serverBootstrap() {
		error_reporting(E_ALL & ~E_DEPRECATED & ~E_WARNING & ~E_STRICT & ~E_NOTICE & ~E_PARSE);
		ini_set('display_errors', 'off');
	}

	function headerAndDie($header) {
		header($header);
		die();
	}

	function _400_Bad_Request($msg = "") {
		headerAndDie("HTTP/1.1 400 Bad Request : " . $msg);
	}

	function _404_Not_Found($msg = "") {
		headerAndDie("HTTP/1.1 404 Not Found : " . $msg);
	}

	function _405_Method_Not_Allowed() {
		headerAndDie("HTTP/1.1 405 Method Not Allowed");
	}

	function _499_Authentication_Error($msg = "") {
        headerAndDie("HTTP/1.1 499 Authentication Error : " . $msg);
    }

	function _500_Internal_Server_Error($msg = "") {
		headerAndDie("HTTP/1.1 500 Internal Server Error : " . $msg);
	}

	function raiseHttpStatus(HttpStatusException $ex) {
		switch ($ex->getCode()) {
		case 400 : _400_Bad_Request($ex->getMessage());
			break;
		case 404 : _404_Not_Found($ex->getMessage());
			break;
		case 499 : _499_Authentication_Error($ex->getMessage());
			break;
		case 500 : // Ici on veut savoir ce qu'il se passe dans le serveur
			error_log($ex); // c'est un cas d'exception non souhaité...
			_500_Internal_Server_Error($ex->getMessage());
			break;
		default : throw new Exception("Http Status Exception not managed : " . $ex->getCode());
		}
	}

	function extractForm() : array {
		switch ($_SERVER['REQUEST_METHOD'] ) {
			case 'GET' : return $_GET;
			case 'POST' : return $_POST;
			case 'DELETE' : return $_GET;
			case 'PUT' : // Cas merdique, le php ne gère pas le PUT par défaut
				$raw = file_get_contents('php://input'); // cache php
				$form = [];
				parse_str($raw, $form); // Builtin php d'extraction de formulaire
				return $form;
			default : _405_Method_Not_Allowed();
		}
	}

	function extractRoute(array $FORM) : string {
		if (!isset( $FORM['route'] )) { // Si le paramètre n'existe pas, 400
			_400_Bad_Request("No parameter : route");
		}
		// On extrait la route, puis on sécurise la variable pour éviter les injections
		$ROUTE = $FORM['route'];
		if ( preg_match("/^[A-Z][A-Za-z]{1,63}$/", $ROUTE) ) {
			return $ROUTE; // Commence par une lettre majuscule, suivi d'une lettre
		}
		_400_Bad_Request("Wrong syntax : route");
	}

	function createController($FORM, $ROUTE) : IController {
		$METHOD = createMethod();
		// Je construis le nom de la classe controller
		$CLASS_NAME = $ROUTE . $METHOD . "Controller"; // Convention ArticleGetController
		// Construction du chemin absolu du fichier
		$FILE = ROOT . "/controllers/" . $CLASS_NAME . ".php";
		// Si le fichier n'existe pas, on lève une Exception HTTP
		if ( ! file_exists($FILE) ) {
			throw new HttpStatusException("Unknown Controller : " . $ROUTE . $METHOD, 404);
		}
		try {
			require($FILE);
			$CONTROLLER = new $CLASS_NAME($FORM); // new ArticleGetController($FORM)
			return $CONTROLLER;
		} catch (ParseError $e) {
			error_log($e);
			die(); // TODO ERREUR 500
		}
	}

	function createMethod() {
		$method = strtolower( $_SERVER['REQUEST_METHOD'] ); // Tout en minuscule
		return ucfirst($method); // Première lettre en Majuscule
	}

	/**
	 * Controlle si la chaine est un entier naturel [0,N]
	 * @param string $str
	 * @return bool
	 */
	function isNaturalInteger(string $str) : bool {
		return ctype_digit( $str );
	}

	function isSanitizedString(string $str) {
		return true;
	}

	function sanitizeString(string $str) {
		return $str;
	}

	define("START_TIME", "startTime");
	define("COMPTE_ID", "compteId");

	function initSession() { // on va créer notre propre timeout de session
		if ( ! isset($_SESSION[START_TIME]) ) {
			$_SESSION[START_TIME] = time();
		} else if (isLogged()) { // L'utilisateur est logué, on rajoute du temps
			$_SESSION[START_TIME] = time();
		}
	}

	function reinitSession() {
		session_destroy();
		session_start();
		initSession();
	}

	function manageSession() {
		session_start();
		initSession();
		// si la session est expirée je la reinit
		if ( ( $_SESSION[START_TIME] + getMaxTime() ) < time() ) {
			reinitSession();
		}
	}

	function getMaxTime() : int {
		return 15 * 60; // 15 minutes
	}

	function isLogged() : bool {
		return isset( $_SESSION[COMPTE_ID] );
	}

	function getCompteIdFromSession() : ?int {
		return isLogged() ? $_SESSION[COMPTE_ID] : NULL;
	}

	function login(int $id) {
		$_SESSION[COMPTE_ID] = $id;
	}

	function isPassword(string $password) {
		return true;
	}

?>
