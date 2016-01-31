function smallE(evt)    {
    evt = evt || Event;
    var element = evt.target || evt.srcElement;
    var info = "Properties: \n";
    for(var x in element) {
        if(element[x] != null)    {
            var type = typeof(element[x]);
            var value = element[x];
            if(type == "function")    {continue;}
            if(value != null && value != undefined && value != "" && x.toString() != x.toString().toUpperCase())  { 
                var valuename = value.toString().trim();
                //alert(vn);
                info += x + "[" + type + "]" + " = " + valuename + "\n";      
            }
        }
    }
    alert("Smallest element: " + element.nodeName + "\n\n" + info);
}