$( document ).ready( function() {
    var canvas = document.getElementById("uploaded-img");
    var context = canvas.getContext("2d");
    var scale = 1.5;
    var originx = 0;
    var originy = 0;
    var imageObj = new Image(); 
    imageObj.src = localStorage.getItem('srcImg');
    function draw(){
        // From: http://goo.gl/jypct
        // Store the current transformation matrix
        context.save();
        
      
        
        // Restore the transform
        context.restore();
        
        // Draw on transformed context    
        // context.drawImage(imageObj, 0, 0, 300, 300);
    
    }
    setInterval(draw,100);
    
    canvas.onmousewheel = function (event){
        var mousex = event.clientX - canvas.offsetLeft;
        var mousey = event.clientY - canvas.offsetTop;
        var wheel = event.wheelDelta/120;//n or -n
    
    
        //according to Chris comment
        var zoom = Math.pow(1 + Math.abs(wheel)/2 , wheel > 0 ? 1 : -1);
    
        context.translate(
            originx,
            originy
        );
        context.scale(zoom,zoom);
        context.translate(
            -( mousex / scale + originx - mousex / ( scale * zoom ) ),
            -( mousey / scale + originy - mousey / ( scale * zoom ) )
        );
    
        originx = ( mousex / scale + originx - mousex / ( scale * zoom ) );
        originy = ( mousey / scale + originy - mousey / ( scale * zoom ) );
        scale *= zoom;
    }
    
    } );