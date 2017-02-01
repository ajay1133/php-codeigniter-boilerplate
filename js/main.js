function get_CI_base_url()
{
	var base_url = window.location.origin;
	
	return base_url;
}

function initialize(lat = 0, lon = 0)
{
	var mapOptions = {
        center: new google.maps.LatLng(lat, lon),
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
		disableDefaultUI: true, // a way to quickly hide all controls
    };
			
    window.map = new google.maps.Map(document.getElementById("map_container"), mapOptions);
                                            
    var marker=new google.maps.Marker({
        position: new google.maps.LatLng(lat, lon),
        map: window.map
    });
			
	var circle = new google.maps.Circle({
        map: window.map,
        radius: 1000,    // 1KM in metres
        fillColor: '#00AA00'
    });
               
	circle.bindTo('center', marker, 'position');
			
	set_location_for_search_bar(lat, lon);
}
					
function set_location_for_search_bar(lat = 0, lon = 0)
{
	var geocoder = new google.maps.Geocoder();

	var latlng = new google.maps.LatLng(lat, lon);

	geocoder.geocode({
		'latLng': latlng
	}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) 
		{
			if (results[0]) 
			{
				var address = results[0].formatted_address;
						
				document.getElementById("search_bar").placeholder = " Near " + address;
				
				//show_web_results();
			} 
			else 
			{
				alert("address not found");
			}
		} 
		else 
		{
			alert("Unable to find address");
		}
	});
}

function show_web_results()
{
	$.ajax({
		url: get_CI_base_url + "index.php/api/get_web_results/",
		type: "POST",
		data: {address : address},
		success: function(response) 
		{
			response = $.parseJSON(response);
						
			var totalResults = response["queries"]["totalResults"];
			var startIndex = response["queries"]["startIndex"];
			var count = response["queries"]["count"];
						
			for( var i = startIndex; i < startIndex + count; i++ )
			{
				
			}
		},
		error: function(response)
		{
			alert("Unable to retrieve data");
		},
	});
}
		