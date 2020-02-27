<?php 
if (isset($_POST['searchName']) && !empty($_POST['searchName'])) {		
  $string = $_POST[ 'searchName' ];
  $conn = mysqli_connect('localhost', 'root', '');
  $db = mysqli_select_db($conn, 'php_core_assig');
  
// Za pretragu tabele na osnovu unetog naziva knjige
  $sql = "SELECT * FROM books WHERE name = '$string'";
  $rs = mysqli_query($conn, $sql);

	if (mysqli_num_rows($rs) == 0){
		echo "<div class='action_performed'>";
		echo "No books found!";
		echo "</div>";
	}else{
		while($row = mysqli_fetch_array($rs)) {
			echo "<div class='action_performed'>";
			echo "<table id='result_table'>";
			echo "<tr class='result_table_class'>";
			echo "<th class='result_table_class'>Name</th>";
			echo "<th class='result_table_class'>Writer</th>";
			echo "<th class='result_table_class'>Genre</th>";
			echo "<th class='result_table_class'>Price</th>";
			echo "</tr class='result_table_class'>";
			echo "<tr class='result_table_class'>";
			echo "<td class='result_table_class'>" .$row['name'] . "</td>";
			echo "<td class='result_table_class'>" .$row['writer'] . "</td>";
			echo "<td class='result_table_class'>" .$row['genre'] . "</td>";
			echo "<td class='result_table_class'>" .$row['price'] . "</td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";
		}
	}
	mysqli_close($conn);
	
// Za ubacivanje vrednosti u bazu
}   else if(isset($_POST['inputName']) || isset($_POST['inputWriter']) || isset($_POST['inputGenre']) || isset($_POST['inputPrice'])) {
		if(!empty($_POST['inputName'])) {
			$stringName = $_POST[ 'inputName' ];
		} else
			$stringName = null;
		if(!empty($_POST['inputWriter'])) {
			$stringWriter = $_POST[ 'inputWriter' ];
		} else
			$stringWriter = null;
		if(!empty($_POST['inputGenre'])) {
			$stringGenre = $_POST[ 'inputGenre' ];
		} else
			$stringGenre = null;
		if(!empty($_POST['inputPrice'])) {
			$stringPrice = $_POST[ 'inputPrice' ];
		} else
			$stringPrice = null;
		
		$conn = mysqli_connect('localhost', 'root', '');
		$db = mysqli_select_db($conn, 'php_core_assig');
		mysqli_query($conn,"INSERT INTO books values(null,'$stringName','$stringWriter','$stringGenre','$stringPrice')");
		
		mysqli_close($conn);
		
// Za brisanje reda tabele
}	else if(isset($_POST['deleteName']) && !empty($_POST['deleteName'])) {
	$stringDelete = $_POST[ 'deleteName' ];
	$conn = mysqli_connect('localhost', 'root', '');
    $db = mysqli_select_db($conn, 'php_core_assig');
	mysqli_query($conn,"DELETE FROM books WHERE name = '$stringDelete'");
	
	mysqli_close($conn);
}

?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="mult_tab_form_css.css">
<script>

/* Funkcija koja menja tab koji se prikazuje
	Element sa indeksom page_content je ono sto vidimo (nije sakriveno)
	Kad je selektovan page1 (koji je Select), ovoj funkciji ce se proslediti id koji je page1, itd za svaki page
	Menjam HTML sadrzaj elementa sa indeksom page_content u sadrzaj koji zelim da postanje vidljiv
	id-evi skrivenih sadrzaja su page1_desc za page1, itd za svaki page
	menjam ime klase za svaki tab zbog stilizacije (nije ista za selektovane i neselektovane tabove)*/
 function change_tab(id)
 {
   document.getElementById("page_content").innerHTML=document.getElementById(id+"_desc").innerHTML;
   document.getElementById("page1").className="notselected";
   document.getElementById("page2").className="notselected";
   document.getElementById("page3").className="notselected";
   document.getElementById(id).className="selected";
 }
</script>
</head>
<body>

<!-- Nazivi tabova forme 
	Pozivanje funkcije za menjanje taba nakon klika
	Prosledje se id selektovanog taba-->
<div id="main_content">

 <li class="selected" id="page1" onclick="change_tab(this.id);">Select</li>
 <li class="notselected" id="page2" onclick="change_tab(this.id);">Insert</li>
 <li class="notselected" id="page3" onclick="change_tab(this.id);">Delete</li>
 
 <!-- Skriveni select tab -->
 <div class='hidden_desc' id="page1_desc">
  <h2>Select</h2>
	<form action = "db_assig_forms.php" method = "post">
		<p>Enter the name of the book and click the "Select" button.</p>
	<table>
		<tr>
			<td colspan = "2"> Book Directory </td>
		</tr>
			<td><input type = "text" size = "15" name = "searchName"/></td>
			<td><input type = "submit" value = "Select"/>
		</tr>
	</table>
	</form>
 </div>

<!-- Skriveni Insert tab -->
 <div class='hidden_desc' id="page2_desc">
  <h2>Insert</h2>
	<form action = "db_assig_tabs.php" method = "post">
		<p>Enter the data and click the "Insert" button.</p>
	<table>
		<tr>
			<td><label for="inputName">Name</label>
			<td><input type = "text" size = "30" name = "inputName"/></td>
		</tr>
		<tr>
			<td><label for="inputWriter">Writer</label>
			<td><input type = "text" size = "30" name = "inputWriter"/></td>
		</tr>
		<tr>
			<td><label for="inputGenre">Genre</label>
			<td><input type = "text" size = "30" name = "inputGenre"/></td>
		</tr>
		<tr>
			<td><label for="inputPrice">Price</label>
			<td><input type = "text" size = "15" name = "inputPrice"/></td>
		</tr>
		<tr>
			<td colspan="2"><input id="input_button" type = "submit" value = "Input"/>
		</tr>
		
	</table>
	</form>
 </div>
 
 <!-- Skriveni Delete tab -->
 <div class='hidden_desc' id="page3_desc">
  <h2>Delete</h2>
	<form action = "db_assig_tabs.php" method = "post">
		<p>Enter the name of the book and click the "Delete" button.</p>
	<table>
		<tr>
			<td><input type = "text" size = "15" name = "deleteName"/></td>
			<td><input type = "submit" value = "Delete"/>
		</tr>
	</table>
	</form>
 </div>
 
 <div id="wrapper">
 <!-- Tab koji ce se prikazati prvi po ucitavanju stranice je Select-->
 <div id="page_content">
  <h2>Select</h2>
	<form action = "db_assig_tabs.php" method = "post">
		<p>Enter the name of the book and click the "Select" button.</p>
	<table>
		<tr>
			<td colspan = "2"> Book Directory </td>
		</tr>
			<td><input type = "text" size = "15" name = "searchName"/></td>
			<td><input type = "submit" value = "Select"/>
		</tr>
	</table>
	</form>
 </div>
 
 </div> <!-- kraj wrapper-a -->
 
</div>
 
</body>
</html>