<?php
    require("../../connect.php");
		
	$keyword = strval($_POST['query']);
	$search_param = "{$keyword}%";
                                   
	$sql = $spojeni->prepare("SELECT * FROM KNIHA WHERE Nazev LIKE ?");
	$sql->bind_param("s",$search_param);			
	$sql->execute();
	$result = $sql->get_result();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		$countryResult[] = $row["Nazev"];
		}
		echo json_encode($countryResult);
	}
	$spojeni->close();
?>