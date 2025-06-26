<?php

	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/utils/controller/IController.php");
	require_once(ROOT . "/utils/controller/AbstractController.php");
	require_once(ROOT . "/exceptions/HttpStatusException.php");

	abstract class AbstractGetController extends AbstractController implements IController {

		protected int $id;
		protected mixed $response;

		public function __construct(array $form) {
			parent::__construct($form);
		}

		// Test si les parametres sont bien présents
		protected function checkForm() {
			if ( !isset($this->form['id']) ) {
				throw new HttpStatusException("param id not exists", 400);
			}
		}

		protected function checkCybersec() {
				if (! isNaturalInteger($this->form['id']) ) {
					throw new HttpStatusException("param id is not a natural integer", 400);
				}
				$this->id = intval($this->form['id']);
		}

		protected abstract function getService() : IService;

		protected function processRequest() {
			$this->response = $this->getService()->findById($this->id);
		}

	}
?>
