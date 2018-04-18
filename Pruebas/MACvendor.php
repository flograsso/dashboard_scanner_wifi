<!DOCTYPE html>
<html lang="en">

<?php

//Consulta en la API un MAC addres y me da el MAC vendor
function getMACVendor($MACnumber) {
    if ($MACnumber != ""){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://macvendors.co/api/".$MACnumber."/json",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $response=json_decode($response);

        if (isset($response->result->company))
            return $response->result->company;
        else
            return "fake_MAC";
    }
    }


//Actualiza el campo MAC_vendor de la db
function updateMACvendorDB(){
        include("connection.php");

        $sql = "SELECT DISTINCT(MAC) FROM `data` WHERE mac_vendor IS NULL";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $MAC=$row["MAC"];
                $vendor=getMACVendor($MAC);
                if ($vendor != "" && $vendor !=null){
                    //echo "MAC:". $MAC . "   Vendor:" . getMACVendor($MAC) . "<br>";
                    $sql = "UPDATE `data` SET mac_vendor= '$vendor' WHERE mac_vendor IS NULL AND MAC= '$MAC'";
                if( mysqli_query($conn, $sql))
                    echo "Vendor '$vendor' actualizado";
                else 
                    echo "Error updating record: " . mysqli_error($conn) . "<br>";
                
                }
            }
            echo "Actualizacion de MAC vendor finalizada <br>";
        }
        else
            echo "No hay MAC sin vendor para actualizar <br>";
        $conn->close();
        $result->close();
        
}


//Elimina todas las filas con MAC en blanco
function cleanBlankMAC()
{
    include("connection.php");
    $sql = "DELETE FROM `data` WHERE MAC=''";
    if( mysqli_query($conn, $sql))
        echo "Delete Succesfuly <br>";
    else 
     echo "Error updating record: " . mysqli_error($conn) . "<br>";


    $conn->close();
}



//header("Content-Type: application/json; charset=UTF-8");

updateMACvendorDB();


?>