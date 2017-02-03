<?php

class Logger {
    /*     * * Declare instance ** */

    private static $instance = NULL;
    public $logfile;

    /**
     *
     * @Constructor is set to private to stop instantion
     *
     */
    public function __construct() {
       $this->logfile  = "/tmp/cron-monitor.txt";
    }

    /**
     *
     * @settor
     *
     * @access public
     *
     * @param string $name
     *
     * @param mixed $value
     *
     */
    public function __set($name, $value) {
        switch ($name) {
            case 'logfile':
                if (!file_exists($value) || !is_writeable($value)) {
                    throw new Exception("$value is not a valid file path");
                }
                $this->logfile = $value;
                break;

            default:
                throw new Exception("$name cannot be set");
        }
    }

    /**
     *
     * @write to the logfile
     *
     * @access public
     *
     * @param string $message
     *
     * @param string $file The filename that caused the error
     *
     * @param int $line The line that the error occurred on
     *
     * @return number of bytes written, false other wise
     *
     */
    public function write($message, $file = null, $line = null) {
        $dateTime = date( 'Y-m-d H:i:s');
        $message = $dateTime . ' - ' . $message;
        $message .= is_null($file) ? '' : " in $file";
        $message .= is_null($line) ? '' : " on line $line";
        $message .= "\n";
        return file_put_contents($this->logfile, $message, FILE_APPEND);
    }

    /**
     *
     * Return logger instance or create new instance
     *
     * @return object (PDO)
     *
     * @access public
     *
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Base_Model_Lib_Ext_Logger();
        }
        return self::$instance;
    }

    /**
     * Clone is set to private to stop cloning
     *
     */
    private function __clone() {
        
    }

}
?>