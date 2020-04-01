<?php 

class ConfigReader {

    private $cnfgFileName;
    private $dirCnfgFiles = "../config/";
    private $logFileDir = "../logs/lgs.log";

    public function __construct(string $cnfgFileName) {
        $this->cnfgFileName = $cnfgFileName;
    }

    public function getDataArrayFromConfigFile() {
        $jsonStr = file_get_contents($this->dirCnfgFiles . $this->cnfgFileName);
        if ($jsonStr === FALSE) {
            $message = date("[Y-m-d H:i:s]") . "Can't read file " . $this->cnfgFileName . "\n";
            error_log($message, 3, $logFileDir );
            echo $message;
        } else {
            $dataArray = json_decode($jsonStr, true);
        }
        return $dataArray;
    }

    public function getLogFileDir() : string {
        return $this->logFileDir;
    }
}

?>