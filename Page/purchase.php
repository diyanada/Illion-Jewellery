<?php
require_once (dirname(__FILE__) . '/../Class/interface_magic.php');
$int_mg = new interface_magic();

$file = $int_mg -> Invoice_Path() . "/" . $view -> _prams["ID"] . ".php";

include $file;

?>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">

  <!-- Identify your business so that you can collect the payments. -->
  <input type="hidden" name="business" value="illionjewellery@hotmail.com">

  <!-- Specify a Buy Now button. -->
  <input type="hidden" name="cmd" value="_xclick">

  <!-- Specify details about the item that buyers will purchase. -->
  <input type="hidden" name="item_name" value="Hot Sauce-12 oz. Bottle">
  <input type="hidden" name="amount" value="2000">
  <input type="hidden" name="quantity" value="2">
  <input type="hidden" name="currency_code" value="USD">

  <!-- Specify the discount percentages that apply to the item. -->
  <input type="hidden" name="discount_amount" value="0">
  <input type="hidden" name="tax_rate" value="6.00">

  <!-- Prompt buyers to enter the quantities they want. -->
  <input type="hidden" name="undefined_quantity" value="0">

  <!-- Display the payment button. -->
  <input type="image" name="submit" border="0"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">
  <img alt="" border="0" width="1" height="1"
    src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

</form>
