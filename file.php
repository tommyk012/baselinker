<?php

/**
 * Funkcja wczytująca plik csv do tablicy dwuwymiarowej
 */
function getCSV($file)
{
	$fp = fopen($file, "r");
	$resultTable =[];

	while (($line = fgetcsv($fp,1000,";")) !== FALSE) 
	{
        //pominięcie pustych linii
		if($line[count($line)-1]=="")
			unset($line[count($line)-1]);

        //usunięcie znaków nowej linii
		foreach ($line as $id)
		{
			$id = str_replace("\n", "", $id);
			$id = str_replace("\r", "", $id);
		}
		array_push($resultTable, $line);
	}
	fclose($fp);
	return $resultTable;
}

/**
 * Funkcja wyszukująca daną wartość w tablicy dwuwymiarowej i zwracająca indeks tablicy
 */
function searchForId($id, $array) {
    foreach ($array as $key => $val) {
        if ($val[0] === trim($id)) {
            return $key;
        }
    }
    return null;
}

/**
 * Funkcja zapisująca określone wartości do pliku z datą. Wykorzystywana do logowania.
 */
function saveLogDate($file, $value1, $value2, $value3){
    $fp = fopen($file, "a");
    fputs($fp, date("Y-m-d"));
    fputs($fp, ";");
    fputs($fp, date("H:i"));
    fputs($fp, ";");
    fputs($fp, $value1);
    fputs($fp, ";");
    fputs($fp, $value2);
    fputs($fp, ";");
    fputs($fp, $value3);
    fputs($fp, ";");
    fputs($fp, "\r\n");
}

/**
 * Funkcja dopisująca tablicę dwuwymiarową do pliku csv
 */
function saveArrayToCSV($array, $file)
{
	$fp = fopen($file, "a");
	
	$i=0;
	foreach ($array as $row){
		foreach ($row as $cell)
		{	
			$length = count($row);	
			fputs($fp, $cell);
			if ($i != ($length-1))
				fputs($fp, ";");
			$i++;
		}
		$i=0;
		fputs($fp, "\r\n");
	}
	fclose($fp);
}
?>