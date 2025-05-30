<?php

	require_once(ROOT . "/utils/entity/IEntity.php");
	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/utils/dao/AbstractDao.php");
	require_once(ROOT . "/model/Role.php");

	class RoleDao extends AbstractDao implements IDao {

		protected function getTableName(): string {
			return "Role";
		}

        protected function getPrimaryKeyName(): string {
			return "id_role";
		}

        protected function createEntityFromRow($row): IEntity {
			return Role::createFromRow($row);
		}

	}

?>
