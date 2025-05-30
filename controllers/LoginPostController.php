<?php

	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/utils/controller/IController.php");
	require_once(ROOT . "/utils/controller/AbstractController.php");
	require_once(ROOT . "/services/CompteService.php");
	require_once(ROOT . "/model/Compte.php");
	require_once(ROOT . "/exceptions/HttpStatusException.php");

	class LoginPostController extends AbstractController implements IController {

		private CompteService $service;
		private string $login;
		private string $password;

		public function __construct(array $form) {
			parent::__construct($form);
			$this->service = new CompteService();
		}

		protected function checkForm() {
			if ( ! isset($this->form['login']) ) {
				throw new HttpStatusException("param login not exists", 400);
			}
			if ( ! isset($this->form['password']) ) {
				throw new HttpStatusException("param password not exists", 400);
			}
		}

		protected function checkCybersec() {
			if (! isSanitizedString($this->form['login']) ) {
				throw new HttpStatusException("param login is not a valid string", 400);
			}
			$this->login = sanitizeString($this->form['login']);
			if (! isSanitizedString($this->form['password']) ) {
				throw new HttpStatusException("param password is not a valid string", 400);
			}
			$this->password = sanitizeString($this->form['password']);
		}

		protected function checkRights() {
			 // EndPoint public *
		}

		protected function processRequest() {
			if ( isLogged() ) {
				throw new HttpStatusException("Already Authenticated", 499);
			}
			$compte = Compte::createForCredential($this->login, $this->password);
			$id = $this->service->isValidCredential($compte);
			if ( is_null($id) ) {
				throw new HttpStatusException("Invalid Credential", 499);
			}
			login($id);
			$this->response = "";
		}

        protected function getService() : IService {
            return $this->service;
        }

	}
?>
