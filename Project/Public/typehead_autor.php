<?php
    require("../../connect.php");
		
	$keyword = strval($_POST['query']);
	$search_param = "{$keyword}%";
                                   
	$sql = $spojeni->prepare("SELECT * FROM AUTOR WHERE Cele_jmeno LIKE ?");
	$sql->bind_param("s",$search_param);			
	$sql->execute();
	$result = $sql->get_result();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		$countryResult[] = $row["Cele_jmeno"];
		}
		echo json_encode($countryResult);
	}
	$spojeni->close();
?>