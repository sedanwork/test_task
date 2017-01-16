  <div class = "container">
  <?php 
      if(isset($_GET['class']))
          $id = $_GET['class'];
      elseif(isset($_POST['s']))
        $id = $_POST['s'];
      else
          $id = 11;
      
  ?>
   <div class = "main">
     
      <form method="post" action="index.php">
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
      <input type="submit" value="Показать">  
      </form>
      
 <?php if(isset($_POST['s']))
       $id = $_POST['s'];
       ?>
     
      <table class = "tbl">
          <tr>
              <th class = "tbl_id">id</th>
              <th class = "tbl_price">price</th>
              <th class = "tbl_owner" colspan = "2">owner</th>
              <th class = "tbl_owner" colspan = "2">realtor</th>
              <th class = "tbl_adress" colspan = "4">adress</th>
              <th class = "tbl_chars" colspan="<?php echo count($connect->ttype[$id])?>">characteristics</th>
              <th> </th>
          </tr>
          <tr id="tbl_h">
              <th class = "tbl_id"></th>
              <th class = "tbl_price"></th>
              <th class = "tbl_o_name">Имя</th>
              <th class = "tbl_o_surname">Фамилия</th>
              <th class = "tbl_o_name">Имя</th>
              <th class = "tbl_o_surname">Фамилия</th>
              <th class = "tbl_town">Город</th>
              <th class = "tbl_district">Район</th>
              <th class = "tbl_street">Улица</th>
              <th class = "tbl_id">№</th>
              <?php foreach($connect->ttype[$id] as $temp => $value):?>
              <th class = "tbl_id">
              <?php 
                  if($temp == 'ttype')
                      echo "Тип недвижимости:";
                  else
                      echo $connect->ttype[$id][$temp];?>
              </th>
              <?php endforeach;?>
              <th> </th>
              <th> </th>
          </tr>
          <?php
          $res = $db->showClass($connect->link, [$id]);
          
          if(is_array($res))
              
          foreach($res as $temp): ?>
           <tr>
              <td class = "tbl_id"><?php echo $temp['id'];?></td>
              <td class = "tbl_price"><?php echo $temp['price'];?></td>
              <td class = "tbl_o_name"><?php echo $temp['o_name'];?></td>
              <td class = "tbl_o_surname"><?php echo $temp['o_surname'];?></td>
              <td class = "tbl_o_name"><?php echo $temp['r_name'];?></td>
              <td class = "tbl_o_surname"><?php echo $temp['r_surname'];?></td>
              <td class = "tbl_town"><?php echo $temp['town'];?></td>
              <td class = "tbl_district"><?php echo $temp['district'];?></td>
              <td class = "tbl_street"><?php echo $temp['street'];?></td>
              <td class = "tbl_id"><?php echo $temp['number'];?></td>
              
            <?php
            $obj = array_slice($temp, -7, 7);
            $db->prepare_obj($obj);
            foreach($obj as $temp1 => $value):?>
            
            <td class = "tbl_id">
               <?php
                if($temp1 == 'ttype')
                    echo $connect->ttype[$obj[$temp1]]['ttype'];
                else
                    echo $obj[$temp1];
                ?>
               </td>
            <?php endforeach;?>
             
              <td>
              
              <a href="index.php?action=edit&id=<?php echo $temp['id'];?>&class=<?php echo $id;?>"><div class = "tbl_a">edit</div> </a>
                           
              </td>
              <td>
              
              <a href="index.php?action=delete&id=<?php echo $temp['id'];?>"><div class = "tbl_a">delete</div></a>
                            
              </td>
           </tr>
          <?php endforeach;?>
      </table>
   
       <a href="index.php?action=add"><div class = "btn"> add new</div></a>
       
   </div>
   
   <form method="post" action="index.php?action=upload">
       <input type="text" name="pathToFile" id="upload">
       <input type="submit" id="upload_sbmt">
   </form>
    
</div>
