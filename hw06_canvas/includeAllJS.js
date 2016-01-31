//this javascript file will automatically include all *.js files in the /js/ folder
//http://stackoverflow.com/questions/387707/whats-the-best-way-to-define-a-class-in-javascript
//http://www.phpied.com/3-ways-to-define-a-javascript-class/
//http://stackoverflow.com/questions/2145914/including-a-js-file-within-a-js-file
//http://stackoverflow.com/questions/3809862/can-we-call-the-function-written-in-one-javascript-in-another-js-file

//import all classes first here
var a = document.createElement('script');
a.src = 'js/f.js';
document.getElementsByTagName("head")[0].appendChild(a);

//import all other js files here
var b = document.createElement('script');
b.src = 'js/canvas.js';
document.getElementsByTagName("head")[0].appendChild(b);