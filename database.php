<?php
require_once (__DIR__ . "/.env.php");

/**
 * Pobranie danych z PrestaShop do tablicy dwuwymiarowej
 */
function getDatabaseData($sql, $db)
{
	$resultTable = [];
	$result = $db->query($sql);
	
	if($result->num_rows != 0)
	{
		while ($tab = mysqli_fetch_assoc($result)){
			array_push($resultTable, $tab);
	}}

	return $resultTable;
}


//połączenie z bazą danych
$dbReadOnly = new mysqli(
                    DB_HOST_READ_ONLY,
                    DB_USER_READ_ONLY,
                    DB_PASS_READ_ONLY,
                    DB_NAME_READ_ONLY
                );
if ($dbReadOnly->connect_error) 
{
    die("Connection failed: " . $dbReadOnly->connect_error);
}

$dbReadOnly -> set_charset("utf8");
    
?>