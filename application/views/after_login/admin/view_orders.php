<body>

    <div id="wrapper">

        
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            <?php echo $this->load->view("navigation");?>
            
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
                
                <div id="back-layer" id="back-layer">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $this->data["title"];?>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                
                    <?php if($this->session->flashdata("message")) { ?>
                    
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $this->session->flashdata("message");?>
                        </div>
                    </div>
                    
                    <?php } ?>
                    
                </div>
                <!-- /.row -->
                
                <?php
                   
                   $data = $this->data["data"];
                   $index = $this->data["index"];
                   $action = $this->data["action"];
                   
                   $total_records = count($data);
                   $count = 0;
                   
				   $str_total_records = $total_records ? $total_records : "No";
				   
                   $total_amount = array();
                   $date = array();
				   
                   foreach($data as $key => $val) 
                   {
				     $created_on = "";
					 
                   	 foreach($val as $vkey => $vval)
                   	 {
                   	    if(array_key_exists($key,$total_amount)) $total_amount[$key] += $vval["amount"]; 
                   	    else $total_amount[$key] = $vval["amount"];
						$created_on = $vval["created_on"];
                   	 }
					 
					 $date[$key] = $this->functions->readable_date($created_on);
                   }
                    
                ?>
                
                <div class="row" style="min-height:400px">  
                     <div class="col-lg-12">                      
                        <?php echo '<h4>'.$str_total_records.' records found</h4>';?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Order No</th>
										<th>User</th>
										<th>Store</th>
                                        <th>Total Medicine Quantity</th>
                                        <th>Total Order Amount</th>
                                        <th>Ordered On</th>
										<?php if($action == "requests") echo "<th>Order Status</th>"; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php foreach($data as $key => $val) { ?>
                                                                        
                                    <?php
                                        
                                        if($index <= $count && $count < $index + $this->config->item("items_per_view"))
                                        {
                                        	 
                                    ?>
                                    
                                    <tr>
                                         
                                        <td onclick = "show_order_history(<?php echo $key;?>)"><?php echo $key;?></td>
										<td onclick = "show_order_history(<?php echo $key;?>)"><?php echo $val[0]["fname"]." ".$val[0]["lname"];?></td>
										<td onclick = "show_order_history(<?php echo $key;?>)"><?php echo $val[0]["store_name"];?></td>
                                        <td onclick = "show_order_history(<?php echo $key;?>)"><?php echo count($data[$key]);?></td>
                                        <td onclick = "show_order_history(<?php echo $key;?>)"><?php echo $total_amount[$key];?></td>
                                        <td onclick = "show_order_history(<?php echo $key;?>)"><?php echo $date[$key];?></td>
									
                                        <?php if($action == "requests") echo "<td><button onclick = 'approve_order(".$key.")'>Done</button></td>"; ?>
                                        
                                    </tr>
                                    
                                    <?php } $count++; } ?>
                                   
                                    
                                </tbody>
                            </table>
                        </div>
                   </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                      <div class="pagination-link">
                        <?php echo $this->pagination->create_links();?>
                      </div>
                    </div>
                </div>
                
                </div> <!--back-layer ends here-->    
                    
                <div class="row" id="order_history" style="display:none;max-height:500px;overflow-y:scroll;width:70%;position:absolute;top:100px;margin-left:50px;z-index:9999;border:1px solid black;background:white;">
                    <div class="col-lg-12"><img src="<?php echo base_url();?>images/cross_sign.jpg" onclick="close_order_history()" class="close-order-history"></div>
                    <div class="col-lg-12">                      
                        <?php echo '<h4><span id="order_total_records">'.$total_records.'</span> Records found</h4>';?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Brand Name</th>
                                        <th>Medicine Name</th>
                                        <th>Order Quantity</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="order_tbody">
                                
                                </tbody>
                            </table>
                        </div>
                     </div>
                </div>
            
            </div>
            <!-- /.container-fluid -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    
</body>

<script type="text/javascript">
    
    var data = <?php echo json_encode($data);?>;
    
    function show_order_history(order_no)
    {
    	 var order_total_records = data[order_no].length;
    	 document.getElementById("order_total_records").innerHTML = order_total_records;
    	 
    	 var tbody = "";
    	 
    	 for(var i = 0; i < order_total_records; i++)
    	 {
    	 	 tbody += "<tr>";
    	    tbody += "<td>" + data[order_no][i]["brand_name"] + "</td>";
          tbody += "<td>" + data[order_no][i]["medicine_name"] + "</td>";
          tbody += "<td>" + data[order_no][i]["quantity"] + "</td>";
          tbody += "<td>" + data[order_no][i]["amount"] + "</td>";
          tbody += "</tr>";
       }
       
       document.getElementById("order_tbody").innerHTML = tbody;
       document.getElementById("back-layer").style.opacity = "0.1";
       document.getElementById("page-wrapper").style.background = "gray";
       document.getElementById("order_history").style.display = "block";
    }
    
    function close_order_history()
    {
    	 document.getElementById("order_history").style.display = "none";
    	 document.getElementById("page-wrapper").style.background = "white";
    	 document.getElementById("back-layer").style.opacity = "1";
    }
    
	function approve_order(order_no)
	{
	     var baseurl = "<?php echo base_url();?>";
	     window.location.href = baseurl + "index.php/admin/approve_order/" + order_no;
	}
</script>