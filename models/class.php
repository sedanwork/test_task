<?php

define('MYSQL_SERVER', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', '');
define('MYSQL_DB', 'the_prorerty');

class DB_connect
{
    private $link;
    
    function __construct()
    {
        $this->link = mysqli_connect(MYSQL_SERVER, MYSQL_USER,                                    MYSQL_PASSWORD, MYSQL_DB);
        
        if(mysqli_connect_errno())
        {
            printf("Не удалось подключиться: %s\n",                           mysqli_connect_error());
            exit();
        }
        
        if(mysqli_set_charset($this->link, "utf8"))
            {
                echo "connection created <br>";
            }
        
        else
            {
                printf("Ошибка при загрузке набора символов utf8: %s\n",                    mysqli_error($this->link));             
                exit();
            }
    }
    
    
    public function findId($table, $name, $surname, $dateOfBirth)
    {
        $sql = "SELECT id FROM `%s` WHERE name = '%s' AND surname = '%s'";
        
        $query = sprintf($sql, 
                         mysqli_real_escape_string($this->link, trim($table)),
                         mysqli_real_escape_string($this->link, trim($name)),
                         mysqli_real_escape_string($this->link, trim($surname)));
        
        $res = mysqli_query($this->link, $query);
        
        if(mysqli_num_rows($res) == 0)
            {
                return 0;
            }
        
        else
        {
            $temp = mysqli_fetch_assoc($res);
            return (int)reset($temp);
        }
    }
    
    public function createId($table, $name, $surname, $dateOfBirth)
    {
        $sql = "INSERT INTO `%s` (`name`, `surname`, `date_of_birth`) 
                VALUES ('%s', '%s', '2017-01-04')";
        
        $query = sprintf($sql, mysqli_real_escape_string($this->link, trim($table)),                        mysqli_real_escape_string($this->link, trim($name)),
                               mysqli_real_escape_string($this->link, trim($surname)));
        
        $temp = mysqli_query($this->link, $query);
        return $temp;    
    }
    
    public function getId($table, $name, $surname, $dateOfBirth)
    {
        $res = $this->findId($table, $name, $surname, $dateOfBirth);
        
        if($res != 0)
        {            
            return $res;
        }
        
        else
        {
            if($this->createId($table, $name, $surname, $dateOfBirth))
                {
                    $res = $this->findId($table, $name, $surname,                              $dateOfBirth);

                    return $res;
                }
            
            else
                {
                    echo "can't create row";
                }
        }

    }
    
    private function find_main($price, $owner_id, $realtor_id)
    {
        $sql = "SELECT id FROM `main` WHERE price = '%d'AND owner_id = '%d' AND               realtor_id = '%d'";
        
        $query = sprintf($sql, mysqli_real_escape_string($this->link, $price),                              mysqli_real_escape_string($this->link, $owner_id),
                               mysqli_real_escape_string($this->link, $realtor_id));
        
        $res = mysqli_query($this->link, $query);
        
        if(mysqli_num_rows($res) == 0)
            {
                return 0;
            }
        
        else
        {
            $temp = mysqli_fetch_assoc($res);
            return (int)reset($temp);
        }
    }
    
    private function create_main($price, $owner_id, $realtor_id)
    {
        $sql = "INSERT INTO `main` (`price`, `owner_id`, `realtor_id`) 
                VALUES ('%d', '%d', '%d')";
        
        $query = sprintf($sql, mysqli_real_escape_string($this->link, $price),                              mysqli_real_escape_string($this->link, $owner_id),
                               mysqli_real_escape_string($this->link, $realtor_id));

        $temp = mysqli_query($this->link, $query);
        
        return $temp;
    }
    
    public function add($price, $owner_id, $realtor_id)
    {        
        $res = $this->find_main($price, $owner_id, $realtor_id);
        
        if($res != 0)
        {            
            echo " В таблице уже есть данная запись, id: " . $res . "<br>";
        }
        
        else
        {
            $isCreated = $this->create_main($price, $owner_id, $realtor_id);
            
            if($isCreated)                
            {
                echo "Запись успешно добалена. Ее id = " . $this->find_main($price,         $owner_id, $realtor_id) . "<br>";
            }
            else
            {
                echo "Ошибка при добавлении записи.";
            }
           
        }
    }
    
    private function edit_main($id, $price, $owner_id, $realtor_id)
    {
        $sql = "UPDATE main SET price = '%d', owner_id = '%d', realtor_id = '%d'             WHERE id = '%d'";
        
        $query = sprintf($sql, mysqli_real_escape_string($this->link, $price),
                               mysqli_real_escape_string($this->link, $owner_id),
                               mysqli_real_escape_string($this->link, $realtor_id),
                               mysqli_real_escape_string($this->link, $id));
        $temp = mysqli_query($this->link, $query);
        
        return $temp;
    }
    
    public function edit($id, $price, $owner_id, $realtor_id)
    {
        $res = $this->edit_main($id, $price, $owner_id, $realtor_id);
        
        if($res)
        {
            echo "Строка № " . $id . "успешно отредактирована <br>";
        }
        else
        {
            echo "Ошибка при редактровании строки.";
        }
        
    }
    
    public function show()
    {
        if($this->link)
        {
            $query = "SELECT * FROM main ORDER BY id DESC";
            
            $result = mysqli_query($this->link, $query);
            
            if(!$result)
                {
                    die("Error: ".mysqli_error($this->link));
                }
            
            $n = mysqli_num_rows($result);
            
            $test = array();
            
            for($i=0; $i < $n; $i++)
            {
                $temp = mysqli_fetch_assoc($result);
                
                $test[] = $temp;
            }
            
            return $test;
            
        }
    }
    
    function __destruct()
    {
        $isClose = mysqli_close($this->link);
        
            echo "<br> link уничтожен:" . $isClose;
       
    }
}