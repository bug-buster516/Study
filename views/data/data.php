<table class="contain">
<tr>
<td> 
<table>
  <tr>
    <td>
       <table class="table_head"  >
         <tr>
            <th style=" width: 20%">DATE</th>
            <th style=" width: 20%">TIME</th>
			<th style=" width: 20%">PHONE</th>
			<th style=" width: 20%">USER</th>
			<th style=" width: 20%">EVENTS</th>
         </tr>
       </table>
    </td>
  </tr>
  <tr>
    <td>
       <div style="  width:700px; height:570px; overflow:auto;">
         <table class="data" >
		 
			<?php 
			
			while($result=$this->content->fetch())
			{	
			echo '<tr>
			<td style=" width: 20%">'.$result["Date"].'</td>
			<td style=" width: 20%">'.$result["Time"].'</td>
			<td style=" width: 20%">'.$result["Phone"].'</td>
			<td style=" width: 20%" >'.$result["Name"].'</td>
			<td style=" width: 20%">'.$result["Event"].'</td>
			</tr>';
			}
			?>
           
         </table>  
       </div>
    </td>
  </tr>
</table>
</td>
<td class="sort" >
<form action="http://bmhmh.ho.ua/index.php/data/filter" method="POST">
  DATE
  <br>
  <br>
   <label>From:</label><br>
  <input type="date"  name="fdate"><br>
  <label>To:</label><br>
  <input type="date"  name="tdate">
  <br>

  <hr>
   TIME
   <br>
  <br>
   <label>From:</label><br>
  <input type="time"  name="ftime"><br>
  <label>To:</label><br>
  <input type="time"  name="ttime">
  <br>

  <hr>
   PHONE
  <br>
  <br>
  <input type="text"  name="phone"><br>
  <br>
 <hr>
	
  <label for="scales">USER</label><br>
 
  <br>
 <select  name="user" size="1">
  <option value="0">-</option>
  <option value="1">Roman</option>
  <option value="2">Ivan</option>
  <option value="3">Employee1</option>
  <option value="4">Employee2</option>
  <option value="5">Employee3</option>
  <option value="6">Employee4</option>
  <option value="7">Employee5</option>
  <option value="8">Employee6</option>
  <option value="9">Employee7</option>
  <option value="10">Employee8</option>
</select>   <br>
  <br>
  <hr>
  
  <label for="scales">EVENT</label>
  <br>
  <br>
  <select  name="event" size="1">
  <option value="0">-</option>
  <option value="1">Open door</option>
  <option value="2">Start sequrity</option>
  <option value="3">Stop sequrity</option>
  <option value="4">Alarm</option>
   <option value="5">Stop alarm</option>
</select> <br>
   <br>
    <br>
   <input type="submit" value="Submit">
  
 </form>
</td>
</tr>
</table>
