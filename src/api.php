<?php
	define("ROOT", dirname(__FILE__) ); // Tous les appels seront en chemin absolu
	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/exceptions/HttpStatusException.php");
	serverBootstrap();
	manageSession();
	$FORM = extractForm(); // Extrait le formulaire, selon la méthode
	$ROUTE = extractRoute($FORM);
	// J'ai maintenant une route propre et une méthode supportée
	// je crée le contrôleur, et j'enveloppe avec des exceptions
	// Que je vais créer au fur et a mesure
	try {
		$CONTROLLER = createController($FORM, $ROUTE);
		$response = $CONTROLLER->execute();
		header('Content-Type: application/json');
		echo $response;
	} catch (HttpStatusException $ex) {
		raiseHttpStatus($ex);
	} catch (Throwable $ex) {
		// Exception non gérée, on laisse le site se cracher
		throw $ex;
	}


?>
