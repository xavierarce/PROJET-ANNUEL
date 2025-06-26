<?php

	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/utils/controller/IController.php");
	require_once(ROOT . "/exceptions/HttpStatusException.php");

	abstract class AbstractController implements IController {

		protected array $form;
		protected mixed $response;

		public function __construct(array $form) {
			$this->form = $form;
		}

		public function execute() : string {
			$this->checkForm();
			$this->checkCybersec();
			$this->checkRights();
			$this->processRequest();
			return $this->processResponse();
		}

		protected abstract function checkForm();

		protected abstract function checkCybersec();

		protected function checkRights() { }

		protected abstract function processRequest();

		protected function processResponse() {
			if ( is_null($this->response) ) {
				error_log("Unable to find something"); // TODO Faire une méthode abstraite
				throw new HttpStatusException("", 404);
			}
			$output = json_encode( $this->response );
			$cleanedOutput = ltrim( $output ); // Suppression des espaces et cie avant et après
			return $cleanedOutput;
		}


	}
?>
