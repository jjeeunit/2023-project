<?php

class Log
{
    private static $instance = null;
    public $storage;

    public function __construct()
    {
        $this->storage = realpath(__DIR__ . '/..') . '/weblog';
    }//end method __construct

    public static function conn()
    {
        if (is_null(Log::$instance)) Log::$instance = new Log;
        return Log::$instance;
    }//end method conn

    public function write($message, $delimiter, $flag)
    {
        $text = vsprintf('[%s] ' . $flag . ' : %s', $message);
        $log = 'log_' . $delimiter . '_' . $flag . '_' . date('Ymd'). '.log';

        return error_log($text . PHP_EOL . PHP_EOL, 3, $this->storage . '/' . $log);
    }//end method write

    public function error($msg, $delimiter)
    {
        $data = [date('Y-m-d H:i:s'), $msg];
        $this->write($data, strtoupper($delimiter), 'error');
    }//end method error

    public function debug($msg, $delimiter)
    {
        $data = [date('Y-m-d H:i:s'), $msg];
        $this->write($data, strtoupper($delimiter), 'debug');
    }//end method debug

}//end class
