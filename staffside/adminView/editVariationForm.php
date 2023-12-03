<div class="container p-5">

<h4>Edit Inventory Product</h4>
<?php
    include_once "../config/dbconnect.php";
	$ID=$_POST['record'];
	$qry=mysqli_query($conn, "SELECT * from product_size_variation Where variation_id='$ID'"); 
    // product_size_variation to product_size_variation2
	$numberOfRow=mysqli_num_rows($qry);
	if($numberOfRow>0){
		while($row1=mysqli_fetch_array($qry)){
      $pID=$row1["product_id"];
      
?>
<form id="update-Items" onsubmit="updateVariations()" enctype='multipart/form-data'>
	<div class="form-group">
      <input type="text" class="form-control" id="v_id" value="<?=$row1['variation_id']?>" hidden>
    </div>
    <div class="form-group">
        <label>Product:</label>
        <select id="product" >
        <?php

        $sql="SELECT * from product where product_id=$pID";
        $result = $conn-> query($sql);

        if ($result-> num_rows > 0){
        while($row = $result-> fetch_assoc()){
            echo"<option selected value='".$row['product_id']."'>".$row['product_name'] ."</option>";
        }
        }
        ?>
        <?php

            $sql="SELECT * from product where product_id!=$pID";
            $result = $conn-> query($sql);

            if ($result-> num_rows > 0){
            while($row = $result-> fetch_assoc()){
                echo"<option value='".$row['product_id']."'>".$row['product_name'] ."</option>";
            }
            }
        ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="qty">Stock Quantity:</label>
        <input type="number" class="form-control" id="qty" value="<?=$row1['quantity_in_stock']?>"  required>
    </div>
    <div class="form-group">
      <button type="submit" style="height:40px" class="btn btn-primary">Update Variation</button>
    </div>
    <?php
    		}
    	}
    ?>
  </form>

  
</div>