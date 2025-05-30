<?php

	require_once(ROOT. "/utils/service/IService.php");
	require_once(ROOT. "/utils/service/AbstractService.php");
	require_once(ROOT. "/utils/entity/IEntity.php");
	require_once(ROOT. "/utils/dao/IDao.php");
	require_once(ROOT. "/daos/CompteDao.php");
	require_once(ROOT. "/services/RoleService.php");

	class CompteService extends AbstractService implements IService {

		protected CompteDao $dao;
		protected RoleService $roleService;

		public function __construct() {
			$this->dao = new CompteDao();
			$this->roleService = new RoleService();
		}

        function getDao() : IDao {
			return $this->dao;
        }

		function isValidCredential(Compte $compte) : ?int {
			return $this->dao->isValidCredential($compte);
		}

		function insert(IEntity $compte) : int {
			/** @var Compte $compte */
			// Règle métier n°1 : par defaut un compte est de role rédacteur (pk = 1)
			$role = $this->roleService->findById(1);
			// Règle métier n°2 : par defaut un compte passe en modération, l'admin fera le reste
			$compte->setEnAttenteDeModeration( true );
			$compte->setRole($role);
			$date = new DateTime();
			$compte->setDateCreation( $date );
			$compte->setDateModification( $date );
			$compte->setEstSupprime( false );
			$compte->setEstSignale( false );
			$compte->setEstBanni( false );
			return parent::insert($compte);
		}
	}

?>
