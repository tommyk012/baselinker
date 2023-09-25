<?php
require_once (__DIR__ . "/../database.php");
require_once (__DIR__ . "/../baselinker.php");
require_once (__DIR__ . "/../file.php");
require_once (__DIR__ . "/../slack.php");

$fileInput = "anulowane_input.in";  //plik z zamówieniami anulowanymi
$fileLog = "log_anulowane.out";     //plik z logami

$inputTable = getCSV($fileInput);

//wyszukanie zamówień anulowanych (status 6 lub 233)
$sql = "SELECT a.id_order, a.total_paid, c.iso_code, b.email FROM ps_orders a
        LEFT JOIN ps_customer b ON a.id_customer=b.id_customer 
        LEFT JOIN ps_currency c ON a.id_currency=c.id_currency
        WHERE a.current_state=6 OR a.current_state=233";

$resultTable = getDatabaseData($sql, $dbReadOnly);
	
echo count($resultTable) . "<br><br>";

$idOrderAnulowanoBL = 343439; //id statusu anulowano w Baselinkerze

foreach($resultTable as $order) 
{
    $index = '';
    $index = searchForId($order['id_order'], $inputTable);
    if(!is_numeric($index))
    {
        $order['total_paid'] = number_format($order['total_paid'], 2, ',', ' ');

        $orders = getOrdersForEmail($order['email']);
        
        foreach($orders['orders'] as $orderBL)
        {
            if(isset($orderBL['shop_order_id']) and $orderBL['shop_order_id'] == $order['id_order'])
            {
                $searchedOrder = $orderBL;
                break;
            }
        }

        if($searchedOrder['order_status_id'] != $idOrderAnulowanoBL){
            setOrderStatus($searchedOrder['order_id'], $idOrderAnulowanoBL);
            echo "Zmieniono status zamówienia " . $order['id_order'] . " na Anulowano<br>";
        }

        $channel = "DES89QWMC";
        $user = "Anulowane zamówienia";
        $icon = ":x:";
        $msg = "Zamówienie anulowane: *" . $order['id_order'] . "* - Kwota: " . $order['total_paid'] . " " . $order['iso_code'];
        
        sendToSlack($channel, $user, $msg, $icon);

        echo $msg . "<br/>";

        saveLogDate($fileLog, $order['id_order'], $order['total_paid'], $order['iso_code']);

        saveArrayToCSV(
            array(
                array(
                    $order['id_order'],
                    $order['total_paid'],
                    $order['iso_code']
                )   
            ), 
            $fileInput
        );
    }
}
?>