<?php

require_once(ROOT . "/utils/entity/IEntity.php");
require_once(ROOT . "/utils/entity/AbstractEntity.php");

class Role extends AbstractEntity implements IEntity
{
	private $idRole;
	private $label;

	function __contruct()
	{ /* RAS */
	}

	function getIdRole(): int
	{
		return $this->idRole;
	}

	function setIdRole(int $id)
	{
		$this->idRole = $id;
	}

	function getLabel(): string
	{
		return $this->label;
	}

	function setLabel(string $l)
	{
		$this->label = $l;
	}

	public static function createFromRow($row)
	{
		$role = new Role();
		$role->setIdRole(intval($row->id_role));
		$role->setLabel($row->label);
		return $role;
	}


	public static function createForRolePost(string $label): Role
	{
		$role = new Role();
		$role->setLabel($label);
		return $role;
	}
}