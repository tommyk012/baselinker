<?php
require_once (__DIR__ . "/../database.php");
require_once (__DIR__ . "/../baselinker.php");
?>

<head>
<title>Wyszukiwarka zamówień</title>
</head>

<?php
$name="";
if (isset($_POST['name'])) 
{
    $name = $_POST['name'];
}
?>

<form method="POST">
Szukaj zamówienia:    <input type="text" name="name" value="<?php echo $name;?>">
<br/><br/>
<input type="submit" name="odczyt" value="Odczyt">
</form>
	
<?php

if (isset($_POST['odczyt'])) 
{
	$orderId = $_POST['name'];

    $sql = "SELECT email FROM ps_customer INNER JOIN ps_orders USING (id_customer) WHERE id_order=$orderId";

    $resultTable = getDatabaseData($sql, $dbReadOnly);
    if(isset($resultTable[0]['email']))
    {
        $email = $resultTable[0]['email'];   
        $orders = getOrdersForEmail($email);
    
        foreach($orders['orders'] as $order)
        {
            if($order['shop_order_id'] == $orderId)
            {
                $searchedOrder = $order;
                break;
            }
        }
    }

    // jeśli nie znaleziono zamówienia dla danego emaila, to szukamy po ID Baselinkera
    if(!isset($searchedOrder))
    {
        $searchedOrder = getOrderForId($orderId);
        if(isset($searchedOrder['orders'][0]))
            $searchedOrder = $searchedOrder['orders'][0];
        else
            $searchedOrder = null;
    }

    //jeśli nie znaleziono zamówienia dla danego ID, to wyświetlamy komunikat
    if(!isset($searchedOrder))
    {
        echo "Nie znaleziono zamówienia o podanym ID";
    }    
    else
    {
        arrayPrettyPrint($searchedOrder);
    
        $package = getPackage($searchedOrder['order_id']);

        if(isset($package['packages'][0])){
            $package = $package['packages'][0];

            echo '<br/><br/>------------------ PACZKA ------------------------------------------------------------------------------------------------<br/><br/>';
            arrayPrettyPrint($package);
            echo '<br/><br/>------------------ HISTORIA PACZKI ---------------------------------------------------------------------------------------<br/><br/>';
            
            $packageHistory = getPackageHistory($package['package_id']);

            // dodanie opisów do statusów kurierskich
            $packageHistory = $packageHistory['packages_history'];
            foreach($packageHistory as &$packageId){
                foreach($packageId as &$status){
                    $status['tracking_status'] = $status['tracking_status'] . " - " . trackingCode($status['tracking_status']);
                }
            }
        
            arrayPrettyPrint($packageHistory);
            echo '<br/><br/>------------------------------------------------------------------------------------------------------------------------<br/><br/>';
        
        }
        else{
            echo "<br/><br/>----------------- PACZKA -------------------------------------------------------------------------------------------------<br/><br/>";
            echo 'brak danych o paczce';
        }
    }
}
?>