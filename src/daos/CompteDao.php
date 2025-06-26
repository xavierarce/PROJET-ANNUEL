<?php

	require_once(ROOT . "/utils/entity/IEntity.php");
	require_once(ROOT . "/utils/dao/IDao.php");
	require_once(ROOT . "/utils/dao/AbstractDao.php");
	require_once(ROOT . "/model/Compte.php");
	require_once(ROOT . "/daos/RoleDao.php");
	require_once(ROOT . "/exceptions/HttpStatusException.php");

	class CompteDao extends AbstractDao implements IDao {

		private RoleDao $roleDao;

		public function __construct() {
			$this->roleDao = new RoleDao();
		}

		protected function getTableName(): string {
            return "Compte";
        }

        protected function getPrimaryKeyName(): string {
            return "id_compte";
        }

        protected function createEntityFromRow($row): IEntity {
            return Compte::createFromRow($row);
        }

		function findById(int $id) : IEntity {
			$c = parent::findById($id);
//			$c->setRole( $this->roleDao->findById($c->) );
			return $c;
		}

		function isValidCredential(Compte $compte) : ?int {
            // Dans un premier temps je vais chercher tous les tuples qui ont pour login $compte-getLogin();
			$pdo = BddSingleton::getinstance()->getPdo();
			// TODO : Attention =, comptes supprimés, bani, en modération...
			$stmt = $pdo->prepare("SELECT id_compte, password FROM Compte WHERE login = ? LIMIT 1");
			$stmt->bindValue(1, $compte->getLogin() );
			$stmt->setFetchMode(PDO::FETCH_OBJ);
			$stmt->execute();
			$row = $stmt->fetch();
			if ( ! $row ) {
				return NULL;
			}
			// On teste si le password et le hachage correspondent
			if (password_verify($compte->getPassword(), $row->password) ) {
				return $row->id_compte;
			}
			return NULL;
        }

		function insert(IEntity $compte) : int {
			$pdo = BddSingleton::getInstance()->getPdo();
			$sql = "INSERT INTO Compte ("
				. "login, password, pseudo, dateCreation, dateModification, estSupprime, estSignale, estBanni, enAttenteDeModeration, fk_role) "
				. " VALUES (:log, :pwd, :pseudo, :dCreation, :dMod, :estSupp, :estSign, :estBan, :enAttMod, :idRole)";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(":log", $compte->getLogin() );
			$hash = password_hash($compte->getPassword(), PASSWORD_BCRYPT);
			$stmt->bindValue(":pwd", $hash );
			$stmt->bindValue(":pseudo", $compte->getPseudo() );
			$stmt->bindValue(":dCreation", $compte->getDateCreation()->format(MYSQL_DATE_FORMAT) );
			$stmt->bindValue(":dMod", $compte->getDateModification()->format(MYSQL_DATE_FORMAT) );
			$stmt->bindValue(":estSupp", $compte->estSupprime(), PDO::PARAM_BOOL);
			$stmt->bindValue(":estSign", $compte->estSignale(), PDO::PARAM_BOOL);
			$stmt->bindValue(":estBan", $compte->estBanni(), PDO::PARAM_BOOL);
			$stmt->bindValue(":enAttMod", $compte->enAttenteDeModeration(), PDO::PARAM_BOOL);
			$stmt->bindValue(":idRole", $compte->getRole()->getIdRole(), PDO::PARAM_INT );
			try {
				$stmt->execute();
				return $pdo->lastInsertId();
			} catch (PDOException $ex) {
				// 2 erreurs potentielles de contraintes uniques (login / pseudo)
				// SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '...' for key 'Table.nom_UNIQUE'
				if (str_starts_with($ex->getMessage(), "SQLSTATE[23000]:") ) {
					$msg = explode(": ", $ex->getMessage())[2];
					if ( str_starts_with($msg, "1062 ") ) {
						$msg = explode(" ", $msg)[6];
						throw new HttpStatusException("UNIQUE : " . $msg, 499);
					}
				}
				throw new HttpStatusException($ex->getMessage(), 500, $ex);
			}
		}

	}

?>
