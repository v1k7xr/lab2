<?php 
require('../lib/configReader.php');

class DataBaseWorker {

    private $connectionData;
    protected $connection;
    private $cnfReader;

    public function __construct() {
        $this->cnfReader = new ConfigReader('dbConf.json');
        $this->connectionData = $this->cnfReader->getDataArrayFromConfigFile();
    }

    public function startConnection() {
        try {
            $this->connection = new PDO("pgsql:host={$this->connectionData['dbconnection']['host']};
                                         dbname={$this->connectionData['dbconnection']['dbname']}",
                                         $this->connectionData['dbconnection']['username'],
                                         $this->connectionData['dbconnection']['userpsswrd'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $e) {
            $message = date("[Y-m-d H:i:s]") . $e->getMessage() . "\n";
            echo $message;
            error_log($message, 3, $this->cnfReader->getLogFileDir() );
            die();
        }
    }

    public function closeConnection() {
        $this->connection = null;
    }
}

// $test = new DataBaseWorker();
// $test->startConnection();
// $test->testQuery();

?>