<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DBConnection.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DBTables.php';

/**
 * @author pawelg
 */
class User
{
    /**
     * 
     * @var string
     */
    private $errorMessage = '';
    
    /**
     * 
     * @var \PDO
     */
    private $pdo;
    
    /**
     * 
     * @var DBTable
     */
    private $dbTables;
    
    /**
     * Name of the table in DB
     * @var string 
     */
    private $dbTableName = DBTables::NAME_OF_TABLE;
    
    /**
     * 
     * @var int|null
     */
    private $id;
    
    /**
     * 
     * @var string|null
     */
    private $name;
    
    /**
     * 
     * @var string|null
     */
    private $lastName;
    
    /**
     * 
     */
    public function __construct()
    {
        $this->dbTables = new DBTables();
        $result = $this->dbTables->getTableList();
        
        if (empty($result)) {
            $this->dbTables->createTables();
        }
        
        $this->pdo = (new DBConnection())->connect();
    }

    /**
     * 
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
    
    /**
     * Pobranie listy 
     * 
     * @return array
     */
    public function index()
    {
        $sqlQuery = "SELECT id, name, lastname FROM " . $this->dbTableName . "";
        
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute();
        
        $users = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }

        return $users;
    }
    
    /**
     * Utworzenie nowego wpisu
     * 
     * @return int
     */
    public function create()
    {
        if ((empty($this->name) || is_null($this->name)) || 
            (empty($this->lastName) || is_null($this->lastName))
        ) {
            $status = 1;
            $this->errorMessage = 'Pola name i lastname nie mogą być puste!';
            return $status;
        }
        
        $sqlQuery = "INSERT INTO
                        " . $this->dbTableName . "(name, lastname) 
                    VALUES (:name, :lastname)";

        $stmt = $this->pdo->prepare($sqlQuery);
        
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":lastname", $this->lastName);

        $status = 0;
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            $status = 1;
            $this->errorMessage = $ex->getMessage();
        }
        
        return $status;
    }
    
    /**
     * Aktualizacja danych
     * 
     * @return int
     */
    public function update()
    {
        if ((empty($this->id) || is_null($this->id)) ||
            (empty($this->name) || is_null($this->name)) || 
            (empty($this->lastName) || is_null($this->lastName))
        ) {
            $status = 1;
            $this->errorMessage = 'Pola id, name i lastname nie mogą być puste!';
            return $status;
        }
        
        $sqlQuery = "UPDATE
                        " . $this->dbTableName . "
                    SET
                        name = :name, 
                        lastname = :lastname
                    WHERE 
                        id = :id";

        $stmt = $this->pdo->prepare($sqlQuery);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":lastname", $this->lastName);
        $stmt->bindParam(":id", $this->id);
        
        $status = 0;
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            $status = 1;
            $this->errorMessage = $ex->getMessage();
        }
        
        return $status;
    }
    
    /**
     * Usunięcie użytkownika 
     * 
     * @param int $param
     */
    public function delete()
    {
        if (empty($this->id) || is_null($this->id)) {
            $status = 1;
            $this->errorMessage = 'Proszę podać id wiersza do usunięcia!';
            return $status;
        }
        
        $sqlQuery = "DELETE FROM " . $this->dbTableName . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        $status = 0;
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            $status = 1;
            $this->errorMessage = $ex->getMessage();
        }
        
        return $status;
    }
}
