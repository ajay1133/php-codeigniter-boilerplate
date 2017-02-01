	<script type="text/javascript">
	
		$().ready(function(){
			if (navigator.geolocation) navigator.geolocation.getCurrentPosition(function(pos) 
			{
				var lat = pos.coords.latitude;
				var lon = pos.coords.longitude;
				
				initialize(lat, lon);
			}, function(error) 
			{
				//Unable to get user's location
				alert("Your browser does not support geolocation.");
			});
		});
					
	</script>				
					
    <!-- Page Content -->
    <div class="container-fluid">

        <div class="row-fluid" id="map_container">
		</div>
		
		<div class="row-fluid container_overlap top absolute">
		
			<div class="col-xs-12 search_container">
				<input type="search" name="search" class="search_bar" id="search_bar">
				<input type="submit" name="submit" value="Search" class="search_button">
			</div>
			
		</div>
		
		<div class="row-fluid container_overlap bottom absolute scroll_strip">
			
			<!--Category Holder-->
			
			<div class="col-xs-4 col-sm-3 col-md-2 category_holder" id="category_holder_1">
				<div class="thumbnail">
					<div class="row-fluid caption category_container">
						<div class="col-xs-12 category_image"><img src="http://placehold.it/20x20" class="img-circle" alt="" /></div>
						<div class="col-xs-12 category_label"><a href="#">Category 1</a></div>
					</div>
				</div>
			</div>

			<div class="col-xs-4 col-sm-3 col-md-2 category_holder" id="category_holder_2">
				<div class="thumbnail">
					<div class="row-fluid caption category_container">
						<div class="col-xs-12 category_image"><img src="http://placehold.it/20x20" class="img-circle" alt="" /></div>
						<div class="col-xs-12 category_label"><a href="#">Category 2</a></div>
					</div>
				</div>
			</div>
					
			<div class="col-xs-4 col-sm-3 col-md-2 category_holder" id="category_holder_3">
				<div class="thumbnail">
					<div class="row-fluid caption category_container">
						<div class="col-xs-12 category_image"><img src="http://placehold.it/20x20" class="img-circle" alt="" /></div>
						<div class="col-xs-12 category_label"><a href="#">Category 3</a></div>
					</div>
				</div>
			</div>
			
			<div class="hidden-xs col-sm-3 col-md-2 category_holder" id="category_holder_4">
				<div class="thumbnail">
					<div class="row-fluid caption category_container">
						<div class="col-xs-12 category_image"><img src="http://placehold.it/20x20" class="img-circle" alt="" /></div>
						<div class="col-xs-12 category_label"><a href="#">Category 4</a></div>
					</div>
				</div>
			</div>
			
			<div class="hidden-xs hidden-sm col-md-2 category_holder" id="category_holder_5">
				<div class="thumbnail">
					<div class="row-fluid caption category_container">
						<div class="col-xs-12 category_image"><img src="http://placehold.it/20x20" class="img-circle" alt="" /></div>
						<div class="col-xs-12 category_label"><a href="#">Category 5</a></div>
					</div>
				</div>
			</div>
			
			<div class="hidden-xs hidden-sm col-md-2 category_holder" id="category_holder_6">
				<div class="thumbnail">
					<div class="row-fluid caption category_container">
						<div class="col-xs-12 category_image"><img src="http://placehold.it/20x20" class="img-circle" alt="" /></div>
						<div class="col-xs-12 category_label"><a href="#">Category 6</a></div>
					</div>
				</div>
			</div>

			<!--User Holder-->
			
			<div class="col-xs-4 user_holder" id="user_holder_1">
				<div class="thumbnail">
					<div class="row-fluid caption user_container">
						<div class="col-xs-12 col-md-3 user_image"><img src="http://placehold.it/20x20" class="img-circle" alt="" /></div>
						<div class="col-xs-12 col-md-9 user_column">
							<div class="row-fluid">
								<div class="col-xs-12 col-md-9 user_label"><a href="#">User 1</a></div>
								<div class="col-xs-12 col-md-3 user_rating">4.6  <span class="glyphicon glyphicon-star"></span></div>
								<div class="col-xs-12 user_description">Description some text here</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-4 user_holder" id="user_holder_2">
				<div class="thumbnail">
					<div class="row-fluid caption user_container">
						<div class="col-xs-12 col-md-3 user_image"><img src="http://placehold.it/20x20" class="img-circle" alt="" /></div>
						<div class="col-xs-12 col-md-9 user_column">
							<div class="row-fluid">
								<div class="col-xs-12 col-md-9 user_label"><a href="#">User 2</a></div>
								<div class="col-xs-12 col-md-3 user_rating">4.5  <span class="glyphicon glyphicon-star"></span></div>
								<div class="col-xs-12 user_description">Description some text here</div>
							</div>
						</div>
					</div>
				</div>
			</div>
					
			<div class="col-xs-4 user_holder" id="user_holder_3">
				<div class="thumbnail">
					<div class="row-fluid caption user_container">
						<div class="col-xs-12 col-md-3 user_image"><img src="http://placehold.it/20x20" class="img-circle" alt="" /></div>
						<div class="col-xs-12 col-md-9 user_column">
							<div class="row-fluid">
								<div class="col-xs-12 col-md-9 user_label"><a href="#">User 3</a></div>
								<div class="col-xs-12 col-md-3 user_rating">4.4  <span class="glyphicon glyphicon-star"></span></div>
								<div class="col-xs-12 user_description">Description some text here</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
        </div>