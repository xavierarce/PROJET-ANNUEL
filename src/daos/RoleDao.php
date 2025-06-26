<?php

require_once(ROOT . "/utils/entity/IEntity.php");
require_once(ROOT . "/utils/dao/IDao.php");
require_once(ROOT . "/utils/dao/AbstractDao.php");
require_once(ROOT . "/model/Role.php");

class RoleDao extends AbstractDao implements IDao
{

	protected function getTableName(): string
	{
		return "Role";
	}

	protected function getPrimaryKeyName(): string
	{
		return "id_role";
	}

	protected function createEntityFromRow($row): IEntity
	{
		return Role::createFromRow($row);
	}

	function insert(IEntity $entity): int
	{
		/** @var Role $entity */
		$pdo = BddSingleton::getInstance()->getPdo();
		$sql = "INSERT INTO " . $this->getTableName() . " (label) VALUES (:lbl)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':lbl', $entity->getLabel());

		try {
			$stmt->execute();
			return $pdo->lastInsertId();
		} catch (PDOException $ex) {
			// Check for duplicate entry (MySQL error code 1062)
			if (str_starts_with($ex->getMessage(), "SQLSTATE[23000]")) {
				$msgParts = explode(": ", $ex->getMessage(), 3);
				if (isset($msgParts[2]) && str_contains($msgParts[2], "1062")) {
					throw new HttpStatusException("UNIQUE constraint violation", 498, $ex);
				}
			}

			// Otherwise, throw a general DB error
			throw new HttpStatusException($ex->getMessage(), 500, $ex);
		}
	}
}
