//<!--Created by John Park | Dr. Gabor's Web App Development class | 10/26/2014-->

//var borderedE = [];

function findInnerElement(startE, i, coord)   {
    var onlyElementChilds = [];
    for(i = 0; i < startE.childNodes.length; i++)   {
        if(startE.childNodes[i].nodeType == 1)  {
            onlyElementChilds.push(startE.childNodes[i]);
        }
    }
    if(onlyElementChilds.length == 0)    {
        return {"E":startE, "iteration":i};
    }
    //beyond this point, startE has children nodes OF ELEMENT TYPES
    var inners = [];
    for(i = 0; i < onlyElementChilds.length; i++)   {
        inners.push(findInnerElement(onlyElementChilds[i], i + 1, coord));
    }
    //array inners should have the inner elements of each of startE's child nodes
    //now compare the iteration values of each child node
    var maxIteration = 0;
    var maxEpair;
    for(j = 0; j < inners.length; j++)  {
        if(inners[j].iteration > maxIteration)  {
            maxIteration = inners[j].iteration;
            maxEpair = inners[j];
        }
    }
    //the max E, iteration pair should now be found

    return maxEpair;
}

function getInnermostE(startE, coord)  {
    var pair = findInnerElement(startE, 0, coord);
    return pair.E;
}

//nonworking function, DO NOT USE; WORK-IN-PROGRESS
function borderElement(element)   {
    for(i = 0; i < borderedE.length; i++)   {
        borderedE[i].style.border = "";
    }
    
    element.style = "border: 2px solid blue";
    
    borderedE = [];
    borderedE.push(element);
}

//DEFAULT ONCLICK FUNCTION, usage: <body onclick="innerElement(event);">
function innerElement(evt) {
    evt = evt || Event;
    var startelement = evt.target;
    
    var coord = {"x":event.clientX, "y":event.clientY};
    
    var innermostChild = getInnermostE(startelement, coord);
    
    //borderElement(innermostChild);
    
    var info = "Attributes: \n";
    var att = innermostChild.attributes;
    
    for(i = 0; i < att.length; i++)   {
        info += att[i].name + " = " + att[i].value + "\n";
    }
    if(att.length == 0) {
        info += "No non-default attributes."
    }
    
    alert("Smallest element: " + innermostChild.nodeName + "\n\n" + info);
}