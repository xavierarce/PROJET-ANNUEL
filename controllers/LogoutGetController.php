<?php

	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/utils/controller/IController.php");
	require_once(ROOT . "/utils/controller/AbstractController.php");

	class LogoutGetController extends AbstractController implements IController {

		public function __construct(array $form) {
			parent::__construct($form);
		}

		protected function checkForm() { }

		protected function checkCybersec() { }

		protected function checkRights() {
			 // EndPoint public
		}

		protected function processRequest() {
			reinitSession();
			$this->response = "";
		}

        protected function getService() : IService {
            throw new Exception("Ce controlleur n'a pas besoin de service");
        }

	}
?>
