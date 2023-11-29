<?php

class DB
{
    private static $instance;
    protected $dbc;

    private function __construct()
    {
        $this->init();
    }//end __construct

    public static function conn()
    {
        if (!isset(DB::$instance)) DB::$instance = new DB;

        return DB::$instance;
    }//end getInstance

    private function init()
    {
        try {
            $dns = 'mysql:host=localhost;port=3306;dbname=jeeun93;charset=utf8mb4;collation=utf8mb4_unicode_ci';
            $this->dbc = new \PDO($dns, 'jeeun93', 'wpdms123!');

            $this->dbc->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbc->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            $this->dbc->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\Exception $E) {
            Log::conn()->error('PDO Exception. ' . $E->getMessage(), 'PDO');
        }
    }//end method init

    private function removeEol($sql)
    {
        return str_replace(PHP_EOL, '', $sql);
    }//end method removeEol

    public function _transaction()
    {
        return $this->dbc->beginTransaction();
    }//end method transaction

    public function _commit()
    {
        return $this->dbc->commit();
    }//end method commit

    public function _rollback()
    {
        return $this->dbc->rollback();
    }//end method rollback

    public function insert($sql, $param = array(), $lastid = false, $preview = false)
    {
        if ($preview == true) $this->prevSql($sql, $param);
        $stmt = $this->dbc->prepare($sql);
        return $stmt->execute($param);
    }//end method insert

    public function insertId($sql, $param = array(), $preview = false)
    {
        if ($preview == true) $this->prevSql($sql, $param);
        $stmt = $this->dbc->prepare($sql);
        if (true !== $stmt->execute($param)) return false;
        return $this->dbc->lastInsertId();
    }//end function insertId

    public function select($sql, $param = array(), $preview = false)
    {
        if ($preview == true) $this->prevSql($sql, $param);
        $stmt = $this->dbc->prepare($this->removeEol($sql));
        if(true !== $stmt->execute($param)) return false;
        return $stmt->fetch();
    }//end method select

    public function selectAll($sql, $param = array(), $preview = false)
    {
        if ($preview == true) $this->prevSql($sql, $param);
        $stmt = $this->dbc->prepare($this->removeEol($sql));
        if(true !== $stmt->execute($param)) return false;
        return $stmt->fetchAll();
    }//end method selectAll

    public function update($sql, $param = array(), $preview = false)
    {
        if ($preview == true) $this->prevSql($sql, $param);
        $stmt = $this->dbc->prepare($sql);
        return $stmt->execute($param);
    }//end method update

    public function delete($sql, $param= array(), $preview = false)
    {
        if ($preview == true) $this->prevSql($sql, $param);
        $stmt = $this->dbc->prepare($sql);
        return $stmt->execute($param);
    }//end method delete

    public function lockTable($table = '', $mode = 'READ')
    {
        return $this->dbc->exec('lock tables ' . $table . ' '. $mode );
    }//end method lockTable

    public function unlockTable()
    {
        return $this->dbc->exec('unlock tables');
    }//end method unlockTable

    public function execQuery($sql, $param = array())
    {
        $stmt = $this->dbc->prepare($sql);
        return $stmt->execute($param);
    }//end method execQuery

    public function prevSql($sql, $param)
    {
        foreach (array_fill(0, count($param), '?') as $key => $placeholder) {
            $sql = substr_replace(
                    $sql
                    , '\'' . $param[$key] . '\''
                    , strpos($sql, $placeholder)
                    , strlen($placeholder)
            );
        }
        exit($sql . '<br>');
    }//end method prevSql

}//end class