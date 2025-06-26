<?php

	require_once(ROOT . "/utils/entity/IEntity.php");

	interface IDao {

		function findAll();

		function findById(int $id) : IEntity;

		function getDao() : IDao;

		function insert(IEntity $entity) : int;

		function delete(int $id);

		function update(IEntity $entity);

	}

?>
