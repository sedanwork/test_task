<?php

interface iFunc
{
    public function findId($link, $args);
    public function findByid($link, $args);
    public function createRow($link, $args);
    public function updateRow($link, $args);
    public function deleteRow($link, $args);
    public function showClass($link, $args);
    public function prepare_obj(&$args);
    public function writeToXml($link, $pathToFile, $arr);
}

class Man implements iFunc
{
    private $id;
    private $name;
    private $surname;
    
    function __construct()
    {
        $this->id = -1;
        $this->name = "";
        $this->surname = "";
    }
    
    private function prepareArgs($link, $args)
    {
        if(is_array($args))
        {
            foreach($args as &$temp)
            {
                if(gettype($temp) == 'string')
                    $temp = mysqli_real_escape_string($link, trim($temp));
                else
                    $temp = mysqli_real_escape_string($link, (int)($temp));
            }
            unset($temp);
        }
        
        else
        {
            if(gettype($args) == 'string')
                    $args = mysqli_real_escape_string($link, trim($temp));
                else
                    $args = (int)mysqli_real_escape_string($link, (int)($temp));
        }
    }
    
    private function free($result)
    {
        mysqli_free_result($result);
    }
    
    public function findId($link, $args)
    {
        $this->prepareArgs($link, $args);
        
        $table = array_shift($args);

        $n = count($args);

        $sql = "SELECT id FROM " . $table;
        
        for($i=0; $i<($n/2); $i++)
        {
            if($i == 0)
            {
                
                $sql = $sql . " WHERE " . $args[$i] . " = '" . $args[$i+$n/2] . "'";
            }
            
            else
            {
                $sql = $sql . " AND " . $args[$i] . " = '" . $args[$i+$n/2] . "'";
            }
        }
        
        $sql = $sql . ";";

        $result = mysqli_query($link, $sql);
        
        if(mysqli_num_rows($result) == 0)
            {
                $this->free($result);
                
                return 0;
            }
        
        else
        {
            $temp = mysqli_fetch_assoc($result);
            
            $this->free($result);
            
            return (int)reset($temp);
        }
        
    }
    
    public function findById($link, $args)
    {
        $this->prepareArgs($link, $args);
        
        $table = array_shift($args);
        
        $id = array_shift($args);
        
        $n = count($args);

        $sql = "SELECT ";
        
        for($i=0; $i<$n; $i++)
        {
            if($i == 0)
            {
                $sql = $sql . $args[$i];
            }
            else
            {
                $sql = $sql . ", " . $args[$i];
            }
        }
        
        $sql = $sql . " FROM " . $table . " WHERE id = " . $id . ";";

        $result = mysqli_query($link, $sql);
        
        $temp = mysqli_fetch_assoc($result);
        
        $this->free($result);
        
        return $temp;
    }
    
    public function createRow($link, $args)
    {
        $this->prepareArgs($link, $args);
        
        $table = array_shift($args);

        $n = count($args);
        
        $sql = "INSERT INTO " . $table;
        
        for($i=0; $i<$n/2; $i++)
        {
            if($i == 0)
            {
                $sql = $sql . " (`" . $args[$i] . "`";
            }
            else
            {
                $sql = $sql . ", `" . $args[$i] . "`";
            }
        }
        
        $sql = $sql . ") VALUES ";
        
        for($i=$n/2; $i<$n; $i++)
        {
            if($i == $n/2)
            {
                $sql = $sql . " ('" . $args[$i] . "'";
            }
            else
            {
                $sql = $sql . ", '" . $args[$i] . "'";
            }
        }
        
        $sql = $sql . ");";
        
        $result = mysqli_query($link, $sql);
        
        if(!$result)
            echo "Ошибка создания строки:" . mysqli_error($link);
        
    }
    
    public function updateRow($link, $args)
    {
        $this->prepareArgs($link, $args);
        
        $table = array_shift($args);
        
        $id = array_shift($args);

        $n = count($args);
        
        $sql = "UPDATE " . $table;
        
        for($i=0; $i<($n/2); $i++)
        {
            if($i == 0)
            {
                
                $sql = $sql . " SET " . $args[$i] . " = '" . $args[$i+$n/2] . "'";
            }
            
            else
            {
                $sql = $sql . ", " . $args[$i] . " = '" . $args[$i+$n/2] . "'";
            }
        }
        
        $sql = $sql . " WHERE id = '" . $id . "';";
        
        $result = mysqli_query($link, $sql);
        
        if(!$result)
            echo "Ошибка обновления строки:" . mysqli_error($link);

    }
    
