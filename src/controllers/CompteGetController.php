<?php

	require_once(ROOT . "/utils/controller/IController.php");
	require_once(ROOT . "/utils/controller/AbstractGetController.php");
	require_once(ROOT . "/services/CompteService.php");

	class CompteGetController extends AbstractGetController implements IController {

		protected CompteService $service;

		public function __construct(array $form) {
			parent::__construct($form);
			$this->service = new CompteService();
		}

        protected function getService() : IService {
            return $this->service;
        }

	}
?>
