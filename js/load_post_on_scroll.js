$(document).ready(function(){
    //var flag=true;
        
        $("#loadMore").focus(function(){
          
          var offsetVal=$.trim($("#offset").val());
          var tid=$.trim($("#tid").val());
          //alert(tid);
          var offset=parseInt(offsetVal)+14;
          $("#loadMore").val("Loading...");
          
  
          $.ajax({
  
            type:"POST",
            url:"./news-category.php",
            data:{offset:offset,tid:tid},
            success:function(output)
            {
              var data=[];
              if($.trim(output)!="Not Found"){
                data=JSON.parse(output);
              } 
              
               //flag=false;
               var postAllContent="";
               var count=1;
               if($.trim(data)!="")
               {
                
                for(var i=0;i<data.length;i++)
                  {
                    
                    var description=data[i]['description'];
                    description=description.substring(0,100);
                    var finalDate="";
                    if(data[i]['created_on']!="")
                    {
                      var date=data[i]['created_on'].split("-");
                      // var month = {1:"Jan", 2:"Feb", 3:"Mar", 4 : "Apr", 5 : "May", 6 :"Jun", 7 : "Jul", 8 : "Aug", 9 : "Sep", 10 : "Oct", 11 : "Nov", 12 : "Dec"};

                      switch (date[1]) { 
                        case '01': 
                          submonth="Jan";
                          break;
                        case '02': 
                          submonth="Feb";
                          break;
                        case '03': 
                          submonth="Mar";
                          break;  
                        case '04': 
                          submonth="Apr";
                          break;
                        case '05': 
                          submonth="May";
                          break;
                        case '06': 
                          submonth="Jun";
                          break;
                        case '07': 
                          submonth="Jul";
                          break;  
                        case '08': 
                          submonth="Aug";
                          break;
                        case '09': 
                          submonth="Sep";
                          break;
                        case '10': 
                          submonth="Oct";
                          break;
                        case '11': 
                          submonth="Nov";
                          break;  
                        case '12': 
                          submonth="Dec";
                          break;
                        default:
                          submonth="";
                      }
                    
                      finalDate=date[2]+" "+submonth+" "+date[0];
                      }
                    
                    var postContent = "<li> <div class=\"post--item post--title-larger\"> <div class=\"row\"> <div class=\"col-md-4 col-sm-12 col-xs-4 col-xxs-12\">  <div class=\"post--img\">  <a href=\"details-"+data[i]['enc_id']+"\"  class=\"thumb\"><img src=\"./post_images/"+data[i]['post_image']+"\" alt=\"\" ></a> </div></div><div class=\"col-md-8 col-sm-12 col-xs-8 col-xxs-12\"> <div class=\"post--info\"> <ul class=\"nav meta\"> <li><a href=\"#\">"+data[i]['author']+"</a></li><li><a href=\"#\">"+finalDate+"</a></li></ul> <div class=\"title\"> <h3 class=\"h4\"><a href=\"details-"+data[i]['enc_id']+"\" class=\"btn-link\">"+data[i]['title']+".</a></h3> </div></div><div class=\"post--content\"> <p>"+description+"...</p></div></div></div></div></li>";
                    postAllContent=postAllContent+postContent;
                  }
                  $("#postContent").append(postAllContent);
                  $("#offset").val(offset);
                  $("#loadMore").val("Load more");
               }

               
               if(data.length<10)
               {
               
                 $("#loadMore").hide();
               }
              
            },
            error:function(exception)
            {
    
            }
           });
      });
      
     });