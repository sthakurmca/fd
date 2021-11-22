    <?php //print_r($_POST);
      if(isset($_GET['m'])){
        $msgs = $_GET['m'];
      }else{
        $msgs = "";
      }
      if(isset($_POST['save'])){
        $type = $_POST['type'];
        $product = $_POST['product'];
        $producttype = $_POST['producttype'];
        $productgrade = $_POST['productgrade'];
        $productmenu = $_POST['productmenu'];
        $thickness = $_POST['thickness'];
        $width = $_POST['width'];
        $length = $_POST['length'];
        $productaction = $_POST['productaction'];
        $qtyb = $_POST['qtyb'];
        $pprice = $_POST['pprice'];
        $source = $_POST['source'];
        $invoice = $_POST['invoice'];
        $hsn = $_POST['hsn'];
        $sku = $_POST['sku'];
        $idate = $_POST['idate'];
        $qtys = $_POST['qtys'];
        $sprice = $_POST['sprice'];
        $onumber = $_POST['onumber'];
        $pname = $_POST['pname'];
        $tnumber = $_POST['tnumber'];
        $odate = $_POST['odate'];
        $save = $_POST['save'];

        $sqlitem = "SELECT item_id FROM item WHERE 
        item_type = '".$type."' AND
        item_category = '".$product."' AND
        item_sub_category = '".$producttype."' AND
        item_manufacturer = '".$productmenu."' AND
        item_grade = '".$productgrade."' AND
        item_thickness = '".trim($thickness)."' AND
        item_width = '".trim($width)."' AND
        item_length = '".trim($length)."'";
        $resultitem = $conn->query($sqlitem);

        if(trim($productaction) == "grn"){//For Buy

          if ($resultitem->num_rows > 0) {
            $row = $resultitem->fetch_assoc();//print_r($row);
            $sqlupdateitem = "UPDATE item SET item_quantity = item_quantity+".$qtyb." WHERE item_id = ".$row['item_id'];
            $conn->query($sqlupdateitem);
            $itemid = $row['item_id'];
          }else{
            $sqlinsertitem = "INSERT INTO item (item_type,item_category,item_sub_category,item_manufacturer,item_grade,item_thickness,item_width,item_length,item_quantity)
            VALUES ('".$type."','".$product."','".$producttype."','".$productmenu."','".$productgrade."','".trim($thickness)."','".trim($width)."','".trim($length)."','".$qtyb."')";
            $conn->query($sqlinsertitem);
            $itemid = $conn->insert_id;
          }
          $sqlstock = "INSERT INTO stock (stock_item_id, stock_user_id, stock_quantity, stock_inward_date, stock_ref_invoice, stock_hsn, stock_sku, stock_purchased_price, stock_type, stock_source)
          VALUES ('".$itemid."', '".$_SESSION['userid']."', '".$qtyb."','".$idate."', '".$invoice."','".$hsn."','".$sku."','".$pprice."',1,'".$source."')";
          $conn->query($sqlstock);

        }elseif(trim($productaction) == "outward"){//For Sell

          if ($resultitem->num_rows > 0) {
            $row = $resultitem->fetch_assoc();//print_r($row);
            $sqlupdateitem = "UPDATE item SET item_quantity = item_quantity-".$qtys." WHERE item_id = ".$row['item_id'];
            $conn->query($sqlupdateitem);
            $itemid = $row['item_id'];
          }else{
            $mid = -$qtys;
            $sqlinsertitem = "INSERT INTO item (item_type,item_category,item_sub_category,item_manufacturer,item_grade,item_thickness,item_width,item_length,item_quantity)
            VALUES ('".$type."','".$product."','".$producttype."','".$productmenu."','".$productgrade."','".trim($thickness)."','".trim($width)."','".trim($length)."','".$mid."')";
            $conn->query($sqlinsertitem);
            $itemid = $conn->insert_id;
          }
          $sqlstock = "INSERT INTO stock (stock_item_id, stock_user_id, stock_quantity, stock_inward_date, stock_ref_invoice, stock_sellprice, stock_type, stock_customer, stock_truck)
          VALUES ('".$itemid."', '".$_SESSION['userid']."', '".$qtys."','".$odate."', '".$onumber."','".$sprice."',2,'".$pname."','".$tnumber."')";
          $conn->query($sqlstock);

        }///echo $sqlupdateitem.$sqlstock;
        echo "<script>window.location.href='iredir.php'</script>";
        //$msgs = "Stock updated.";

      }
    ?>
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <?php echo "<code>".$msgs."</code>";?>
                  <h4 class="card-title">Inventory Form</h4>
                  <form class="form-sample" method="POST" names="ps" id="ps" action="index.php?page=inventory" enctype="multipart/form-data" onsubmit="return validateForm();">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Type</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="type" id="type">
                              <option value="Steel">Steel</option>
                              <option value="Sanitary">Sanitary</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Product</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="product" id="product" onchange="subcategory(this);">
                              <option value="Hot Rolled - HR" selected>Hot Rolled - HR</option>
                              <option value="Cold Rolled - CR">Cold Rolled - CR</option>
                              <option value="Galvanized - GAL">Galvanized - GAL</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Product Type</label>
                          <div class="col-sm-9" id="ptype">
                            <select class="form-control" name="producttype" id="producttype">
                              <option value="HR Coil" selected>HR Coil</option>
                              <option value="HR SHEETS/Plates">HR SHEETS/Plates</option>
                              <option value="HR Cut To Size">HR Cut To Size</option>
                              <option value="HR Slitted Coil">HR Slitted Coil</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Product Grade</label>
                          <div class="col-sm-9" id="pgrade">
                            <select class="form-control" name="productgrade" id="productgrade">
                              <option value="IS 1074 - IS 1079" selected>IS 1074 - IS 1079</option>
                              <option value="IS2062-E250">IS2062 - E250</option>
                              <option value="IS2062-E350">IS2062 - E350 (HT52.5 /SAPH/QST/E355MC)</option>
                              <option value="Chequered">Chequered </option>
                              <option value="BSK-46" >BSK-46</option>
                              <option value="Domex/Strenx">Domex/Strenx</option>
                              <option value="Hardox">Hardox</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Manufacturer</label>
                          <div class="col-sm-9" id="ptype">
                            <select class="form-control" name="productmenu" id="productmenu" required>
                              <option value="" selected>Please Select</option>  
                              <option value="SAIL">SAIL</option>
                              <option value="UTTAM" >UTTAM</option>
                              <option value="JSW" >JSW</option>
                              <option value="AMNS" >AMNS</option>
                              <option value="TATA" >TATA</option>
                              <option value="JSPL" >JSPL</option>
                            </select>
                          </div>
                        </div>
                      </div>  
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Thickness</label>
                          <div class="col-sm-9">
                            <input required type="number" step=".001" name="thickness" id="thickness" value="" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Width</label>
                          <div class="col-sm-9">
                            <input required name="width" id="width" value="" class="form-control" />
                          </div>
                        </div>
                      </div>  
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Length</label>
                          <div class="col-sm-9">
                            <input required type="number" step=".001" name="length" id="length" value="" class="form-control" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">GRN/OutWard</label>
                          <div class="col-sm-9" id="ptype">
                            <select class="form-control" name="productaction" id="productaction" onchange="toggel(this);" required>
                              <option value="" selected>Please Select GRN/OutWard</option>
                              <option value="grn" >GRN</option>
                              <option value="outward" >OutWard</option>
                            </select>
                          </div>
                        </div>
                      </div>  
                      <div class="col-md-6">
                        <div class="form-group row">
                          <!--<label class="col-sm-3 col-form-label">Source</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="source" id="source" value=""/>
                          </div>-->
                        </div>
                      </div>
                    </div>
                    <div id="buy" style="display:none;">
                      <div class="row">

                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Quantity</label>
                            <div class="col-sm-9">
                              <input type="number" name="qtyb" id="qtyb" step=".001" value="" class="form-control" />
                            </div>
                          </div>
                        </div>  
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                              <input type="number" step=".001" name="pprice" id="pprice" value="" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Source</label>
                            <div class="col-sm-9">
                              <input type="text" name="source" id="source" value="" class="form-control" />
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="row">

                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Invoice</label>
                            <div class="col-sm-9">
                              <input type="text" name="invoice" id="invoice" value="" class="form-control" />
                            </div>
                          </div>
                        </div>  
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">HSN</label>
                            <div class="col-sm-9">
                              <input type="text" name="hsn" id="hsn" value="" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">SKU</label>
                            <div class="col-sm-9">
                              <input type="text" name="sku" id="sku" value="" class="form-control" />
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="row">  
                        <div class="col-md-4">
                          <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date</label>  
                          <div class="col-sm-9">
                              <input type="date" name="idate" id="idate" value="" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group row">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="sell" style="display:none;">
                      <div class="row">

                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Quantity </label>
                            <div class="col-sm-9">
                              <input type="number" step=".001" name="qtys" id="qtys" value="" class="form-control" />
                            </div>
                          </div>
                        </div>  
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                              <input type="number" step=".001" name="sprice" id="sprice" value="" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">OrderNo</label>
                            <div class="col-sm-9">
                              <input type="text" name="onumber" id="onumber" value="" class="form-control" />
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="row">

                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Party</label>
                            <div class="col-sm-9">
                              <input type="text" name="pname" id="pname" value="" class="form-control" />
                            </div>
                          </div>
                        </div>  
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Truck</label>
                            <div class="col-sm-9">
                              <input type="text" name="tnumber" id="tnumber" value="" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-9">
                              <input type="date" name="odate" id="odate" value="" class="form-control" />
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="row">  
                      <div class="col-md-12">
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <input type="submit" name="save" id="save" value="Save" class="btn btn-primary mr-2" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include("footer.php");?>
    </div>
      <!-- main-panel ends -->
