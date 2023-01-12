<html>
	<head>
		<meta charset="utf-8">
		<title>kavarna</title>
		<link rel="stylesheet" href="style1.css">
	</head>
	<body>
<nav>
<h1>kavarna</h1>

</nav>

<div id="table">
<fieldset><legend>Pracovníci</legend>
	<?php
	include("connection.php");	
	$sql="select people.name, drinks.date, count(types.typ),types.typ from drinks  INNER JOIN people ON people.ID = drinks.id_people INNER JOIN types ON types.ID = drinks.id_types group by types.typ;";	
		$result=$conn->query($sql);	
	?>
	<table>
	<tr><th>Jméno</th><th>Pití</th><th>Počet</th><th>Datum</th>
	
	</tr>
	
	<?php
	if($result->num_rows>0){	
	while($row=$result->fetch_assoc()){
	?>
	<tr>
	
	<td><?php echo $row["name"];?></td>
	
	<td><?php echo $row["typ"];?></td>
	
	<td><?php echo $row["count(types.typ)"];?></td>
	
	<td><?php echo $row["date"];?></td>
	<!--<td><button><a href='inc/update.php?id=<?php echo $row["id"];?>'>edit</a></button></td>
	<td><a href='inc/delete_ctenar.php?id=<?php echo $row["id"];?>'
	onclick="return confirm('opravdu chcete tuto knihu vymazat?')"
	>Delete</a></td>
	</tr>-->
	<?php
		}	//konec while
	}else{					//konec podmínky if
		echo "0 results";
	}
	?>
	</table>
	
</fieldset>

  <table>
    <tr><th>Typ</th><th>Počet</th><th>Datum</th><th>Cena</th>
    <?php
        $sql = "select * from people;";
        $result=$conn->query($sql);
        $people="<select name = 'people'>";
        while($row=$result->fetch_assoc()){
            $people .= "<option value='".$row["name"]."'>".$row["name"]."</option>"; 
        }
		
        $people.="</select>";?>
        <form method = "POST">  
            <?php echo $people;?><br>
      <input type="month" name="month" id="month">
      <input type="submit" name="submit" id="submit">
        </form>
      <?php
         $mesic = explode("-", $_POST['month']);
         $sql = "select people.name, count(types.typ), drinks.date, types.typ from drinks
         inner join people on people.id = drinks.id_people
         inner join types on types.id = drinks.id_types
         where ".$mesic[1]." = (SELECT EXTRACT(MONTH FROM drinks.date)) and people.name = '".$_POST['people']."'
         group by types.typ
         order by typ;";
		 
        
     $result=$conn->query($sql);
   
    ?>
     <?php
     $drinks = "select types.typ from types group by types.typ;";
     $d=$conn->query($drinks);   
     while($row=$result->fetch_assoc()){
         $rowd=$d->fetch_assoc();
		 
      if($row["typ"]=='Coffe'){
        $coffe = $row["count(types.typ)"] * 50/1000*300;
        } 
         if($row["typ"]=='Doppio+'){
            $Doppio = $row["count(types.typ)"] * 50/1000*400;
            } 
            if($row["typ"]=='Espresso'){
                $Espresso = $row["count(types.typ)"] * 50/1000*250;
                } 
                if($row["typ"]=='Long'){
                    $Long = $row["count(types.typ)"] * 50/1000*3000;
                    } 
                    if($row["typ"]=='Mléko'){
                        $Mléko = $row["count(types.typ)"] * 50/1000*30;
                        } 
     ?>
    <tr>
	<td><?php echo $row["typ"];?></td>
	
	<td><?php echo $row["count(types.typ)"];?></td>
	
	<td><?php echo $row["date"];?></td>

 <td>
   <?php
       if($row["typ"]=='Mléko'){
        echo $Mléko."Kč";
		 }  
	   if($row["typ"]=='Long'){
        echo $Long."Kč ";
		 }  
		if($row["typ"]=='Espresso'){
        echo $Espresso."Kč ";
		 }  
		if($row["typ"]=='Doppio+'){
        echo $Doppio."Kč ";
		 }  
		if($row["typ"]=='Coffe'){
        echo $coffe."Kč ";
		 }  		
   } 
    ?>
</td>
    </tr>   
</table>
<style>
/* Vycentrování celé stránky */
body {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Styly pro navigační lištu */
nav {
    background-color: #333;
    color: #fff;
    padding: 1rem;
}

nav h1 {
    margin: 0;
}

/* Styly pro tabulku */
table {
    border-collapse: collapse;
    width: 80%;
    margin: 2rem 0;
}

th, td {
    border: 1px solid #ccc;
    padding: 0.5rem;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

/* Styly pro fieldset */
fieldset {
    width: 50%;
    margin: 2rem 0;
    padding: 1rem;
    border: 1px solid #ccc;
}

legend {
    font-weight: bold;
    margin-bottom: 1rem;
}
</style>
</body>
</html>