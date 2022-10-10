<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DB.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/classes/DBConnection.php';

/**
 * @author pawelg
 */
class DBTables
{

    const NAME_OF_TABLE = 'users';
    
    /**
     * 
     * @var \PDO
     */
    private $pdo;

    /**
     * 
     * @return \PDO
     */
    public function __construct()
    {
        $this->pdo = (new DBConnection())->connect();
    }

    /**
     * Metoda pomocnicza 
     * 
     * @return array
     */
    public function getTableList()
    {
        $stmt = $this->pdo->query("
            SELECT name FROM sqlite_master WHERE type = 'table' ORDER BY name
        ");

        $tables = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tables[] = $row['name'];
        }

        return $tables;
    }

    /**
     * Utworzenie tabel w bazie danych
     * 
     * @return void
     */
    public function createTables(): void
    {
        $tablesList = $this->getTableList();

        if (empty($tablesList)) {
            $commands = [
                'CREATE TABLE IF NOT EXISTS ' . self::NAME_OF_TABLE . ' (
                    id INTEGER PRIMARY KEY,
                    name TEXT,
                    lastname TEXT,
                    UNIQUE(name, lastname)
                )'
            ];

            foreach ($commands as $command) {
                $this->pdo->exec($command);
            }

            //echo "Utworzono tabele!";
        } else {
            //echo "Tabele już utworzono wcześniej!";
        }
    }

}
