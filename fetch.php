<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include "model/connectdb.php";
$conn=connectdb();

$output = '';
//prepare sql query
if(isset($_POST["query"]))
{
	$search = $_POST["query"];
	$sql = "SELECT * FROM tbl_customer 
			WHERE CustomerName LIKE '%".$search."%'
			OR Address LIKE '%".$search."%' 
			OR City LIKE '%".$search."%' 
			OR PostalCode LIKE '%".$search."%' 
			OR Country LIKE '%".$search."%'
			";
} else {
	$sql = "SELECT * FROM tbl_customer ORDER BY CustomerID";
}

$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$result = $stmt->fetchAll(); // lấy nhiều dòng

if(count($result) > 0)
{
	$output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th>Customer Name</th>
							<th>Address</th>
							<th>City</th>
							<th>Postal Code</th>
							<th>Country</th>
						</tr>';
    foreach ($result as $row) {
		$output .= '
			<tr>
				<td>'.$row["CustomerName"].'</td>
				<td>'.$row["Address"].'</td>
				<td>'.$row["City"].'</td>
				<td>'.$row["PostalCode"].'</td>
				<td>'.$row["Country"].'</td>
			</tr>
		';
	}
	echo $output;
} else {
	echo 'Data Not Found';
}
?>