<?php

	require_once(ROOT . "/utils/controller/IController.php");
	require_once(ROOT . "/utils/functions.php");

	class SessionGetController implements IController {

		public function __construct(array $form) {
//			parent::__construct($form);
		}

		public function execute() : string {
			$sessionState = new stdClass();
			$sessionState->startTime = $_SESSION[START_TIME];
			$sessionState->endTime = $_SESSION[START_TIME] + getMaxTime();
			$sessionState->isLogged = isLogged();
			return json_encode( $sessionState );
		}

	}
?>
