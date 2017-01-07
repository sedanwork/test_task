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
                printf("Ошибка при загрузке набора символов utf8:            %s\n", mysqli_error($this->link));             
                exit();
            }
    }
    
    public function findId($table, $name, $surname, $dateOfBirth)
    {
        $query = "SELECT `id` FROM `$table` WHERE name = '$name' AND           surname = '$surname'";
        
        return mysqli_query($this->link, $query);
    }
    
    public function createId($table, $name, $surname, $dateOfBirth)
    {
        $query = "INSERT INTO `$table` (`name`, `surname`,                     `date_of_birth`) VALUES ('$name', '$surname',                 '2017-01-04')";
        
        return mysqli_query($this->link, $query);    
    }
    
    public function getId($table, $name, $surname, $dateOfBirth)
    {
        $res = $this->findId($table, $name, $surname, $dateOfBirth);
        
        if(mysqli_num_rows($res) != 0)
        {
            $temp = mysqli_fetch_assoc($res);
            
            return reset($temp);
        }
        
        else
        {
            if($this->createId($table, $name, $surname,                                  $dateOfBirth))
            {
                $res = $this->findId($table, $name, $surname,                              $dateOfBirth);
                
                $temp = mysqli_fetch_assoc($res);
                
                return reset($temp);
            }
            
            else
                echo "can't create row";
        }

    }
    
    public function add($price, $owner_id, $realtor_id)
    {
        $query = "SELECT `id` FROM `main` WHERE owner_id =                     '$owner_id' AND realtor_id = '$realtor_id' AND               price = '$price'";
        
        $res = mysqli_query($this->link, $query);
        
        if(mysqli_num_rows($res) != 0)
        {
            $temp = mysqli_fetch_assoc($res);
            
            echo " В таблице уже есть данная запись, id: " .                reset($temp) . "<br>";
        }
        
        else
        {
            $query = "INSERT INTO `main` (`price`, `owner_id`,                 `realtor_id`) VALUES ('$price', '$owner_id',             '$realtor_id')";
            
            echo $query;
            
            $res = mysqli_query($this->link, $query);
        }
    }
    
    public function edit($id, $price, $owner_id, $realtor_id)
    {
        $query = "UPDATE main SET price = '$price', owner_id =                 '$owner_id', realtor_id = '$realtor_id' WHERE id =           '$id'";
        
        $res = mysqli_query($this->link, $query);
        
        if($res)
        {
            echo "Строка № " . $id . "успешно отредактирована <br>";
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