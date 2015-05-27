<?php
class DbUnit {
    
    public $dbhost;
    public $dbname;
    public $dbuser;
    public $dbpass;
    public $dblink;
    public $expression;
    public $rows;
    public $statement;
    public $dbobject;
    public $dbarray;
    
    function __construct ($dbparam)
    {
      
        $this->dbhost   = $dbparam['dbhost'];
        $this->dbname   = $dbparam['dbname'];
        $this->dbuser   = $dbparam['dbuser'];
        $this->dbpass   = $dbparam['dbpass'];
        $this->dbport   = $dbparam['dbport'];
       
    }
    
    public function connect() 
    {
                  	
            $this->dblink = pg_connect('host='. $this->dbhost .' port='. $this->dbport .' dbname='. $this->dbname .' user='. $this->dbuser .' password='. $this->dbpass);
            if (!$this->dblink) {
                return false;
            } else {
                return true;
            }
            //or die(pg_get_result(pg_result_error($this->dblink))) ;
         
      
    }
    
    protected function hundleError ()
    {
        
          throw new Exception   ('|ExceptionMessage='.$this->expression.
                                 '|Info='.pg_get_result(pg_result_error($this->statement)).
                                 '|Expression='.$this->expression);
      
    }
    
    public function exec($expression)
    {
        $this->expression = $expression;
        if (!$this->dblink->exec($expression)){
            $this->hundleError();
        } else {
            return $this->rows;
        }
        
    }
    
    public function query($query)
    {
       $this->expression = $query;
       if (!$this->statement =  pg_query($this->dblink,$query)){
            $this->hundleError();
       } else {
            return true;
       }
    }
    
      
    
    public function getObject()
    {
      
     
       if ($this->dbobject = $this->pdostatement->fetch(PDO::FETCH_OBJ)) {
            return $this->dbobject;
       } else {return false;}
        
    }
    
    public function getArray () 
    {
       if ($this->dbarray = pg_fetch_assoc($this->statement)) {
            return $this->dbarray;
       } else {return false;}
             
    }
    
    public function getArrayValue ($key) 
    {
       if ($this->dbarray = pg_fetch_assoc($this->statement)) {
            return $this->dbarray[$key];
       } else {return false;}
             
    }
    
    public function getColumcount ()
    {
        return $this->pdostatement->columnCount();
    }
    
    public function getRowscount ()
    {
        return pg_num_rows($this->statement);
    }
    
    
    public function close () 
    {
        $this->dblink->close();
    }
}
?>