<?php

session_start();

include "configpage.php";
global $connect;

if(isset($_SESSION['uname']))
{
    echo"<h3>Welcome ".$_SESSION["uname"]."</h3>";
    echo "<br><br>";
//    echo "<br><a href='logoutpage.php'>Logout</a>";
    $get_products = "SELECT * from products";
    $stmt = $connect->prepare($get_products);
    if(!$stmt->execute()) {
        var_dump($stmt->errorInfo());
        die("Dead while fetching");
    }
    while($product = $stmt->fetch())
    {
        $name[] =  $product['name'];
        $per[] =  $product['per'];
        $cost_price[] =  $product['cost_price'];
        $selling_price[] =  $product['selling_price'];
    }
//    var_dump($name);

?>

    <div class="container">
        <label><h3>Products:</h3></label>
        <table class="table text-left table-condensed" id="myTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Per</th>
                    <th>Cost Price</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($name as $id => $n){
                    echo "<tr>
                            <td>{$name[$id]}</td>
                            <td id='per_{$per[$id]}'>{$per[$id]}</td>
                            <td class='cost'>{$cost_price[$id]}</td>
                            <td class='sell'>{$selling_price[$id]}</td>
                            <td id='{$name[$id]}'>
                                <input type='number' min='0' id='{$name[$id]}' class='form-control counts' style='width:170px;'>
                            </td>
                            <td id='sub_total_{$name[$id]}' class='sub_class_total'>0</td>
                        </tr>";
                }

                echo '<tr>';
                for($i = 1;$i <= 6;$i++) {
                        if($i < 6){
                            echo "<td></td>";
                        }else{
                            echo "<td id='Total'>Total (<span id='total_span'></span>)</td>";
                        }
                    }
                echo'</tr>';

                echo '
            </tbody>
          </table>
          <button class="btn btn-info float-right"  id="review_btn">Generate Bill</button>
        </div><br><br>';

           echo "<input type='hidden' id='hidden_th' value=''>";

}
else
{
    header("location:loginpage1.php");
}

echo "<div id='finalBill'>

</div>";


echo "<br><button class='btn btn-danger' id='logmeout'>Logout</button>";




echo "<script>
    $(document).ready(function (){
        $('#logmeout').click(function(){
            window.location = 'logoutpage.php';
        })
        
        $('.counts').on('change',function() {
            
                var current_id = $(this).attr('id');
                var value = $('#'+current_id).closest('tr').children('.sell').text();
                var count = $(this).val();
                var total = value * count;
//                console.log(total);
                
                var total_val = 0;
                $('#sub_total_'+current_id).html(total);
                $('.sub_class_total').each(function(){
                    total_val += parseInt($(this).text());
                });
//                console.log(total_val);
                
                $('#total_span').text(total_val);
                
        });
        rowCount = $('#myTable tr th').length;
        $('#hidden_th').val(rowCount);
//        console.log(rowCount)


        $('#review_btn').on('click',function(){
            
            var price = '';
            var name = '';
            $('.sub_class_total').each(function(){
                if ($(this).text() != '0'){
                    price += $(this).text() + '||';
                    name += ($(this).attr('id')).split('sub_total_')[1] + '||';
                } 
            });
            
            var quantity = '';
            $('.counts').each(function() {
                if ($(this).val() != 0 && $(this).val() != null){
                    quantity += $(this).val() + '||';
                }
            });
//            alert(product);
            
            var total_amount = $('#total_span').text();
//            alert(total_amount);
            var product_price = price
            var product_name = name
            var product_quantity = quantity
            var url = 'generate.php?customer={$_SESSION["uname"]}&price='+product_price+'&name='+product_name+'&quantity='+product_quantity+'&total='+total_amount;
//            alert(url);
            var xhr = new XMLHttpRequest();
            xhr.open('GET',url,true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    $('#finalBill').html('');
                    $('#finalBill').html(xhr.responseText);
                }
            };
            xhr.send();
        });
    });
</script>"
?>

   

   


