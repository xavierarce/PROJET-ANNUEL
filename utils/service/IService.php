<?php

	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/utils/entity/IEntity.php");

	// Définit les opérations de base pour tout service
	interface IService {
		function findAll() : array;

		function findById(int $id) : IEntity;

		function getDao() : IDao;

		function insert(IEntity $entity) : int;

		function delete(int $id);

		function update(IEntity $entity);
	}

?>
