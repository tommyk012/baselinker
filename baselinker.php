<?php
require_once (__DIR__ . "/.env.php");

/**
 * Pobranie zamówień z Baselinkera dla danego emaila
 */
function getOrdersForEmail($email){
    
    $methodParams = '{
        "get_unconfirmed_orders": true,
        "filter_email": "' . $email . '"
        
    }';
    
    $apiParams = [
        "token" => BASELINKER_TOKEN, 
        "method" => "getOrders", 
        "parameters" => $methodParams
    ];
    
    $curl = curl_init("https://api.baselinker.com/connector.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));	
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    $response = json_decode($response, true);
    return $response;
}

/**
 * Pobranie zamówień z Baselinkera dla zamówienia o danym ID
 */
function getOrderForId($orderId){
    $methodParams = '{
        "get_unconfirmed_orders": true,
        "order_id": "' . $orderId . '"
        
    }';
    
    $apiParams = [
        "token" => BASELINKER_TOKEN, 
        "method" => "getOrders", 
        "parameters" => $methodParams
    ];
    
    $curl = curl_init("https://api.baselinker.com/connector.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));	
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    $response = json_decode($response, true);
    return $response;
    }

/**
 * Pobranie danych o paczce dla danego ID paczki
 */
function getPackage($packageId){
    $methodParams = '{
        "order_id": "' . $packageId . '"       
    }';

    $apiParams = [
        "token" => BASELINKER_TOKEN, 
        "method" => "getOrderPackages", 
        "parameters" => $methodParams
    ];

    $curl = curl_init("https://api.baselinker.com/connector.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));	

    $response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($response, true);
    return $response;
}

/**
 * Tłumacz kodu kuriera na tekst
 */
function trackingCode($courierCode){
    if($courierCode == 1)
        return "Przygotowana przez Nadawcę";
    elseif($courierCode == 6)
        return "Zwrot do nadawcy";
    else if ($courierCode == 11)
        return "W trasie / Wysłanie przesyłki";
    else if ($courierCode == 4)
        return "Przekazano do doręczenia";
    else if ($courierCode == 5)
        return "Doręczono";
    else if ($courierCode == 8)
        return "Umieszczona w automacie Paczkomat (odbiorczym)";
    else if ($courierCode == 2)
        return "Odebrana od klienta"; 
    else 
        return 'Brak danych';
}

/**
 * Pobranie danych o historii paczki dla danego ID paczki
 */
function getPackageHistory($packageId){
    $methodParams = '{
        "package_ids": [
            '. $packageId .'
        ]       
    }';

    $apiParams = [
        "token" => BASELINKER_TOKEN,
        "method" => "getCourierPackagesStatusHistory", 
        "parameters" => $methodParams
    ];

    $curl = curl_init("https://api.baselinker.com/connector.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));	

    $response = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($response, true);
    return $response;
}

/**
 * Ustawienie statusu zamówienia na Baselinkerze dla danego ID zamówienia
 */
function setOrderStatus($idOrder, $idStatus){
    // pobranie zamówień z Baselinkera od daty
    $methodParams = '{
            "order_id": ' . $idOrder . ',
            "status_id": ' . $idStatus . '        
    }';
    
    $apiParams = [
        "token" => BASELINKER_TOKEN, 
        "method" => "setOrderStatus", 
        "parameters" => $methodParams
    ];
    
    $curl = curl_init("https://api.baselinker.com/connector.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($apiParams));	
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    $response = json_decode($response, true);
    return $response;
}

/**
 * Formatowanie wyświetlania tablicy
 */
function arrayPrettyPrint($arr, $level = 0) {
    foreach($arr as $k => $v) {
        for($i = 0; $i < $level; $i++)
            echo "&nbsp;&nbsp;&nbsp;&nbsp;";   // możliwość zmiany wcięcia
        if(!is_array($v))
            echo($k . " => " . $v . "<br/>");
        else {
            echo($k . " => <br/>");
            arrayPrettyPrint($v, $level+1);
        }
    }
}

?>