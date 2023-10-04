<?php
require_once("./classes/connect_pdo_emp.php");
require_once("./classes/utils.php");
$redirectPath_site=path();
$pdoConnect=new connect_pdo();
$db=$pdoConnect->connectToDB();
require_once("./models/common_db.php");

$tid=isset($_REQUEST['tid'])?base64_decode($_REQUEST['tid']):0;
// $breakingNews=breaking_news_list($db);
$popularContent=get_popular_post($db);
$videoPostContent=video_post_content($db);
$categoryList=category_listing($db);
$sliderContent=slider_content($db);


// echo $tid;
// die();
$countRecord=get_news_count($db,$tid);
// print_r($countRecord);
// die();
$newsCount="";
if($countRecord){
  
	$newsCount=$countRecord['counts'];
	$newsId=$countRecord['id'];
	$newsCount++;
	update_count($db,$newsCount,$newsId);
}

if($tid>0)
{
  
	$getPostDetails=get_post_details($db,$tid);
	$postTitle=$getPostDetails['title'];
	$title_for_meta=strip_tags($postTitle);
	$slug_Title=str_replace(" ","_",$getPostDetails['slug_title']);
	$postDescription=$getPostDetails['description'];
	$replace_tag_description=strip_tags($postDescription);
  $data=format_description($replace_tag_description,10);
  $description_for_meta=strip_tags($data);

	$postAuthor=$getPostDetails['author'];
	$postDate=date("d M Y",strtotime($getPostDetails['created_on']));
  $postImage=$getPostDetails['post_image'];
	$image_path="$redirectPath_site/"."post_images/$postImage";
	$full_path="$redirectPath_site/"."post_images/$postImage";
	$meta_url="$redirectPath_site"."/details-".base64_encode($tid);
	$sel_seo_details=$db->query("select * from khabarnewindia_post_seo_details where post_id='$tid' limit 1");
  $sel_post_details=$db->query("select * from khabarnewindia_post_records where id='$tid' limit 1");
  $fetch_post_details=$sel_post_details->fetch(PDO::FETCH_ASSOC);
 
  $description=$fetch_post_details['description'];
  $tags=$fetch_post_details['tag_line'];
  
	$meta_description=strip_tags($description);

    $num_seo_details=$sel_seo_details->rowCount();
    
    if($num_seo_details)
    {
        $fetch_seo_details=$sel_seo_details->fetch(PDO::FETCH_ASSOC);

        $meta_title=$fetch_seo_details['seo_title'];

        
        $seo_keywords=$fetch_seo_details['meta_keywords'];
    }
    else
    {
        $meta_title=$title_for_meta;

        $meta_discription=$description_for_meta;
        $seo_keywords="";
    }
}
 
$prevPostId=$tid-1;

if($prevPostId>0)
{
	$getPrevPostDetails=get_post_details($db,$prevPostId);		 
}

$nextPostId=$tid+1;
if($nextPostId>0)
{
	$getNextPostDetails=get_post_details($db,$nextPostId);

}

?>


<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head> 
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta property="og:title" content="<?=$title_for_meta?>"/>
    <meta name="description" content="<?=$meta_description?>">
    <meta name="keywords" content="<?=$seo_keywords?>"/>
    <meta property="og:url" content="<?=$meta_url?>" />
    <meta property="og:image" content="<?=$full_path?>"/>
    <meta property="og:type" content="article" />
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Khabar New India - सोच ईमानदार, खबर दमदार </title> 
    <meta charset="UTF-8">
    
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
   <?php include("includes/commonCss.php");?>

   <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=620e35344d759f0019eaa6d2&product=inline-share-buttons' async='async'></script>
   <style>
     @media screen and (max-width: 992px) {
      .post--item.post--title-largest .post--info .title .h4{

       font-size:25px;

      }
     @media screen and (max-width: 600px) {
      .post--item.post--title-largest .post--info .title .h4{

        font-size:25px;

      }
     }

    }
   </style>
  </head>
  <body class="boxed" data-bg-img="img/bg-pattern.png"> 
    <?php include("includes/commonHeader.php");?>      
  
      <div class="main-content--section pbottom--30"> 
        <div class="container"> 
          <div class="row"> 
            <div class="main--content col-md-8" data-sticky-content="true"> 
              <div class="sticky-content-inner"> 
                <div class="post--item post--single post--title-largest pd--30-0">
                    
                <div class="post--info"> 
                    
                    <div class="title"> 
                      <h2 class="h4"><?=$postTitle?>
                      </h2> 
                    </div>
                  </div>
                  <div class="post--img"> 
                    <a href="#" class="thumb">
                    <img class="img-fluid" src="./post_images/<?=$postImage?>">
                    </a> 
                    <a href="#" class="icon">
                      <i class="fa fa-star-o">
                      </i>
                    </a> 
                   
                  </div>
                  <div class="post--info"><b>
                  <ul class="nav meta"> 
                      <li>
                        <a href="#"><?=$postAuthor?>
                        </a>
                      </li>
                      <li>
                        <a href="#"><?=$postDate?>
                        </a>
                      </li>
                    <li>
                      <a href="#"> 
                        <i class="fa fa-eye" aria-hidden="true" style= "letter-spacing: 7px"></i><?=$newsCount?></a>
  </li> 
                      <!-- <li>
                        <span>
                          
                          <?=$tags?>
                        </span>
                      </li> -->
                      
                    </ul> 
  </b> </div>
                  <div class="post--content"><b> 
                    <p><?=$postDescription?>
                    </p>
                    <p style="background-color:yellow"><?=$tags?></p>
                    
  </b> </div>

                  
             
                  <div class="social-share-wrap">
										<span class="fz-16 text-black fw-6">Share</span>
									  
										<div class="sharethis-inline-share-buttons"></div>
									</div>
                </div>
                
                <!-- Previous & Next Post Start -->
                <div class="post--nav">
                  <ul class="nav row">

                    <?php  
                      if($getPrevPostDetails!="")
                      {
                        ?>
                    <li class="col-xs-6 ptop--30 pbottom--30">
                      <div class="post--item">
                      <a href="details-<?=base64_encode($prevPostId)?>"><span><i class="fa fa-angle-left"></i><b>Previous Post</b></span><br><?=$getPrevPostDetails['title']?><br></a>
                      </div>
                    </li>
                    <?php
                      }
                      ?>
                      
                      <?php  
                      if($getNextPostDetails!="")
                      {
                        ?>
                    <li class="col-xs-6 ptop--30 pbottom--30">
                      <div class="post--item">
                      <a href="details-<?=base64_encode($nextPostId)?>"><span><b>Next Post</b><i class="fa fa-angle-right"></i></span><br><?=$getNextPostDetails['title']?></a>
                      </div>
                    </li>
                    <?php

                    }

                    ?>
                  </ul>
                </div>
               </div>
            </div>
            <div id="backToTop"> <a href="#"><i class="fa fa-angle-double-up"></i></a> </div>
            <?php include("includes/commonSidebarTop.php");?>
         
          </div>
        </div>
      </div>
      
    <?php include("includes/commonFooter.php");?>
    <?php include("includes/commonJs.php");?>
    
  </body>
</html>
