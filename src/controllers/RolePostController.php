<?php

require_once(ROOT . "/utils/functions.php");
require_once(ROOT . "/utils/controller/IController.php");
require_once(ROOT . "/utils/controller/AbstractController.php");
require_once(ROOT . "/services/RoleService.php");
require_once(ROOT . "/model/Role.php");
require_once(ROOT . "/exceptions/HttpStatusException.php");

class RolePostController extends AbstractController implements IController
{

	private RoleService $service;
	private string $label;
	// private string $password;
	// private string $pseudo;

	public function __construct(array $form)
	{
		parent::__construct($form);
		$this->service = new RoleService();
	}

	protected function checkForm()
	{
		if (! isset($this->form['label'])) {
			throw new HttpStatusException("param label not exists", 400);
		}
	}

	protected function checkCybersec()
	{
		if (! isSanitizedString($this->form['label'])) {
			throw new HttpStatusException("param label is not a valid string", 400);
		}
		$this->label = sanitizeString($this->form['label']);
	}

	protected function checkRights()
	{
		// EndPoint public
	}

	protected function processRequest()
	{
		// if (!isLogged()) {
		// 	throw new HttpStatusException("", 401);
		// }
		$role = Role::createForRolePost($this->label); // Returns an instance of Role
		$id = $this->service->insert($role); // Calls the service to insert the role
		$this->response = $id; // returns the ID of the newly created role
	}

	protected function getService(): IService
	{
		return $this->service;
	}
}
