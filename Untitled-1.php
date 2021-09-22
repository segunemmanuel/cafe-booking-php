<?php require_once("config.php"); ?>
<?php
// ADDING TO CART FUNCTIONALITY
//CREATE A SESSION AND APPEND TO THE GET REQUEST
if(isset($_GET['add'])){
    $query=query("SELECT * FROM product WHERE id = " . espace_string($_GET['add']). " ");
    confirm($query);
    while($row=fetch_array($query)){
        if($row['prod_qty'] != $_SESSION['product_'. $_GET['add']]){
            $_SESSION['product_'. $_GET['add']]+=1;
            redirect("../public/checkout.php");
        }
        else{
            set_message("We only have". " ". $row['prod_qty'] . " " ." ". "{$row['prod_title']}". "available" );
            redirect("../public/checkout.php");
        }
    }

// $_SESSION['product_' . $_GET['add']]+=1;
// redirect("index.php");

}

// REMOVE
if(isset($_GET['remove'])){
    $_SESSION['product_' .$_GET['remove']]-=1;
    if($_SESSION['product_' .$_GET['remove']] < 1){
    unset($_SESSION['item_total']);
    unset($_SESSION['item_qty']);

        redirect("../public/checkout.php");
    }
    else{
        redirect("../public/checkout.php");
    }
}
// DELETE

if(isset($_GET['delete'])){
    $_SESSION['product_' .$_GET['delete']]='0';
    unset($_SESSION['item_total']);
    unset($_SESSION['item_qty']);
    redirect("../public/checkout.php");
}
// ADDING TO CART
function cart()  {
$total=0;
$item_qty=0;
$item_name=1;
$item_number=1;
$amount=1;
$quantity=1;


foreach($_SESSION as $name => $value){
if($value > 0){
if(substr($name, 0, 8) == "product_"){
$length=strlen($name) - 8;
$id=substr($name, 8, $length);
$query=query("SELECT * FROM product WHERE id = " . espace_string($id)."" );
confirm($query);
while($row=fetch_array($query)){
$sub=$row['prod_price'] * $value;
$item_qty +=$value;
$products = <<<DELIMITER
<tr>
<td>{$row['prod_title']}</td>
<td>&#36;{$row['prod_price']}</td>
<td>{$value}</td>
<td>&#36;{$sub}</td>
<td><a  class="btn btn-warning" href="../resources/cart.php?remove={$row['id']}"><span class="glyphicon glyphicon-minus"></span></a>  
<a  class="btn btn-success" href="../resources/cart.php?add={$row['id']}"><span class="glyphicon glyphicon-plus"></span></a>
<a  class="btn btn-danger" href="../resources/cart.php?delete={$row['id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>
<input type="hidden" name="item_name_{$item_name}" value="{$row['prod_title']}">
<input type="hidden" name="item_number_{$item_number}" value="{$row['id']}">
<input type="hidden" name="amount_{$amount}" value="{$row['prod_price']}">
<input type="hidden" name="quantity_{$quantity}" value="{$value}">
DELIMITER;
echo $products;
$item_name++;
$item_number++;
$amount++;
$quantity++;

}
$_SESSION['item_total']=$total+=$sub;
$_SESSION['item_qty']=$item_qty;
}
}
}

















function show_paypal(){
    if(isset($_SESSION['item_qty'])  &&  $_SESSION['item_qty'] >=1){

    
    $paypal_button = <<< DELIMITER

    <input type="image" name="upload" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">    
    DELIMITER;
    return $paypal_button;
}
}


}

?>
