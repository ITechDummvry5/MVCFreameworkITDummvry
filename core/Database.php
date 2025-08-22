<?php

namespace app\core;

class Database {

    public \PDO $pdo;

    public function __construct(array $config) {
        // Initialize database connection here
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new \PDO($dsn , $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations(){
        $this->createMigrationTable();
        $appliedMigrations = $this->getAppliedMigrations(); 
        // $appliedMigrations = this is the output of getapplied ['m0001_initial.php'];

        $newMigrations = [];

        $files = scandir(Application::$ROOT_DIR . '/migrations');
        // $appliedMigrations = this is output of appliedMigrations that already  its like next  ['.', '..', 'm0002_initial.php']
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once Application::$ROOT_DIR . "/migrations/{$migration}";
            // require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            //same thing only for showcase

            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }
        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        }else {
            $this->log("All migrations are applied");
        }
    }

    public function createMigrationTable(){
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB");
    }
    public function getAppliedMigrations(){
       $statement =  $this->pdo->prepare("SELECT migration FROM migrations"); 
        // migration = column  migrations = table name
       $statement->execute();
       return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }
    
    public function saveMigrations(array $migration){

    $str = implode(",", array_map(fn($m) => "('$m')", $migration));

    $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }
   public function log($message) {
    echo '[' . date('M d, Y h:i:s A') . "] $message" . PHP_EOL;
}

}