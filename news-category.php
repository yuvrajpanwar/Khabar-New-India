<?php
require_once("./classes/connect_pdo_emp.php");
require_once("./classes/utils.php");
$redirectPath_site=path();
$pdoConnect=new connect_pdo();
$db=$pdoConnect->connectToDB();
require_once("./models/common_db.php");
// $breakingNews=breaking_news_list($db);
$categoryList=category_listing($db);
$sliderContent=slider_content($db);
$popularContent=get_popular_post($db);
$videoPostContent=video_post_content($db);
$tid=isset($_REQUEST['tid'])?base64_decode($_REQUEST['tid']):0;

$categoryList=category_listing($db);
$sliderContent=slider_content($db);
$offset=0;
$limit=14;
$count=1;
$postContent=post_content($db,$tid,$offset,$limit);
$postDetails="";
$categoryName="";
if(count($categoryList)>0)
{
	foreach($categoryList as $key=>$value)
	{
		if($value['id']==$tid)
		{
			$categoryName=$value['name'];
            break;
		}
	}
}
if(count($postContent)>0)
{
	foreach($postContent as $key=>$value)
	{
		$img=$value['post_image'];
		$title=strip_tags($value['title']);
		
		$id=base64_encode($value['id']);
		$date=date("d M Y",strtotime($value['created_on']));
		$author=$value['author'];
		$description=strip_tags($value['description']);
		if($description!="")
		{
			$description=format_description($description,$numberOfWords=20);
				
		}

        $postDetails.= "<li> 
        <div class=\"post--item post--title-larger\"> 
          <div class=\"row\"> 
            <div class=\"col-md-4 col-sm-12 col-xs-4 col-xxs-12\"> 
              <div class=\"post--img\"> 
                <a href=\"details-$id\" class=\"thumb\">
                <img src=\"./post_images/$img\" alt=\"\" >
                </a> 
                 
              </div>
            </div>
            <div class=\"col-md-8 col-sm-12 col-xs-8 col-xxs-12\"> 
              <div class=\"post--info\"> 
                <ul class=\"nav meta\"> 
                  <li>
                    <a href=\"#\">$author
                    </a>
                  </li>
                  <li>
                    <a href=\"#\">$date
                    </a>
                  </li>
                </ul> 
                <div class=\"title\"> 
                  <h3 class=\"h4\">
                    <a href=\"details-$id\" class=\"btn-link\">$title.
                    </a>
                  </h3> 
                </div>
              </div>
              <div class=\"post--content\"> 
                <p>$description...
                </p>
              </div>
              
            </div>
          </div>
        </div>
      </li>";

        $count++;
	}
}

if(isset($_POST['offset']))
{
	$offset=$_POST['offset'];
	$tid=$_POST['tid'];
    // echo $tid;
    // die();
	$limit=14;
	$getNextRecords=post_content($db,$tid,$offset,$limit);
    // print_r($getNextRecords);
    // die();

	$getNextRecord=json_encode($getNextRecords);

    
	
	if(count($getNextRecords)>0)
	{
	echo $getNextRecord;
	die();
	}
    else
    { 
        echo "Not Found";
        die();

    }

}
  
 ?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head> 
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Khabar New India- सोच ईमानदार, खबर दमदार </title> 
     
    <?php include("includes/commonCss.php");?>
  </head>
  <body class="boxed" data-bg-img="img/bg-pattern.png"> 
    <?php include("includes/commonHeader.php");?>  
        
      <div class="main-content--section pbottom--30"> 
        <div class="container"> 
          <div class="row"> 
            <div class="main--content col-md-8 col-sm-7" data-sticky-content="true"> 
            <h3 class=""><?=$categoryName?></h3>
            <hr/>

              <div class="sticky-content-inner"> 
                <div class="post--items post--items-5 pd--30-0"> 
                  <ul class="nav" id="postContent"> 
                    <?=$postDetails?>  
                  </ul> 
                  
                </div>
                
                <div class="pagination--wrapper clearfix bdtop--1 bd--color-2 ptop--60 pbottom--30"> 
                 
                  <div class="col-lg-9 t-mb-30 mb-lg-0">
					         <center><input type="button" id="loadMore" value="Load more" class="btn btn-primary"></center>
					        </div>
				
				         <input type="hidden" id="offset" name="offset" value="<?=$offset?>">
				         <input type="hidden" id="tid" name="tid" value="<?=$tid?>">
                </div>
              </div>
            </div>
            <?php include("includes/commonSidebarTop.php");?>
            </div>
          </div>
        </div>
      </div>
      <div id="backToTop"> <a href="#"><i class="fa fa-angle-double-up"></i></a> </div>
      <?php include("includes/commonFooter.php");?>
       
    </div>
    
    <?php include("includes/commonJs.php");?>
  </body>
</html>
