/*
 *  Canvas Lab;
 *  John Park;
 *  Dr. Gabor's Web Application Development class
 *  11/12/14
*/


function resizeCanvas() {
    var divContainer = document.getElementById("canvas_container");
    var cs = getComputedStyle(divContainer);
    var cssWidth = parseInt(cs.getPropertyValue('width'), 10);
    var cssHeight = parseInt(cs.getPropertyValue('height'), 10);
    
    canvas.width = cssWidth;
    canvas.height = cssHeight - 4;
}

function loadGrid(xMin, xMax, xScl, yMin, yMax, yScl)   {
    //for now, assume axis1 and axis2 equal "x" and "y", arguments are in place for potential 3D
    
    
    var intervalX = canvas.width / ((xMax - xMin) / xScl);
    var intervalY = canvas.height / ((yMax - yMin) / yScl);
    //code below graphs xy plane

    //draw vertical lines, y = constant
    for(x = intervalX; x < (canvas.width); x += intervalX) {
        cdraw.moveTo(x, 0);
        cdraw.lineTo(x, canvas.height);
        cdraw.stroke();
    }
    
    //draw horizontal lines, x = constant
    for(y = intervalY; y < (canvas.height); y += intervalY) {
        cdraw.moveTo(0, y);
        cdraw.lineTo(canvas.width, y);
        cdraw.stroke();
    }
}

/////////////////////////////////////////

function recalculateVars()  {
    xRange = xMax - xMin;
    yRange = yMax - yMin;
    xScale = canvas.width / xRange;
    yScale = canvas.height / yRange;
    
    this.xCenter = Math.round(Math.abs(this.xMin / this.xRange) * this.canvas.width);
    this.yCenter = Math.round(Math.abs(this.yMin / this.yRange) * this.canvas.height);
    
    increment = (this.xMax - this.xMin) / 1000;
}

function setWindow(xMin, xMax, xScl, yMin, yMax, yScl)  {
    loadGrid(xMin, xMax, xScl, yMin, yMax, yScl);
}

function graphFunction(equation)    {//funcString)  {
    cdraw.save();
    cdraw.save();
//    this.transformContext();
    cdraw.translate(this.xCenter, this.yCenter);
    cdraw.scale(xScale, yScale);
    
    cdraw.beginPath();
    cdraw.moveTo(this.xMin, equation(this.xMin));
    
    for(x = this.xMin; x <= this.xMax; x += this.increment) {
        cdraw.lineTo(x, equation(x));
    }
    
    cdraw.restore();
    cdraw.lineJoin = 'round';
    cdraw.lineWidth = 3;
    cdraw.strokeStyle = 'blue';
    cdraw.stroke();
    cdraw.restore();
}


/////////////////////////////////////////

function update()   {
//    alert("update() is called");
    //everytime canvas width or height is changed, canvas is reset.
    recalculateVars();
    resizeCanvas();
    loadGrid(xMin, xMax, xScl, yMin, yMax, yScl);//defaults.xMin, defaults.xMax, defaults.xScl, defaults.yMin, defaults.yMax, defaults.yScl);
    //redraw functions
    this.graphFunction(function(x)  {return x * x;});
    this.graphFunction(function(x)  {return -1 * x * x;});
    this.graphFunction(function(x)  {return 1 / x;});
    this.graphFunction(function(x)  {return -1 * x * Math.sin(x);});
}

//continuously calls function update() to update the canvas graphics at a time interval time_interval
function runUpdater(time_interval)   {
    window.setInterval(function()   {update();}, time_interval);
}

function startProgram() {
    canvas = document.getElementById("canvas_graph");
    cdraw = canvas.getContext("2d");
    
    /*
    //SET CANVAS WIDTH AND HEIGHT TO ITS CSS WIDTH AND HEIGHT
    var divContainer = document.getElementById("canvas_container");
    var cs = getComputedStyle(divContainer);
    var cssWidth = parseInt(cs.getPropertyValue('width'), 10);
    var cssHeight = parseInt(cs.getPropertyValue('height'), 10);
    
//    alert("cssWidth: " + cssWidth + "\ncssHeight: " + cssHeight);
    //from http://stackoverflow.com/questions/18679414/how-put-percentage-width-into-html-canvas-no-css
                
    canvas.width = cssWidth;
    canvas.height = cssHeight;
    ///////////////////////////////////
    */
//    resizeCanvas();
    
//    resizeCanvas();
    
    
//    defaults = {"xMin":-15, "xMax":15, "xScl":1, "yMin":-10, "yMax":10, "yScl":1};
    
//    windowVars = {"xMin":null, "xMax":null, "xScl":null, "yMin":null, "yMax":null, "yScl":null};
    xMin = -10;
    xMax = 10;
    xScl = 1;
    yMin = -10;
    yMax = 10;
    yScl = 1;
    
    xRange = xMax - xMin;
    yRange = yMax - yMin;
    xScale = canvas.width / xRange;
    yScale = canvas.height / yRange;
    
    this.xCenter = Math.round(Math.abs(this.xMin / this.xRange) * this.canvas.width);
    this.yCenter = Math.round(Math.abs(this.yMin / this.yRange) * this.canvas.height);
    
    increment = (this.xMax - this.xMin) / 1000;
    ///////////////////
//    /////////////cdraw.lineWidth = 1;
    
//    cdraw.translate(0.5, 0.5);
//    alert("Width: " + canvas.width + "\nHeight: " + canvas.height);
    
//    cdraw.fillRect(0,0,100,200);
    /////////////loadGrid(defaults.xMin, defaults.xMax, defaults.xScl, defaults.yMin, defaults.yMax, defaults.yScl);
    
    runUpdater(1);
    
    this.graphFunction(function(x)  {return x * x;});
    this.graphFunction(function(x)  {return x * Math.sin(x);});
}