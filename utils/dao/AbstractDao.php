<?php

	require_once(ROOT . "/utils/entity/IEntity.php");
	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/utils/BddSingleton.php");

	abstract class AbstractDao implements IDao {

		function findAll() { throw new Exception("not implemented"); }

		function findById(int $id) : IEntity {
			$pdo = BddSingleton::getinstance()->getPdo();
            $sql = "SELECT e.* FROM " . $this->getTableName() . " e WHERE e." . $this->getPrimaryKeyName() . " = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $id);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $row = $stmt->fetch();
            if ( ! $row ) {
                throw new HttpStatusException("Entity " . $this->getTableName() . " : " . $id, 404);
            }
            return $this->createEntityFromRow($row);
		}

		protected abstract function getTableName(): string;
		protected abstract function getPrimaryKeyName(): string;
		protected abstract function createEntityFromRow($row): IEntity;

		public function getDao() : IDao {
			throw new Exception("Not implemented");
		}

		function insert(IEntity $entity) : int {
			throw new Exception("not implemented");
		}

		function delete(int $id) {
			throw new Exception("not implemented");
		}

		function update(IEntity $entity) {
			throw new Exception("not implemented");
		}

	}

?>
