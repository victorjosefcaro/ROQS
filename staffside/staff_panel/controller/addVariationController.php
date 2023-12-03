<?php
    include_once "../config/dbconnect.php";
    
    if(isset($_POST['upload']))
    {
       
        $product = $_POST['product'];

        $qty = $_POST['qty'];
        // product_size_variation to product_size_variation2
         $insert = mysqli_query($conn,"INSERT INTO product_size_variation
         (product_id,quantity_in_stock) VALUES ('$product','$qty')");
 
         if(!$insert)
         {
             echo mysqli_error($conn);
             
         }
         else
         {
             echo "Records added successfully.";
             
         }
     
    }
        // sa pag add sa product size item
?>