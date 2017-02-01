<body>

    <div id="wrapper">

        
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            <?php echo $this->load->view("navigation");?>
            
        </nav>

        <div id="page-wrapper" style="min-height:600px">

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
                
                <div class="row">
                    <div class="col-lg-6">
                        
                       <form role="form" action="<?php echo base_url();?>index.php/admin/add/store" method="POST" enctype="multipart/form-data">
                          
                                       
                          <div class="form-group">
                                <label>Store Name :</label>
                                <input  type="text" name="name" class="form-control" placeholder="Store Name">
                          </div>
                          
                          <div class="form-group">
                                <label>Store Address :</label>
                                <input  type="text" name="address" class="form-control" placeholder="Store Address">
                          </div>
                          
                           <div class="form-group">
                                <label>City :</label>
                                <input  type="text" name="city" class="form-control" placeholder="City">
                          </div>
                          
                          <div class="form-group">
                                <label>Postal Code :</label>
                                <input  type="text" name="postal_code" class="form-control" placeholder="Postal Code">
                          </div>
                          
                          <div class="form-group">
                                <label>Store Image :</label>
                                <input type="file" name="imgfile">
                          </div>
                          
                          <input type="submit" value="Submit" name="submit" class="btn btn-default"/>
                          <button type="reset" class="btn btn-default">Reset Button</button>
                          
                       </form>
                        
                    </div>
                </div>
                <!-- /.row -->

                <div class="row" style="height:20px">
                    
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    
</body>