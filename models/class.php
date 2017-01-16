<?php

define('MYSQL_SERVER', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', '');
define('MYSQL_DB', 'the_prorerty');



class DB_connect
{
    public $link;
    public $ttype;
        
    function __construct()
    {
        $this->link = mysqli_connect(MYSQL_SERVER, MYSQL_USER,                                    MYSQL_PASSWORD, MYSQL_DB);
        
        if(mysqli_connect_errno())
        {
            printf("Не удалось подключиться: %s\n",                           mysqli_connect_error());
            exit();
        }
        
        if(!mysqli_set_charset($this->link, "utf8"))
            
            {
                printf("Ошибка при загрузке набора символов utf8: %s\n",                    mysqli_error($this->link));             
                exit();
            }
        $this->ttype = ['11' => ['ttype' => "Квартира",
                            'num_kvart' => "№ квартиры:",
                            'squere' => "Общая площадь:",
                            'jil_plosh' => "Жилая площадь:",
                            'kuh_plosh' => "Площадь кухни:",
                            'etaj' => "Этаж:",
                            'etajnost' => "Этажность:"],
                        
                        '12' => ['ttype' => "Пансионат",
                            'num_kvart' => "№ квартиры:",
                            'squere' => "Общая площадь:",
                            'etaj' => "Этаж:",
                            'etajnost' => "Этажность:"],
                        
                        '13' => ['ttype' => "Комната",
                            'num_kvart' => "№ квартиры:",
                            'squere' => "Площадь комнаты:",
                            'etaj' => "Этаж:",
                            'etajnost' => "Этажность:"],
                        
                        '14' => ['ttype' => "Общежитие",
                            'num_kvart' => "№ квартиры:",
                            'squere' => "Общая площадь:",
                            'etaj' => "Этаж:",
                            'etajnost' => "Этажность:"],
                        
                        '21' => ['ttype' => "Дача",
                            'num_kvart' => "№ участка:",
                            'squere' => "Площадь участка:",
                            'jil_plosh' => "Площадь дома:",
                            'etajnost' => "Этажность:"],
                        
                        '22' => ['ttype' => "Дача",
                            'num_kvart' => "№ участка:",
                            'squere' => "Площадь участка:",
                            'jil_plosh' => "Площадь дома:",
                            'etajnost' => "Этажность:"],
                        
                        '23' => ['ttype' => "Дом",
                            'num_kvart' => "№ дома:",
                            'squere' => "Площадь участка:",
                            'jil_plosh' => "Площадь дома:",
                            'etajnost' => "Этажность:"],
                        
                        '24' => ['ttype' => "Коттедж",
                            'num_kvart' => "№ дома:",
                            'squere' => "Площадь участка:",
                            'jil_plosh' => "Площадь дома:",
                            'etajnost' => "Этажность:"],
                        
                        '25' => ['ttype' => "Таунхаус",
                            'num_kvart' => "№ дома:",
                            'squere' => "Общая площадь:",
                            'jil_plosh' => "Жилая площадь:",
                            'etaj' => "Этаж:",
                            'etajnost' => "Этажность:"],
                        
                        '31' => ['ttype' => "Офисное помещение",
                            'num_kvart' => "№ дома:",
                            'squere' => "Площадь:",
                            'etaj' => "Этаж:",
                            'etajnost' => "Этажность:"],
                        
                        '32' => ['ttype' => "Торговое помещение",
                            'num_kvart' => "№ дома:",
                            'squere' => "Площадь:",
                            'etaj' => "Этаж:",
                            'etajnost' => "Этажность:"],
                        
                        '33' => ['ttype' => "Складское помещение",
                            'num_kvart' => "№ дома:",
                            'squere' => "Площадь:",
                            'etaj' => "Этаж:",
                            'etajnost' => "Этажность:"]];
    }
    
    function __destruct()
    {
        $isClose = mysqli_close($this->link);       
    }
}