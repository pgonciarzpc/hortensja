<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DB.php';

/**
 * @author pawelg
 */
class DBConnection
{
    /**
     * 
     * @var \PDO
     */
    private $pdo;
    
    /**
     * Zwraca instancję do obiektu PDO
     * 
     * @return \PDO
     */
    public function connect()
    {
        if ($this->pdo == null) {
            try {
                $this->pdo = new \PDO("sqlite:" . '../' . DB::PATH_TO_SQLITE_FILE);
            } catch (PDOException $exc) {
                echo "Nie można się połączyć z bazą danych";
                echo "<br>";
                echo $exc->getTraceAsString();
                die();
            }
        }
        
        return $this->pdo;
    }
}
