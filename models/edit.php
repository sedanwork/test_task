<?php require_once("header.php");?>
 
  <div class = "container">
  
<?php
      if(isset($_GET['class']))
          $id = $_GET['class'];
      elseif(isset($_POST['s']))
        $id = $_POST['s'];
      else
          $id = 11;
      if(isset($_GET['id']))
            $temp = $db->showClass($connect->link, [$id, (int)$_GET['id']]);
      else
            $temp = $db->showClass($connect->link, [$id, 0]);
      
      $temp = $temp[0];
      if($_GET['action'] != "add")
            $t = "&id=" . $temp['id'] . "&o_id=" . $temp['owner_id'] . "&r_id=" . $temp['realtor_id'] . "&a_id=" . $temp['adress_id'] . "&obj_id=" . $temp['obj_id'];
?>
      <form method="post" action="edit.php?action=add">
        <select name="s">
            <option disabled>Квартиры:</option>
              <option <?php if($id == 11) echo "selected";?>  value="11">Квартира</option>
              <option <?php if($id == 12) echo "selected";?>  value="12">Пансионат</option>
              <option <?php if($id == 13) echo "selected";?>  value="13">Комната</option>
              <option <?php if($id == 14) echo "selected";?> value="14">Общежитие</option>
            <option disabled>Загородная недвижимость:</option>
              <option <?php if($id == 21) echo "selected";?> value="21">Земельный участок</option>
              <option <?php if($id == 22) echo "selected";?> value="22">Дача</option>
              <option <?php if($id == 23) echo "selected";?> value="23">Дом</option>
              <option <?php if($id == 24) echo "selected";?> value="24">Коттедж</option>
              <option <?php if($id == 25) echo "selected";?> value="25">Таунхаус</option>
            <option disabled>Коммерческая недвижимость:</option>
              <option <?php if($id == 31) echo "selected";?> value="31">Офисное помещение</option>
              <option <?php if($id == 32) echo "selected";?> value="32">Торговое помещение</option>
              <option <?php if($id == 33) echo "selected";?> value="33">Складское помещение</option>
        </select>
        <input id="sel_sbmt" id="sel_sbmt" type="submit" value="Показать">
      </form>
     
    
    <form method="post" action="index.php?action=<?php echo $_GET['action'];if($_GET['action'] == "edit") echo $t;?>&class=<?php echo $id?>">
        <div class = "e_main">
           <label>
            <p>Price: </p>            
            <div class = "temp">Цена:
            <input type="text" name = "price" value = "<?php echo $temp['price']?>"></div>
            
            </label>
        </div>
        <div class = "e_main">
            <label>
                <p>Owner: </p>
                
                <div class = "temp">Имя:
                <input type="text" name = "o_name" value = "<?php echo $temp['o_name']?>"></div>
                
                <div class = "temp">Фамилия:
                <input type="text" name = "o_surname" value = "<?php echo $temp['o_surname']?>"></div>
            </label>
        </div>
        <div class = "e_main">
            <label>
                <p>Realtor: </p>
                
                <div class = "temp">Имя:
                <input type="text" name = "r_name" value = "<?php echo $temp['r_name']?>"></div>
                
                <div class = "temp">Фамилия:
                <input type="text" name = "r_surname" value = "<?php echo $temp['r_surname']?>"></div>
            </label>
        </div>
        <div class = "e_main">
            <label>
                <p>Adress: </p>
                
                <div class = "temp">Город: 
                <input type="text" name = "town" value = "<?php echo $temp['town']?>"></div>
                
                <div class = "temp">Район: 
                <input type="text" name = "district" value = "<?php echo $temp['district']?>"></div>
                
                <div class = "temp">Улица: 
                <input type="text" name = "street" value = "<?php echo $temp['street']?>"></div>
                
                <div class = "temp">Номер: 
                <input type="text" name = "number" value = "<?php echo $temp['number']?>"></div>
                 
            </label>
        </div> 
        <div class="e_chars">            
             <label>
     <p>Charakteristics</p>
    
           
    <?php foreach($connect->ttype[$id] as $temp1 => $value):
        {
           echo "<div class = \"temp\">";
            if($temp1 == 'ttype')
            {
                echo "Тип" . "<input type=\"text\" name = \"$temp1\" value = \"" . $connect->ttype[$id]['ttype'] . "\" disabled></div>";
            }
            else
                echo $connect->ttype[$id][$temp1] . "<input type=\"text\" name = $temp1 value = $temp[$temp1]></div>";
        }
          endforeach;
                 
    ?>
           
            <a href="index.php?action="><div class="back">BACK</div></a>
            <input id="edit_sbmt" type="submit" value = "SEND">
             </label>             
        </div>    
    </form>
</div>

<?php
require_once("footer.php");
?>