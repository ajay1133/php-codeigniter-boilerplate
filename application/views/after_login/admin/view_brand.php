<body>

    <div id="wrapper">

        
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            <?php echo $this->load->view("navigation");?>
            
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

			    <div id="back-layer">
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
                   $item = $this->data["item"];
                   
                   $total_records = count($data);
                   $count = 0;
                   
                   $str_total_records = $total_records ? $total_records : "No";
                   
                ?>
                
                <div class="row" style="min-height:400px">  
                     <div class="col-lg-12">                      
                        <?php echo '<h4>'.$str_total_records.' records found</h4>';?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
										<th>No. of Medicines</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php foreach($data as $row) { ?>
                                                                        
                                    <?php
                                        
                                        if($index <= $count && $count < $index + $this->config->item("items_per_view"))
                                        {
                                        	 $default_image = $this->config->item("default_image");
                                        	 
                                           $image = !empty($row["image"]) ? $this->functions->getuploadurl($item).$row["image"] : $this->functions->getuploadurl($item).$default_image[$item];                                        	
                                           $img_line = '<span class="span-icon"><img src="'.$image.'" class="icon-image"/></span>';                                        	 
                                                 
                                           $act_line = '<span class="span-action-icon"><a href="'.base_url().'index.php/admin/edit/brand/'.$row["id"].'"><img src="'.base_url().'images/edit3.jpe" class="icon-action-image"/></a></span>';
                                           $act_line .= '<span class="span-action-icon"><a href="'.base_url().'index.php/admin/record/brand/'.$row["id"].'/delete"><img src="'.base_url().'images/delete3.jpg" class="icon-action-image"/></a></span>';
                                           
                                           if($row["status"] == 0) $act_line .= '<span class="span-action-icon"><a href="'.base_url().'index.php/admin/record/brand/'.$row["id"].'/activate"><img src="'.base_url().'images/up_arrow.jpg" class="icon-action-image"/></a></span>';
                                           if($row["status"] == 1) $act_line .= '<span class="span-action-icon"><a href="'.base_url().'index.php/admin/record/brand/'.$row["id"].'/unactivate"><img src="'.base_url().'images/down_arrow.jpg" class="icon-action-image"/></a></span>';
                                    ?>
                                    
                                    <tr>
                                        
                                        <td onclick = "show_medicines(<?php echo $row["id"];?>)"><?php echo $img_line;?></td>
                                        <td onclick = "show_medicines(<?php echo $row["id"];?>)"><?php echo $row["name"];?></td>
										<td onclick = "show_medicines(<?php echo $row["id"];?>)"><?php echo count($this->functions->gettabledata("medicine","brand_id = ".$row['id']." AND status = 1"));?></td>
                                        <td onclick = "show_medicines(<?php echo $row["id"];?>)"><?php echo $row["status"] ? "Active" : "Unactive";?></td>
                                        <td><?php echo $act_line;?></td>
                                    
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
                    
                <div class="row" id="medicine_block" style="display:none;max-height:500px;overflow-y:scroll;width:70%;position:absolute;top:100px;margin-left:50px;z-index:9999;border:1px solid black;background:white;">
                    
                    <div class="col-lg-12">                      
                        <?php echo '<h4><span id="str_total_records">'.$str_total_records.'</span> records found</h4>';?><div class="col-lg-12"><img src="<?php echo base_url();?>images/cross_sign.jpg" onclick="close_medicine_block()" class="close-order-history"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Medicine Name</th>
                                        <th>Medicine Description</th>
                                        <th>Medicine Price</th>
                                    </tr>
                                </thead>
                                <tbody id="medicine_tbody">
                                
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

<?php 
 
 $medicines = $this->functions->gettabledata("medicine","status = 1");
 
 $medicines_data = array();
 
 foreach($medicines as $key => $val)
 {
    $medicines_data[$val["brand_id"]][] = $val;
 }
 //echo "<pre>";print_r($medicines_data);echo "</pre>";die;
?>

<script type="text/javascript">
    
	var baseurl ="<?php echo base_url();?>";
    var data = <?php echo json_encode($medicines_data);?>;
    
    function show_medicines(brand_id)
    {
    	 var str_total_records = data[brand_id].length;
    	 document.getElementById("str_total_records").innerHTML = str_total_records;
    	 
    	 var tbody = "";
    	 
    	 for(var i = 0; i < str_total_records; i++)
    	 {
    	 	 tbody += "<tr>";
    	     tbody += "<td><span class='span-icon'><img class='icon-image' src='" + baseurl + "upload/medicine/" + data[brand_id][i]["image"] + "'/></span></td>";
             tbody += "<td>" + data[brand_id][i]["name"] + "</td>";
             tbody += "<td>" + data[brand_id][i]["description"] + "</td>";
			 tbody += "<td>" + data[brand_id][i]["amount"] + "</td>";
             tbody += "</tr>";
         }
       
         document.getElementById("medicine_tbody").innerHTML = tbody;
         document.getElementById("back-layer").style.opacity = "0.1";
         document.getElementById("page-wrapper").style.background = "gray";
         document.getElementById("medicine_block").style.display = "block";
    }
    
    function close_medicine_block()
    {
    	 document.getElementById("medicine_block").style.display = "none";
    	 document.getElementById("page-wrapper").style.background = "white";
    	 document.getElementById("back-layer").style.opacity = "1";
    }
    
</script>