<script>
  function subcategory(id){
    if(id.value == "Hot Rolled - HR"){
      document.getElementById("ptype").innerHTML ="<select class='form-control' name='producttype' id='producttype'><option value='HR Coil' selected>HR Coil</option><option value='HR SHEETS/Plates'>HR SHEETS/Plates</option><option value='HR Cut To Size'>HR Cut To Size</option><option value='HR Slitted Coil'>HR Slitted Coil</option></select>";
      document.getElementById("pgrade").innerHTML ="<select class='form-control' name='productgrade' id='productgrade'><option value='IS 1074 - IS 1079' selected>IS 1074 - IS 1079</option><option value='IS2062-E250'>IS2062 - E250</option><option value='IS2062-E350'>IS2062 - E350 (HT52.5 /SAPH/QST/E355MC)</option><option value='Chequered'>Chequered </option><option value='BSK-46' selected>BSK-46</option><option value='Domex/Strenx'>Domex/Strenx</option><option value='Hardox'>Hardox</option></select>";
    }else if(id.value == "Cold Rolled - CR"){
      document.getElementById("ptype").innerHTML = "<select class='form-control' name='producttype' id='producttype'><option value='CRCA Coil' selected>CRCA Coil</option><option value='CRCA Sheets'>CRCA Sheets</option><option value='CRCA Cut To Size'>CRCA Cut To Size</option><option value='CRCA Slitted Coil'>CRCA Slitted Coil</option></select>";
      document.getElementById("pgrade").innerHTML = "<select class='form-control' name='productgrade' id='productgrade'><option value='D Grade' selected>D Grade</option><option value='ED Grade' >ED Grade</option><option value='EDD Grade' >EDD Grade</option></select>";
    }else if(id.value == "Galvanized - GAL"){
      document.getElementById("ptype").innerHTML = "<select class='form-control' name='producttype' id='producttype'><option value='GL Coil' selected>GL Coil</option><option value='GL Sheets'>GL Sheets</option><option value='GL Cut To Size'>GL Cut To Size</option><option value='GL Slitted Coil'>GL Slitted Coil</option></select>";
      document.getElementById("pgrade").innerHTML = "<select class='form-control' name='productgrade' id='productgrade'><option value='1' selected>No Option available</option></select>";
    }
  }
  function toggel(id){
    if(id.value == "grn"){
      document.getElementById("buy").style.display = "block";
      document.getElementById("sell").style.display = "none";
    }else if(id.value == "outward"){
      document.getElementById("sell").style.display = "block";
      document.getElementById("buy").style.display = "none";
    }else{
      document.getElementById("sell").style.display = "none";
      document.getElementById("buy").style.display = "none";
    }
  }
  function validateForm(){
    let bb = document.getElementById("productmenu").value;
    let cc = document.getElementById("thickness").value;
    let dd = document.getElementById("width").value;
    let ee = document.getElementById("length").value;

    let a = document.getElementById("productaction").value;
    let b = document.getElementById("qtyb").value;
    let c = document.getElementById("pprice").value;
    let d = document.getElementById("source").value;
    let e = document.getElementById("invoice").value;
    let g = document.getElementById("hsn").value;
    let h = document.getElementById("sku").value;
    let i = document.getElementById("idate").value;
    let j = document.getElementById("qtys").value;
    let k = document.getElementById("sprice").value;
    let l = document.getElementById("onumber").value;
    let m = document.getElementById("pname").value;
    let n = document.getElementById("tnumber").value;
    let o = document.getElementById("odate").value;

    if(bb == ""){
        alert("Please select product manufacturer.");return false;
    }else if(cc == ""){
      alert("Please fill the Thickness.");return false;
    }else if(cc == ""){
      alert("Please fill the Width.");return false;
    }else if(cc == ""){
      alert("Please fill the Length.");return false;
    }else if(a == ""){
      alert("Please select the GRN/OutWard.");return false;
    }else{
      if(a == "grn"){

        if(b == ""){
          alert("Please fill the quantity.");return false;
        }else if(c == ""){
          alert("Please fill the price.");return false;
        }else if(d == ""){
          alert("Please fill the source.");return false;
        }else if(e == ""){
          alert("Please fill the invoice.");return false;
        }else if(g == ""){
          alert("Please fill the hsn.");return false;
        }else if(h == ""){
          alert("Please fill the sku.");return false;
        }else if(i == ""){
          alert("Please fill the date.");return false;
        }else{
          return true;
        }

      }else if(a == "outward"){
        if(j == ""){
          alert("Please fill the quantity.");return false;
        }else if(k == ""){
          alert("Please fill the price.");return false;
        }else if(l == ""){
          alert("Please fill the order number.");return false;
        }else if(m == ""){
          alert("Please fill party name.");return false;
        }else if(n == ""){
          alert("Please fill the truck number.");return false;
        }else if(o == ""){
          alert("Please fill the date.");return false;
        }else{
          return true;
        }
      }
    }
  }
</script>