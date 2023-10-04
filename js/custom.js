$('.sliderImg').carouselLineArrow({

    heightIsProportional:false
    
    });
    
    function stopVideo(){
        
      document.querySelectorAll('iframe').forEach(v => { v.src = v.src });
      document.querySelectorAll('video').forEach(v => { v.pause() });
    
    }
    $("#1").show();
    $("#2").hide();
    $("#3").hide();
    
    
    $.fn.myFunction = function(){ 
      $("#1").hide();
      $("#2").hide();
      $("#3").hide();      
    }
    
    $("#A1").click(function(){
        stopVideo();
        $.fn.myFunction();
        
        $("#1").show();
        
    });
    
    $("#A2").click(function(){
        stopVideo();
        $.fn.myFunction();
        
        $("#2").show();
        
    });
    
    $("#A3").click(function(){
        stopVideo();
        $.fn.myFunction();
        
        $("#3").show();
    
    });
    