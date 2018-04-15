var map;

function initMap(latValue,longValue,locValue,typeValue) {
	//define the latitude positions
	var latitude = parseFloat(latValue);
	//define the longitude positions
	var longitude = parseFloat(longValue);
	//define google maps position
	var latlngPos = {lat: latitude, lng: longitude};
	if(map == null){
		//set up options for the map
		var myOptions = {
			zoom:4,
			center:latlngPos
		};
		//define the map
		map = new google.maps.Map(document.getElementById("map"),myOptions);
		map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('legend'));
	}
	addMarker(latlngPos,locValue,typeValue);
	google.maps.event.addListener(map,'dragstart',function(event) {
		if(event != null){
			addMarker(event.latlngPos,'Click Generated Marker',typeValue);
		}
		var lat,lng,address;
	});
}

function addMarker(latlng,title,type) {
	var marker = new google.maps.Marker({
		position: latlng,
		map: map,
		title: title,
		icon: 'images/' + type + '.png'
	});
	google.maps.event.addListener(map, 'zoom_changed', function () {
		var zoom = document.getElementById('zoom');
		if(zoom != null){
			zoom.value = map.getZoom();
		}
	});
}

function loadAllMarkers(markers){
	if(map == null){
		//set up options for the map
		var myOptions;
		if(markers[0] != null){
			myOptions = {
				zoom:4,
				center:{lat: markers[0][0], lng: markers[0][1]}
			};
		} else {
			myOptions = {
				zoom:4,
				center:{lat: 37.0902, lng: -95.7129}
			};			
		}
		//define the map
		map = new google.maps.Map(document.getElementById("map"),myOptions);
		map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('legend'));
	}
	for(var i=0;i<markers.length;i++){
		addMarker({lat: markers[i][0], lng: markers[i][1]},markers[i][2],markers[i][3]);
	}
}

function loadListOfLocations(locations){
	var list = document.getElementById("list");
	var countries = [];
	for(var i=0;i<locations.length;i++){
		var addressArray = locations[i][0].split(", ");
		if(document.getElementById(addressArray[addressArray.length-1]) == null){
			var country = addressArray[addressArray.length-1];
			countries.push(country);
			//create box for country
			var listItem = document.createElement("div");
			list.appendChild(listItem);
			listItem.setAttribute("id",country);
			listItem.className = "listItem";
			listItem.setAttribute("style","border:3px solid black;padding:10px;margin:10px;flex:1;");
			//create link for pop up
			var listItemLink = document.createElement("a");
			listItem.appendChild(listItemLink);
			listItemLink.setAttribute("href",window.location.href + "&country=" + country);
			listItemLink.setAttribute("style","font-style:normal;");
			//title, child of list item
			var listItemTitle = document.createElement("p");
			listItemLink.appendChild(listItemTitle);
			listItemTitle.innerHTML = country;
			listItemTitle.className = "title"
			listItemTitle.setAttribute("style","text-align:center;font-weight:bold;");
			//divider, child of list item
			var listItemDivider = document.createElement("hr");
			listItemLink.appendChild(listItemDivider);
			//parent div, child of list item
			var listItemParentDiv = document.createElement("div");
			listItemLink.appendChild(listItemParentDiv);
			listItemParentDiv.setAttribute("style","display:flex;flex-wrap:wrap;justify-content:center;");
			//child div 1, child of parent div
			var listItemChildDiv1 = document.createElement("div");
			listItemParentDiv.appendChild(listItemChildDiv1);
			listItemChildDiv1.setAttribute("style","padding:10px;margin:10px;flex:1;");
			//child div 2, child of parent div
			var listItemChildDiv2 = document.createElement("div");
			listItemParentDiv.appendChild(listItemChildDiv2);
			listItemChildDiv2.setAttribute("style","padding:10px;margin:10px;flex:1;");
			//text 1, child of child div 1
			var listItemText1 = document.createElement("p");
			listItemChildDiv1.appendChild(listItemText1);
			listItemText1.innerHTML = "Want To Visit";
			listItemText1.setAttribute("style","text-align:center;");
			//text 2, child of child div 1
			var listItemText2 = document.createElement("p");
			listItemChildDiv1.appendChild(listItemText2);
			listItemText2.innerHTML = "0";
			listItemText2.className = "want to visit count"
			listItemText2.setAttribute("style","text-align:center;");
			//text 3, child of child div 2
			var listItemText3 = document.createElement("p");
			listItemChildDiv2.appendChild(listItemText3);
			listItemText3.innerHTML = "Visited";
			listItemText3.setAttribute("style","text-align:center;");
			//text 4, child of child div 2
			var listItemText4 = document.createElement("p");
			listItemChildDiv2.appendChild(listItemText4);
			listItemText4.innerHTML = "0";
			listItemText4.className = "visited count"
			listItemText4.setAttribute("style","text-align:center;");
		}
	}
	if(countries.length%2 == 1){
		var emptyItem = document.createElement("div");
		list.appendChild(emptyItem);
		emptyItem.setAttribute("id",country);
		emptyItem.className = "listItem";
		emptyItem.setAttribute("style","padding:10px;margin:10px;flex:1;");
	}
	for(var i=0;i<locations.length;i++){
		var box = document.getElementById(locations[i][0].split(", ")[locations[i][0].split(", ").length-1]);
		var text = box.getElementsByClassName(locations[i][1] + " count")[0];
		text.innerHTML = parseInt(text.innerHTML) + 1;
	}
}