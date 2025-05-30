<?php

	require_once(ROOT . "/utils/entity/IEntity.php");
	require_once(ROOT . "/utils/entity/AbstractEntity.php");

	class Compte extends AbstractEntity implements IEntity {
		private $idCompte;
		private $login;
		private $password;
		private $dateCreation;
		private $dateModification;

		private $enAttenteDeModeration;
		private $estSupprime;

		private $role;

		private $estSignale;
		private $estBanni;
		private $pseudo;

		function __contruct() { /* RAS */ }

		function getIdCompte() : int {
			return $this->idCompte;
		}

		function setIdCompte(int $id) {
			$this->idCompte = $id;
		}

		function getLogin() : string {
			return $this->login;
		}

		function setLogin(string $login) {
			$this->login = $login;
		}

		function getPassword() : string {
			return $this->password;
		}

		function setPassword(?string $pwd) {
			$this->password = $pwd;
		}

		function getDateCreation() : DateTime {
			return $this->dateCreation;
		}

		function setDateCreation(DateTime $date) {
			$this->dateCreation = $date;
		}

		function getDateModification() : DateTime {
			return $this->dateModification;
		}

		function setDateModification(DateTime $date) {
			$this->dateModification = $date;
		}

		function enAttenteDeModeration() : bool {
			return $this->enAttenteDeModeration;
		}

		function setEnAttenteDeModeration(bool $b) {
			$this->enAttenteDeModeration = $b;
		}

		function estSupprime() : bool {
			return $this->estSupprime;
		}

		function setEstSupprime(bool $b) {
			$this->estSupprime = $b;
		}

		function estSignale() : bool {
			return $this->estSignale;
		}

		function setEstSignale(bool $b) {
			$this->estSignale = $b;
		}

		function setEstBanni(bool $b) {
			$this->estBanni = $b;
		}

		function estBanni() : bool {
			return $this->estBanni;
		}

		function getPseudo() : string {
			return $this->pseudo;
		}

		function setPseudo(string $s) {
			$this->pseudo = $s;
		}

		function getRole() : Role {
			return $this->role;
		}

		function setRole(Role $Role) {
			$this->role = $Role;
		}

		public static function createFromRow($row, bool $keepPassword = false) {
			$compte = new Compte();
			$compte->setIdCompte( intval($row->id_compte) );
			$compte->setLogin( $row->login );
			$compte->setPseudo($row->pseudo); // ICI
			$compte->setPassword( $keepPassword ? $row->password : NULL );
			$compte->setDateCreation( new DateTime($row->dateCreation) );
			$compte->setDateModification( new DateTime($row->dateModification) );
			$compte->setEnAttenteDeModeration( boolval($row->enAttenteDeModeration) );
			$compte->setEstSupprime( boolval($row->estSupprime) );
			$compte->setEstSignale( boolval($row->estSignale) ); // ICI
			$compte->setEstBanni( boolval($row->estBanni) ); // ICI
			return $compte;
		}

		public static function create($email, $pseudo, $password) {
			$compte = new Compte();
			$compte->setLogin( $email );
			$compte->setPseudo($pseudo); // ICI
			$compte->setPassword( $password );
			$compte->setDateCreation( new DateTime() );
			$compte->setDateModification( new DateTime() );
			$compte->setEnAttenteDeModeration( true );
			$compte->setEstSupprime( false );
			$compte->setEstSignale( false ); // ICI
			$compte->setEstBanni( false ); // ICI
			return $compte;
		}

		public static function createForCredential(string $login, string $password, string $pseudo = null) {
			$compte = new Compte();
			$compte->setLogin( $login );
			$compte->setPassword( $password );
			$compte->setPseudo( $pseudo );
			return $compte;
		}

	}

?>
