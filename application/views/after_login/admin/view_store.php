<body>

    <div id="wrapper">

        
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            <?php echo $this->load->view("navigation");?>
            
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

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
                        <?php echo '<h4>'.$str_total_records.' records found</h4>';  ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>Postal Code</th>
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
                                                 
                                           $act_line = '<span class="span-action-icon"><a href="'.base_url().'index.php/admin/edit/store/'.$row["id"].'"><img src="'.base_url().'images/edit3.jpe" class="icon-action-image"/></a></span>';
                                           $act_line .= '<span class="span-action-icon"><a href="'.base_url().'index.php/admin/record/store/'.$row["id"].'/delete"><img src="'.base_url().'images/delete3.jpg" class="icon-action-image"/></a></span>';
                                           
                                           if($row["status"] == 0) $act_line .= '<span class="span-action-icon"><a href="'.base_url().'index.php/admin/record/store/'.$row["id"].'/activate"><img src="'.base_url().'images/up_arrow.jpg" class="icon-action-image"/></a></span>';
                                           if($row["status"] == 1) $act_line .= '<span class="span-action-icon"><a href="'.base_url().'index.php/admin/record/store/'.$row["id"].'/unactivate"><img src="'.base_url().'images/down_arrow.jpg" class="icon-action-image"/></a></span>';
                                    ?>
                                    
                                    <tr>
                                        
                                        <td><?php echo $img_line;?></td>
                                        <td><?php echo $row["name"];?></td>
                                        <td><?php echo $row["address"];?></td>
                                        <td><?php echo $row["city"];?></td>
                                        <td><?php echo $row["postal_code"];?></td>
                                        <td><?php echo $row["status"] ? "Active" : "Unactive";?></td>
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
                    
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    
</body>