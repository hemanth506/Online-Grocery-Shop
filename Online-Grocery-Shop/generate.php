
<style>
    .body {
        padding: 20px;
        height: 210mm;
        width: 148.5mm;
        border: 2px solid dodgerblue;
        margin: 0;
    }
    table {
        height: 150mm;
        width: 100.5mm;
    }
    .center {
        margin-left: auto;
        margin-right: auto;
    }
    td {
        padding: 5px;
    }
</style>
<?php


session_start();
include "configpage.php";
global $connect;

//echo $_GET['name'];
$returnStmt = '';
if($_GET['name']){
    $customer = $_GET['customer'];
    $name = $_GET['name'];
    $price = $_GET['price'];
    $quantity = $_GET['quantity'];
    $total = $_GET['total'];

    $thArray = ['Product Name','Selling Price','Quantity'];

    $nameExplode = explode('||',$name);
    $priceExplode = explode('||',$price);
    $quantityExplode = explode('||',$quantity);
    array_pop($nameExplode);
    array_pop($priceExplode);
    array_pop($quantityExplode);

    $insertName = implode('||',$nameExplode);
    $insertprice = implode('||',$priceExplode);
    $insertQuantity = implode('||',$quantityExplode);

    $placeOrder = "Insert Into orders (customer_name,products,selling_price,quantity,total) Values ('{$customer}','{$insertName}','{$insertprice}','{$insertQuantity}','{$total}')";
//    echo $placeOrder."<br>";
    $stmt = $connect->prepare($placeOrder);
    if(!$stmt->execute()) {
        var_dump($stmt->errorInfo());
        die("Dead while fetching");
    }
        $date = date('Y/m/d');
    $returnStmt .= "
        
        <div class='center body'>
            <h3 style='padding-left: 180px'>Invoice</h3><br>
            <p style='padding-left: 290px'>Date: $date</p>
            <h4 style='padding-left: 150px'>{$customer}</h4>
        <table class='center table-bordered'>
            <thead>";
                foreach($thArray as $th) {
                    $returnStmt .= "<th>{$th}</th>";
                }
    $returnStmt .= "
            </thead>
            <tbody>";

                foreach($nameExplode as $name_id => $n){
                    $divide = $priceExplode[$name_id]/$quantityExplode[$name_id];
                    $returnStmt .="<tr>
                                    <td>{$nameExplode[$name_id]}</td>
                                    <td>Rs.{$divide}</td>
                                    <td>{$quantityExplode[$name_id]}</td>
</tr>";
                }

    $returnStmt .= "
            </tbody>
        </table>
        <h4 style='padding-left: 260px;padding-top: 15px'>Total: Rs.{$total}</h4>
</div>";
}

echo  $returnStmt;
