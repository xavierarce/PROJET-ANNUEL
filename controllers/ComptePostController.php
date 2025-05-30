<?php

	require_once(ROOT . "/utils/functions.php");
	require_once(ROOT . "/utils/controller/IController.php");
	require_once(ROOT . "/utils/controller/AbstractController.php");
	require_once(ROOT . "/services/CompteService.php");
	require_once(ROOT . "/model/Compte.php");
	require_once(ROOT . "/exceptions/HttpStatusException.php");

	class ComptePostController extends AbstractController implements IController {

		private CompteService $service;
		private string $login;
		private string $password;
		private string $pseudo;

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
			if ( ! isset($this->form['pseudo']) ) {
				throw new HttpStatusException("param pseudo not exists", 400);
			}
		}

		protected function checkCybersec() {
			if (! isSanitizedString($this->form['login']) ) {
				throw new HttpStatusException("param login is not a valid string", 400);
			}
			$this->login = sanitizeString($this->form['login']);
			if (! isPassword($this->form['password']) ) {
				throw new HttpStatusException("param password is not a valid password", 400);
			}
			$this->password = sanitizeString($this->form['password']);
			if (! isSanitizedString($this->form['pseudo']) ) {
				throw new HttpStatusException("param pseudo is not a valid string", 400);
			}
			$this->pseudo = sanitizeString($this->form['pseudo']);
		}

		protected function checkRights() {
			 // EndPoint public
		}

		protected function processRequest() {
			if ( isLogged() ) {
				throw new HttpStatusException("Already Authenticated", 499);
			}
			$compte = Compte::createForCredential($this->login, $this->password, $this->pseudo);
			$id = $this->service->insert($compte);
			$this->response = $id;
		}

        protected function getService() : IService {
            return $this->service;
        }

	}
?>
