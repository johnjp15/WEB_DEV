function bodyClick(evt)    {
	evt = evt || Event;
	var element = evt.target || evt.srcElement;
	var info = "Properties: \n";
	for(var x in element) {
		if(element[x] != null)    {
			var type = typeof(element[x]);
			var value = element[x];
			if(type == "function")    {continue;}
			if(value != null && value != undefined && value != "")  { 
				var valuename = value.toString().trim();
				//alert(vn);
				var prop = valuename.match(/<.*>/gm);
				//info += type + ": " + value + "\n";
				if(prop == null)  {continue;}
				else  {
					//alert(prop);

					var htmlstring = prop.toString().trim();
					htmlstring = htmlstring.substring(1, htmlstring.indexOf(">"));
					//alert("matchedstring: " + htmlstring);

					//var idvalue = matchedstring.match(/\w*\s*=\s*"[^"=]*"/gm);
					//var arr = matchedstring.split(" ");
					var arr = htmlstring.match(/\w*\s*=\s*"[^"=]*"/gm);

					if(arr == null)   {
						info = "No non-default properties.";
					} else    {

						for(j = 0; j < arr.length; j++)   {
							var indexOfEqualSign = arr[j].indexOf("=");
							var id = arr[j].substring(0, indexOfEqualSign);
							var val = arr[j].substring(indexOfEqualSign+1, arr[j].length);
							info += id + " = " + val + "\n";
							//alert("ID: " + id + "\nValue: " + val);
						}
					}
					break;
				}
			//info += type + " = " + value + "\n";
		}
	}
	//info += type + value + "\n";
}
alert("Smallest element: " + element.nodeName + "\n\n" + info);
}