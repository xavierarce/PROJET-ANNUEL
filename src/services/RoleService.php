<?php

	require_once(ROOT. "/utils/service/IService.php");
	require_once(ROOT. "/utils/service/AbstractService.php");
	require_once(ROOT. "/utils/entity/IEntity.php");
	require_once(ROOT. "/utils/dao/IDao.php");
	require_once(ROOT. "/daos/RoleDao.php");

	class RoleService extends AbstractService implements IService {

		protected RoleDao $dao;

		public function __construct() {
			$this->dao = new RoleDao();
		}

        function getDao() : IDao {
			return $this->dao;
        }
	}



?>
