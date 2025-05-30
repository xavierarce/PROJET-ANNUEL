<?php

	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/utils/entity/IEntity.php");
	require_once(ROOT . "/utils/service/IService.php");

	// On utilise ici le concept de Design pattern Adapter
	// Le service va propose une "adaptation" vers les Dao
	abstract class AbstractService implements IService {
		function findAll() : array {
			return $this->getDao()->findAll();
		}

		function findById(int $id) : IEntity {
			return $this->getDao()->findById($id);
		}

		abstract function getDao() : IDao;

		function insert(IEntity $entity) : int {
			return $this->getDao()->insert($entity);
		}

		function delete(int $id) {
			return $this->getDao()->delete($id);
		}

		function update(IEntity $entity) {
			return $this->getDao()->update($entity);
		}
	}

?>