    public function deleteRow($link, $args)
    {
        $this->prepareArgs($link, $args);
        
        $table = array_shift($args);
        
        $id = array_shift($args);
        
        $sql = "DELETE FROM " . $table . " WHERE id=" . $id . ";";
        
        $result = mysqli_query($link, $sql);
        
        if(!$result)
            echo "Ошибка удаления строки:" . mysqli_error($link);
        
    }
    
    public function showClass($link, $args)
    {
        $sql = "SELECT DISTINCT m.id, m.price, m.owner_id, m.realtor_id, m.adress_id, m.obj_id, o.o_name, o.o_surname, r.r_name, r.r_surname, a.town, a.district, a.street, a.number, obj.ttype, obj.num_kvart, obj.squere,  obj.jil_plosh, obj.kuh_plosh, obj.etaj, obj.etajnost
                FROM main m 
                JOIN owner o ON m.owner_id = o.id 
                JOIN realtor r ON m.realtor_id = r.id 
                JOIN object obj ON m.obj_id = obj.id 
                JOIN adress a ON m.adress_id = a.id";
        
        if(count($args) == 0)
        {
            $sql = $sql . " ORDER BY m.id";
        }
        
        elseif(count($args) == 1)
        {
            $this->prepareArgs($link, $args);
        
            $class = array_shift($args);
        
            $sql = $sql . " WHERE obj.ttype = " . $class . " ORDER BY m.id";
        }
        
        elseif(count($args) == 2)
            {
                $this->prepareArgs($link, $args);
        
                $class = array_shift($args);
                
                $id = array_shift($args);
                
                $sql = $sql . " WHERE obj.ttype = " . $class .  " AND m.id = " . $id;
            }
        
        $sql = $sql . ";";
        
        $result = mysqli_query($link, $sql);
        
        if(!$result)
            echo "Ошибка отображения таблицы:" . mysqli_error($link);
                
        $n = mysqli_num_rows($result);
            
        $temp = NULL; 
        
        if($n == 1)
        {
            $temp[0] = mysqli_fetch_assoc($result);
            
            $this->free($result);
            
            return $temp;
        }
        
        else    
        {
            
        for($i=0; $i < $n; $i++)            
                $temp[$i] = mysqli_fetch_assoc($result); 
            
        $this->free($result);
        
        return $temp;
            
        }   
    }
    
    public function writeToXml($link, $pathToFile, $arr)
    {
        if (!($f = fopen($pathToFile, "w+")))
            return;
        
        fprintf($f, "<?xml version=\"1.0\" encoding=\"utf-8\"?>");
        
        $temp = $this->showClass($link, []);
        fprintf($f, "<objects>");
        foreach($temp as $t)
        {
           
            fprintf($f, "<object>");
            
            fprintf($f, "<id>");
            fprintf($f, "%u", $t['id']);
            fprintf($f, "</id>");
            
            fprintf($f, "<price>");
            fprintf($f, "%u", $t['price']);
            fprintf($f, "</price>");
            
            fprintf($f, "<owner>");
            
                fprintf($f, "<name>");
                fprintf($f, "%s", $t['o_name']);
                fprintf($f, "</name>");

                fprintf($f, "<surname>");
                fprintf($f, "%s", $t['o_surname']);
                fprintf($f, "</surname>");
            
            fprintf($f, "</owner>");
            
            fprintf($f, "<realtor>");
            
                fprintf($f, "<name>");
                fprintf($f, "%s", $t['r_name']);
                fprintf($f, "</name>");

                fprintf($f, "<surname>");
                fprintf($f, "%s", $t['r_surname']);
                fprintf($f, "</surname>");
            
            fprintf($f, "</realtor>");
            
            fprintf($f, "<adress>");
            
                fprintf($f, "<town>");
                fprintf($f, "%s", $t['town']);
                fprintf($f, "</town>");

                fprintf($f, "<district>");
                fprintf($f, "%s", $t['district']);
                fprintf($f, "</district>");
            
                fprintf($f, "<street>");
                fprintf($f, "%s", $t['street']);
                fprintf($f, "</street>");
            
                fprintf($f, "<number>");
                fprintf($f, "%s", $t['number']);
                fprintf($f, "</number>");            
            
            fprintf($f, "</adress>");
            
            fprintf($f, "<characteristics>");
            
            foreach($arr[$t['ttype']] as $t1 => $values)
                {
                    fprintf($f, "<%s>", $t1);
                    fprintf($f, "%s", $t[$t1]);
                    fprintf($f, "</%s>", $t1);  
                }  
            
            fprintf($f, "</characteristics>");
            
            
          fprintf($f, "</object>");
        }
        fprintf($f, "</objects>");
        
        
        fclose($f);
        
    }
    
    public function prepare_obj(&$args)
    {
        foreach($args as $temp=>$value)
        {
            if($args[$temp] == -1)
                unset($args[$temp]);
        }
        unset($args);
    }
}