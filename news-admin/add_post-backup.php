<?php
session_start();  
require_once('../classes/utils.php');
require_once('../classes/connect_pdo_emp.php');
require_once('../classes/access_stats_emp.php');
date_default_timezone_set('Asia/Kolkata');
include("resizecode.php");
$redirectPath_site=path();
if(isLoginSessionExpired()) {

    header("Location: $redirectPath_site/news-admin/index.php?route=102");
}
$privilege = '0';
$nav = new access_stats($privilege);
set_timezone();
$pdoConnect = new connect_pdo();
$db = $pdoConnect->connectToDB();
$redirectPath_site=path();
$validate_message="";
$title="";
$sl_title="";
$ctaegory_id="";
$tag_id="";
$description="";
$author=$_SESSION['admin_name'];
$post_image="";
$created_on="";
$type="";
$link="";

$category_array=[];
$full_img_path="";
$vdType = "Youtube";
$content = "";
$seo_title="";
$seo_discription="";
$seo_keywords="";

$validationMsg=isset($_REQUEST['msg'])?base64_decode($_REQUEST['msg']):"";

//$selectQuery=$db->prepare("select author from newsx_post_records where id=max(id)");
$selectQuery = $db->prepare("select author from khabarnewindia_post_records order by id desc limit 1");
$selectQuery->execute();
$resultArray=$selectQuery ->fetch(\PDO::FETCH_ASSOC);

if(count($resultArray)>0)
{
$author=$resultArray['author'];
}


			
  try
	{
		
		$adminid = $_SESSION['uID'];
		$todayNow = date('Y-m-d H:i:s');
		$todayDate = date('Y-m-d');
		$adminemail = $_SESSION['admin_email'];
		$adminname = $_SESSION['admin_name'];
		$now = 'NOW()';
		$val="";
		$empID = $_SESSION['uID'];
		$prepQuery = $db->query("select * from khabarnewindia_adminlogin where id='$adminid' and user_name='$adminemail' and name='$adminname' limit 1");
	    $complete_rows = $prepQuery->rowCount();
		
		if($complete_rows<=0)
	    {
			header("Location: index.php");die();
		
		}
		if(isset($_POST['submit']) == 'Save')
		{
            // print_r($_POST);die();
			
			$name=$_POST['title'];
			$news_type=$_POST["news_type"];
			$catgeory_id=$_POST['catgeory_id'];
			$writer=$_POST['writer'];
			$slug_title=trim($_POST['slug_title']);
			$tag_id=(isset($_POST['tag_id']))?$_POST['tag_id']:"";
			$tag_name=$_POST['tag_name'];
			
			/*
			$meta_title=$_POST['seo_title'];
			$meta_discription=$_POST['meta_discription'];
			$meta_keywords=$_POST['meta_keywords'];*/
            
            $meta_title="";
			$meta_discription="";
			$meta_keywords="";
			
			if($name=="")
			{
				$validate_message="<div class='alert alert-error alert-dismissible fade in'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
									 Please Provide Title.
								</div>";
			}
			else if($news_type=="")
			{
				$validate_message="<div class='alert alert-error alert-dismissible fade in'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
									 Please Select News Type.
								</div>";
			}
			else if($catgeory_id=="")
			{
				
				$validate_message="<div class='alert alert-error alert-dismissible fade in'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
									 Please Select Category.
								</div>";
			}
			else if($writer=="")
			{
				
				$validate_message="<div class='alert alert-error alert-dismissible fade in'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
									 Please Provide Author Name.
								</div>";
			}
			else
			{
                
               
				
				if($news_type=="Text News" || isset($_POST['video_check']))
				{
					
					$content=$_POST['editor1'];
					$video_link="";
					if($content=="")
					{
						$validate_message="<div class='alert alert-error alert-dismissible fade in'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
									 Please Provide News Content.
								</div>";
					}						
				}
              
				else if($news_type=="Video News" || isset($_POST['video_check']))
				{
					
					
					$video_type=$_POST['video_type'];
					
					$video_link="";

					if($video_type=="other") {
							
					  $valid_formats = array("mp4","avi","mov","3gp","mpeg");

					  
						if($_FILES["video_upload"]["name"])
						{
							
							$orgfilename = $_FILES["video_upload"]["name"];
							 // echo $orgfilename;die();
							$tmp_filename = $_FILES["video_upload"]["tmp_name"];
							
							$temp=pathinfo($orgfilename);
							
							if(!empty($orgfilename))
							{
								$get_file_extension = strtolower($temp['extension']);
								
								if(in_array($get_file_extension, $valid_formats))
								{
									
									$file_info = filesize($_FILES['video_upload']['tmp_name']);
									if(empty($file_info)) // No Image?
									{
										$errmsg = base64_encode("ferror");
										header("location:add_post.php?msg=$errmsg");die();
									}
									else
									{
										$orgfilename = preg_replace('/[[:space:]]+/', '-', $orgfilename);
										$destinpath = "../post_video/$orgfilename";
										move_uploaded_file($tmp_filename, $destinpath);
										
										$video_link=$redirectPath_site."/post_video/".$orgfilename;
									}
									
									
								}
								else
								{
									$errmsg = base64_encode("error");
									header("location:add_post.php?msg=$errmsg");die();
									
								}
							}
						}
						
					}
					else {
						$video_link=$_POST['video_link'];
					}
					
					if($video_link=="")
					{
						$validate_message="<div class='alert alert-error alert-dismissible fade in'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
									 Please Provide Video Link.
								</div>";
					}
											
				}
			
				
					function adms_regid()
					{
						$genid="";
						for($i=0; $i<6; $i++)
						{
							$d=rand(1,30)%2; 
							$d=$d ? chr(rand(65,90)) : chr(rand(48,57));
							$genid=$genid.$d;
						}
						
						return $genid;
					}
					
					$row_id=adms_regid();
					
					$valid_formats = array("jpg","jpeg","JPG","JPEG","png", "PNG");
					if($_FILES["post_img"]["name"])
					{
						$orgfilename = $_FILES["post_img"]["name"];
						// echo $orgfilename;die();
						$tmp_filename = $_FILES["post_img"]["tmp_name"];
						$temp=pathinfo($orgfilename);
						if(!empty($orgfilename))
						{
							$get_file_extension = strtolower($temp['extension']);
							if(in_array($get_file_extension, $valid_formats))
							{
								$file_info = getimagesize($_FILES['post_img']['tmp_name']);
								if(empty($file_info)) // No Image?
								{
									$errmsg = base64_encode("Please provide valid image.");
									header("location:add_post.php?msg=$errmsg");die();
								}
								else
								{
									$destinpath = "../post_images/$orgfilename";
									move_uploaded_file($tmp_filename, $destinpath);
									// echo $result;die();
									$modwidth = 800;
									$modheight = 450;
									$image=new resizecode();
									$image->load($destinpath);
									$image->resizeTowidth($modwidth);
									$image->resizeToHeight($modheight);
									$url = '../post_images/'.$row_id.".jpg";
									$image_name=$row_id.".jpg";
									$image->save($url);
									
									if(file_exists($destinpath))
									{
										unlink($destinpath);
									}
								}
								
								
							}
							else
							{
								$errmsg = base64_encode("error");
								header("location:add_post.php?msg=$errmsg");die();
								
							}
						}
					}
					else
					{
						$image_name="";
					}
								
				
				if($validate_message=="")
				{
					
					
					 
                    
					if($tag_id)
					{
						$sel_tag=$db->query("select * from khabarnewindia_tags_details where id='$tag_id'");
						$fetch_tag=$sel_tag->fetch(PDO::FETCH_ASSOC);
						$old_tag_name=$fetch_tag['tag_name'];
						
						$tag_content=$tag_name.",".$old_tag_name;
					}
					else
					{
						$tag_content=$tag_name;
					}
                    
                   

					if($tag_name)
					{
						$tag_array=explode(",",$tag_name);
						
                       
						foreach($tag_array as $value)
						{
                            // print_r("select * from tags_details where tag_name='$value'"); die();
                            
							$sel_tag_check=$db->query("select * from khabarnewindia_tags_details where tag_name='$value'");
							
						    $old_tag_name="";
							$tag_rows = $sel_tag_check->rowCount();
                            //print_r($tag_rows); die();
							if(!$tag_rows)
							{
								$insert_tag = $db->prepare("insert into khabarnewindia_tags_details (tag_name,status,created) values (:title,:st,:date)");
					
								$params_tag = array("title" => $value,"st" => 'active',"date" => $todayNow);
								$data_tag = $insert_tag->execute($params_tag);
							}
						}
						
						
						
						$tag_content=$tag_name.",".$old_tag_name;

						
					}	
                    
                     
					
					$insert_query = $db->prepare("insert into khabarnewindia_post_records (title,slug_title,tag_line,description,author,post_image,video_link,news_type,created_on,status,created) values (:title,:slug,:tag,:des,:writer,:img,:link,:type,:date_on,:st,:date)");
					
					$params = array("title" => $name,"slug" => $slug_title,"tag" =>$tag_content,"des" => $content,"writer" => $writer,"img" => $image_name,"link" => $video_link,"type" => $news_type,"date_on" => $todayDate,"st" => 1,"date" => $todayNow);
					$data = $insert_query->execute($params);
					
					$record_id = $db->lastInsertId();

					$randomCount=rand(500, 1000);

					$insert_query_view_records = $db->prepare("insert into khabarnewindia_post_view_records (post_id,counts) values (:postId,:counts)");
					
					$params = array("postId" => $record_id,"counts" => $randomCount);
					$dataRecords = $insert_query_view_records->execute($params);
					
					
					// Insert Post Categories.............................................	
					$totalitem =sizeof($catgeory_id);
					for($j=0;$j<$totalitem;$j++)
					{
						
						$ct_id = $_POST['catgeory_id'][$j];
						$insert_post_category = $db->prepare("insert into khabarnewindia_post_category (post_id,category_id) values (:p_id,:c_id)");
						$params_post_category = array("p_id" => $record_id,"c_id" => $ct_id);
						$data_post_category = $insert_post_category->execute($params_post_category);
						
					}
					
					
					$insert_seo = $db->prepare("insert into khabarnewindia_post_seo_details (post_id,seo_title,meta_description,meta_keywords,created) values (:p_id,:title,:desc,:keywords,:date)");
					
					$params_seo = array("p_id" => $record_id,"title" => $meta_title,"desc" => $meta_discription,"keywords" => $meta_keywords,"date" => $todayNow);
					$data_seo = $insert_seo->execute($params_seo);
					
					$validate_message="
									<div class='alert alert-success alert-dismissible fade in'>
											<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
											Post Add Sucessfully.
										</div>
									";
				}

				
			}
		}
		if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
		{
			
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			$sel_record=$db->query("select * from khabarnewindia_post_records where id='$tid' limit 1");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:post_list.php");die();
			}
			else
			{
				
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				$title=$fetch_record['title'];
				$sl_title=$fetch_record['slug_title'];
				//$ctaegory_id=$fetch_record['category_id'];
				$tag_id=$fetch_record['tag_line'];
				//$category_array=explode(",",$ctaegory_id);
				$type=$fetch_record['news_type'];
				$description=$fetch_record['description'];
				$link=$fetch_record['video_link'];
			
				$author=$fetch_record['author'];
				$post_image=$fetch_record['post_image'];
				$created_on=$fetch_record['created_on'];
				$full_img_path="../post_images/".$post_image;
				
				$sel_seo_details=$db->query("select * from khabarnewindia_post_seo_details where post_id='$tid' limit 1");
				$num_seo_details=$sel_seo_details->rowCount();
				//echo $num_seo_details;die();
				if($num_seo_details)
				{
					$fetch_seo_details=$sel_seo_details->fetch(PDO::FETCH_ASSOC);
					
					$seo_title=$fetch_seo_details['seo_title'];
					
					$seo_discription=$fetch_seo_details['meta_description'];
					$seo_keywords=$fetch_seo_details['meta_keywords'];
				}
				
				$sel_post_category=$db->query("select category_id from khabarnewindia_post_category where post_id='$tid'");
				$fetch_post_category =$sel_post_category->fetchAll(\PDO::FETCH_ASSOC);
				foreach($fetch_post_category as $index => $string) 
				{
					$category_id=$string['category_id'];
					$category_array[]=$category_id;
				}
				
			}	
		}
		
		if(isset($_GET['act']) && base64_decode($_GET['act']) == 'delimg')
		{
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			// echo $tid;die();
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			$sel_record=$db->query("select * from khabarnewindia_post_records where id='$tid'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:post_list.php");die();
			}
			else
			{
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				$image_name=$fetch_record['post_image'];
				
				$full_img_path='../post_images/'.$image_name;
				if(file_exists($full_img_path))
				{
					unlink($full_img_path);
				}
				$update_query = $db->prepare("update khabarnewindia_post_records SET post_image = :url where id = :tid");
				$params = array("url" => '',"tid" => $tid);
				$data = $update_query->execute($params);
				$ed_text=base64_encode("edit");
				header("location:add_post.php?tid=$encode_tid&act=$ed_text");die();
			}
		}
		if(isset($_GET['act']) && base64_decode($_GET['act']) == 'update')
		{
			
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			// echo $tid;die();
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			$sel_record=$db->query("select * from khabarnewindia_post_records where id='$tid'");
			$num_record=$sel_record->rowCount();
			
			if(!$num_record)
			{
				header("location:post_list.php");die();
			}
			else
			{
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				$old_img_name=$fetch_record['post_image'];
				//$old_img_name1=$fetch_record['small_image'];
				
				$created_on=$_POST['created_on'];
				$name=$_POST['title'];
				$news_type=$_POST["news_type"];
				$catgeory_id=$_POST['catgeory_id'];
				$writer=$_POST['writer'];
				$slug_title=trim($_POST['slug_title']);
				$tag_id=$_POST['tag_id'];
				$tag_name=$_POST['tag_name'];
				
                /*
				$meta_title=$_POST['seo_title'];
				$meta_discription=$_POST['meta_discription'];
				$meta_keywords=$_POST['meta_keywords'];
				*/
                
                $meta_title="";
                $meta_discription="";
                $meta_keywords="";
                
				if($name=="")
				{
					$validate_message="<div class='alert alert-error alert-dismissible fade in'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
										 Please Provide Title.
									</div>";
				}
				else if($created_on=="")
				{
					$validate_message="<div class='alert alert-error alert-dismissible fade in'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
										 Please Provide Date.
									</div>";
				}
				else if($catgeory_id=="")
				{
					
					$validate_message="<div class='alert alert-error alert-dismissible fade in'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
										 Please Select Category.
									</div>";
				}
				else if($writer=="")
				{
					
					$validate_message="<div class='alert alert-error alert-dismissible fade in'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
										 Please Provide Author Name.
									</div>";
				}
				else
				{
					if($news_type=="Text News" || isset($_POST['video_check']))
					{
						$content=$_POST['editor1'];
						$video_link="";
						if($content=="")
						{
							$validate_message="<div class='alert alert-error alert-dismissible fade in'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
										 Please Provide News Content.
									</div>";
						}						
					}	
					if($news_type=="Video News" || isset($_POST['video_check']))
					{
						
						$video_type=$_POST['video_type'];
						$video_link="";
						
						if($video_type=="other") {
							$valid_formats = array("mp4","avi","mov","3gp","mpeg");
							if($_FILES["video_upload"]["name"])
							{
								
								$orgfilename = $_FILES["video_upload"]["name"];
								// echo $orgfilename;die();
								$tmp_filename = $_FILES["video_upload"]["tmp_name"];
								$temp=pathinfo($orgfilename);
								if(!empty($orgfilename))
								{
									$get_file_extension = strtolower($temp['extension']);
									
									if(in_array($get_file_extension, $valid_formats))
									{
										
										$file_info = filesize($_FILES['video_upload']['tmp_name']);
										if(empty($file_info)) // No Image?
										{
											$errmsg = base64_encode("ferror");
											header("location:add_post.php?msg=$errmsg");die();
										}
										else
										{
											$orgfilename= preg_replace('/[[:space:]]+/', '-', $orgfilename);
											$destinpath = "../post_video/$orgfilename";
											move_uploaded_file($tmp_filename, $destinpath);
											
											$video_link=$redirectPath_site."/post_video/".$orgfilename;
											$destinpathArr = explode("/post_video/",$video_link_org);
											//echo $video_link_org."--"; print_r($destinpathArr);
											//die();
											unlink("../post_video/".$destinpathArr[1]);
											
										}
										
										
									}
									else
									{
										$errmsg = base64_encode("error");
										header("location:add_post.php?msg=$errmsg");die();
										
									}
								}
							}
						}else {
								$video_link=$_POST['video_link'];
						
							}
						
						$content="";
						
						
						if($video_link=="")
						{
							$validate_message="<div class='alert alert-error alert-dismissible fade in'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>
										 Please Provide Video Link.
									</div>";
						}						
					}

				
					if($news_type=="Text News"||$news_type=="Video News"|| isset($_POST['video_check']))
					{
						$valid_formats = array("jpg","jpeg","JPG","JPEG","png", "PNG");
						if(isset($_FILES["post_img"]["name"]))
						{
							function adms_regid()
							{
								$genid="";
								for($i=0; $i<6; $i++)
								{
									$d=rand(1,30)%2; 
									$d=$d ? chr(rand(65,90)) : chr(rand(48,57));
									$genid=$genid.$d;
								}
								
								return $genid;
							}
							
							$row_id=adms_regid();
							
							$orgfilename = $_FILES["post_img"]["name"];
							// echo $orgfilename;die();
							$tmp_filename = $_FILES["post_img"]["tmp_name"];
							$temp=pathinfo($orgfilename);
							if(!empty($orgfilename))
							{
								$get_file_extension = strtolower($temp['extension']);
								if(in_array($get_file_extension, $valid_formats))
								{
									$file_info = getimagesize($_FILES['post_img']['tmp_name']);
									if(empty($file_info)) // No Image?
									{
										$errmsg = base64_encode("Please provide valid image.");
										//header("location:add_post.php?msg=$errmsg");die();
										
										$ed_text=base64_encode("edit");
										header("location:add_post.php?tid=$encode_tid&act=$ed_text&msg=$errmsg");die();
									}
									else
									{
										$destinpath = "../post_images/$orgfilename";
										move_uploaded_file($tmp_filename, $destinpath);
										$modwidth = 800;
										$modheight = 450;
										$image=new resizecode();
										$image->load($destinpath);
										$image->resizeTowidth($modwidth);
										$image->resizeToHeight($modheight);
										$url = '../post_images/'.$row_id.".jpg";
										$image_name=$row_id.".jpg";
										$image->save($url);
										if(file_exists($destinpath))
										{
											unlink($destinpath);
										}
									}
									
									
								}
								else
								{
									$errmsg = base64_encode("error");
									//header("location:add_post.php?msg=$errmsg");die();
									$ed_text=base64_encode("edit");
									header("location:add_post.php?tid=$encode_tid&act=$ed_text&msg=$errmsg");die();
									
								}
							}
						}
						else
						{
							$image_name=$old_img_name;
						}
					}
					else
					{
						$image_name="";
					}
					
					if($validate_message=="")
					{	
						

						if($tag_id)
						{
							$sel_tag=$db->query("select * from khabarnewindia_tags_details where id='$tag_id'");
							$fetch_tag=$sel_tag->fetch(PDO::FETCH_ASSOC);
							$old_tag_name=$fetch_tag['tag_name'];
							
							$tag_content=$tag_name.",".$old_tag_name;
							
						}
						else
						{
							$tag_content=$tag_name;
						}

						if($tag_name)
						{
							$tag_array=explode(",",$tag_name);
							foreach($tag_array as $value)
							{
								$sel_tag_check=$db->query("select * from khabarnewindia_tags_details where tag_name='$value'");
								$tag_rows = $sel_tag_check->rowCount();
								if(!$tag_rows)
								{
									$insert_tag = $db->prepare("insert into khabarnewindia_tags_details (tag_name,status,created) values (:title,:st,:date)");
						
									$params_tag = array("title" => $value,"st" => 'active',"date" => $todayNow);
									$data_tag = $insert_tag->execute($params_tag);
								}
							}
							
							
							
							$tag_content=$tag_name.",".$old_tag_name;
						}
						//echo $image_name;die();
						$update_query = $db->prepare("update khabarnewindia_post_records SET tag_line = :tg, title = :name, slug_title = :slug, description = :des, author = :writer, post_image = :img, video_link = :link, news_type = :type, created_on = :date_on where id = :rid");
						$params = array("tg" => $tag_content,"name" => $name,"slug" => $slug_title,"des" => $content,"writer" => $writer,"img" => $image_name,"link" => $video_link,"type" => $news_type,"date_on" => $created_on,"rid" => $tid);
						$data = $update_query->execute($params);
						
						$del_category=$db->prepare("delete from khabarnewindia_post_category where post_id= :id");
						$params_del_category = array("id" => $tid);
						$data_del_category = $del_category->execute($params_del_category);
						
						// Insert Post Categories.............................................	
						$totalitem =sizeof($catgeory_id);
						for($j=0;$j<$totalitem;$j++)
						{
							
							$ct_id = $_POST['catgeory_id'][$j];
							$insert_post_category = $db->prepare("insert into khabarnewindia_post_category (post_id,category_id) values (:p_id,:c_id)");
							$params_post_category = array("p_id" => $tid,"c_id" => $ct_id);
							$data_post_category = $insert_post_category->execute($params_post_category);
							
						}
						
						$update_seo_details = $db->prepare("update khabarnewindia_post_seo_details SET seo_title = :s_title, meta_description = :desc, meta_keywords = :keywords where post_id = :pid");
						$params_seo = array("s_title" => $meta_title,"desc" => $meta_discription,"keywords" => $meta_keywords,"pid" => $tid);
						$data_seo = $update_seo_details->execute($params_seo);

						
						
						header("location:post_list.php");die();


					}
				}	
				
			}
		}
		
	}
	 catch(PDOException $ex) 
	 {
			echo "An Error occured! Please Contact Administrator.";
	 }


	  
		
?>
<!DOCTYPE html>
<html class=" ">
<head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Khabar New India - सोच ईमानदार, खबर दमदार </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
       

        <!-- CORE CSS FRAMEWORK - START -->
        <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="assets/plugins/datepicker/css/datepicker.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
		<link rel="stylesheet" href="i-css/custom.css">

        <!-- CORE CSS TEMPLATE - START -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->
		<style>
		.error
		{
			color:red !important;
		}
            .media_del {
                margin-top: -5px;
                margin-left: 80px;
                color: red;
                font-size: 17px;
                font-weight: bold;
                position: absolute;
            }


			
	
		</style>
        <!-- CORE CSS TEMPLATE - END -->
		 <script src="i-js/jquery-2.2.3.min.js"></script>
		<script src="i-js/jquery.validate.min.js"></script>
		<script>

			function copy(element_id){
			//   var aux = document.createElement("div");
			//   aux.setAttribute("contentEditable", true);
			//   aux.innerHTML = document.getElementById(element_id).innerHTML;
			//   aux.setAttribute("onfocus", "document.execCommand('selectAll',false,null)"); 
			//   document.body.appendChild(aux);
			//   aux.focus();
			//   document.execCommand("copy");
			//   document.body.removeChild(aux);
				
			
			  var paraHtml = document.getElementById(element_id);
			  //alert(paraHtml);
			  paraHtml.select();
			  navigator.clipboard.writeText(paraHtml.value);
			//   alert("Copied the text: " + paraHtml.value);

			}
            
            function delete_media_file(string_data)
            {
               
                var post_data = {mid: string_data};

                $.ajax({
                url: "media_delete_handler.php",
                type: "POST",
                data:  post_data,
                cache: false,
                success: function(html){
                //alert(html);
                var res = string_data.split(".");
                var record_id = res[0];
                $("#block-" + record_id).hide();

                },
                //error: function(){} 	        
                }); 
                
            }
			
		$(document).ready(function(){
            
//             var editor = CKEDITOR.replace('editor1');//, {height : 380});
//              alert(CKEDITOR);
// 			 CKEDITOR.on( 'loaded', function( evt ) {
//     // your stuff here
// 	alert('test');
// } );
			CKEDITOR.replace( 'editor1', {
				on: {
					instanceReady: function( ev ) {
						// your stuff here
						ev.editor.dataProcessor.htmlFilter.addRules( {
						elements : {
						img: function( el ) {
							// Add bootstrap "img-responsive" class to each inserted image
							el.addClass('img-responsive');
					
							// Remove inline "height" and "width" styles and
							// replace them with their attribute counterparts.
							// This ensures that the 'img-responsive' class works
							var style = el.attributes.style;
					
							if (style) {
								// Get the width from the style.
								var match = /(?:^|\s)width\s*:\s*(\d+)px/i.exec(style),
									width = match && match[1];
					
								// Get the height from the style.
								match = /(?:^|\s)height\s*:\s*(\d+)px/i.exec(style);
								var height = match && match[1];
					
								// Replace the width
								if (width) {
									el.attributes.style = el.attributes.style.replace(/(?:^|\s)width\s*:\s*(\d+)px;?/i, '');
									// el.attributes.width = width;
								}
					
								// Replace the height
								if (height) {
									el.attributes.style = el.attributes.style.replace(/(?:^|\s)height\s*:\s*(\d+)px;?/i, '');
									// el.attributes.height = height;
								}
							}
					
							// Remove the style tag if it is empty
							if (!el.attributes.style)
								delete el.attributes.style;
							}
								}
							});
					}
				}
			} );
            CKEDITOR.editorConfig = function( config ) {
        	config.toolbarGroups = [
        		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        		{ name: 'forms', groups: [ 'forms' ] },
        		'/',
        		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        		{ name: 'links', groups: [ 'links' ] },
        		{ name: 'insert', groups: [ 'insert' ] },
        		'/',
        		{ name: 'styles', groups: [ 'styles' ] },
        		{ name: 'colors', groups: [ 'colors' ] },
        		{ name: 'tools', groups: [ 'tools' ] },
        		{ name: 'others', groups: [ 'others' ] },
        		{ name: 'about', groups: [ 'about' ] }
        	];
			

        };


		
        var radioValue = $("input[name='video_type']:checked").val();

		if(radioValue == "other") {
				$("#video_link_type_youtube").hide();
				$("#video_link").val("");
				$("#video_upload_type_other").show();
				
			}else {
				$("#video_link_type_youtube").show();
				$("#video_upload_type_other").hide();
			}
            
            $('input[type=radio][name=video_type]').change(function() {
				if (this.value  == "other") {
				$("#video_link_type_youtube").hide();
				$("#video_upload_type_other").show();
				
			}else if (this.value == 'youtube') {
				$("#video_upload_type_other").hide();
				$("#video_link_type_youtube").show();
				
			}
			});

                $('#video_check').change(function() {
                    if(this.checked) {
                        $(".Link_block").show();
                    }else {
                        $(".Link_block").hide();
                    }        
                });
        


			$("#choose_tag").click(function(){
				
				$("#tag_id").toggle();
			});
			
			$("#save_click").click(function(){
				var type = $("#news_type").val();
				var content=CKEDITOR.instances['editor1'].getData();
				if(content=="" && type=="Text News")
				{
					alert("Please Provide News Content.");
					return false;
				}
			});
            
         
            
			
			$("#news_type").change(function(){
				var type = $("#news_type").val();
				if(type=="Text News")
				{
					if ($('#video_check').is(":checked"))
						$(".Link_block").show();
					else 
						$(".Link_block").hide();
					
					$(".content_block").show();
					$(".news_img_bock").show();
					$("#content_image_section").show();
					
				}
				if(type=="Video News")
				{
					$(".content_block").hide();
					$(".news_img_bock").show();
					
					//if ($('#video_check').is(":checked"))
						$(".Link_block").show();
					//else 
					//	$(".Link_block").hide();					
					$("#content_image_section").hide();
					
				}
				
			});
			
			$(".reply").click(function(){
					//alert("hello");
					var data = $(this).attr('id');
					//alert(data);
					$("#hid").val(data);
					$("#commentbox").show();
			});
	
		$(".close").click(function(event){
				$("#content_img").val("");
				$("#commentbox").hide();
		});
		

		
		$("#change-status").on('submit',(function(e){
			e.preventDefault();
			$.ajax({
			url: "content_image_upload_handler.php",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				
				if(data=="no")
				{
					alert("Please Select a Image");
					return false;
				}
				else if(data=="invalid")
				{
					alert("Please Select a Valid Image");
					return false;
				}
				else if(data=="size")
				{
					alert("File too large. File must be less than 2 Mb.");
					return false;
				}
				else
				{
					
					$(".image_container").append(data);
					$("#content_img").val("");
					$("#commentbox").hide();
					
					//window.location.reload();
				}					

				
			},
			error: function(){} 	        
			});
		}));
		
		});
		
		  (function($,W,D)
		{
			var JQUERY4U = {};

			JQUERY4U.UTIL =
			{
				setupFormValidation: function()
				{
					//form validation rules
					$("#post_form").validate({
						rules: {
								
									news_type:
									{
										required: true,
									},
									title:
									{
										required: true,
									},
									slug_title:
									{
										required: true,
									},
									created_on:
									{
										required: true,
									},
									video_link:
									{
										required: {
												depends: function(element) {
													return $('#news_type').val() == 'Video News';
												}
										},
									},
									post_img:
									{
										required: true,
										
										
										// required: {
										// 		depends: function(element) {
										// 			return $('#news_type').val() == 'Text News';
										// 		}
										// },
										// accept: "jpg,jpeg,png",
									},
									 "catgeory_id[]": 
									 {
										required: true,
										minlength: 1

									  },
									writer:
									{
										required: true,
									}
									
									
						},
						messages: 
						{
							news_type:
							{
								required:"Please Select News Type",
							},
							title:
							{
								required:"Please Provide Title",
								
							},
							slug_title:
							{
								required:"Please Provide Slug.",
								
							},
							created_on:
							{
								required:"Please Provide Post Date.",
								
							},
							video_link:
							{
								required:"Please Provide Video Link.",
								
							},
							post_img:
							{
								required:"Please Provide Post Image.",
								accept:"Only Jpg and Png File Allow For Upload.",
							},
							"catgeory_id[]":
							{
								required:"Please Select Category.",
								
							},
							writer:
							{
								required:"Please Provide Author Name.",
							}
						},
						submitHandler: function(form) {
							form.submit();
						}
					});
					
			
				}
			}

			//when the dom has loaded setup form validation rules
			$(D).ready(function($) {
				JQUERY4U.UTIL.setupFormValidation();
			});

		})(jQuery, window, document);

	  </script>

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" ">
        <!-- START TOPBAR -->
        <div class='page-topbar '>
            <div class='logo-area'>

            </div>
			<?php $page_name="post"; require_once("include/top_bar.php"); ?>

        </div>
        <!-- END TOPBAR -->
        <!-- START CONTAINER -->
        <div class="page-container row-fluid">

            <!-- SIDEBAR - START -->
			<?php require_once("include/sidebar.php"); ?>
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <section id="main-content" class=" ">$validationMsg
                <section class="wrapper main-wrapper" style=''>
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 page_title_block'>
                        <div class="page-title">

                            <div class="pull-left">
                                <h1 class="title">Add New Post</h1>
							</div>

                            <div class="pull-right hidden-xs">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="dashboard.php"><i class="fa fa-home"></i>Home</a>
                                    </li>
									<?php 
									$user_type=$_SESSION['loginType'];
									if($user_type=="administrator")
									{	
									?>
                                    <li>
                                        <a href="post_list.php">All Post</a>
                                    </li>
									<?php }?>			
                                    <li class="active">
                                        <strong>Add Post</strong>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <section class="box ">

							<div class="" id="commentbox" style="display:none;top: 19%;">
								<div class="poup-div-close-quote" style="width:100%;"><img src="images/cross-icon.png" class="close" style='    width: 40px;'></div>
								<h5><b>Select Uplaod Image</b>(Only Jpg and png file allow for upload)</h5>
								<form class="brand-form" action="" method="post" enctype="multipart/form-data" id="change-status">
								<div class="form-group">
									<input type="file" name="content_img" id="content_img" class="form-control">
									<input type="hidden" name="hid" id="hid" value="" />
								</div>
								<input type="submit" name="passstatus" class="btn btn-default" id="buttion_reply" value="Upload">
								</form>
							</div>
                            
                            <header class="panel_header">
							<div class="col-lg-9 col-md-8 col-sm-9 col-xs-12 padding-bottom-30 add_post_left_block error"> <?=$validationMsg?></div>
							</header>
							
                            <div class="content-body">
                                <div class="row">
								
								<?php 
								 if($validate_message)
									 echo $validate_message;
								?>
								<?php
								if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
								{
									$ed_text=base64_encode("update");
								?>
									
									<form action ="add_post.php?tid=<?=$encode_tid?>&act=<?=$ed_text?>" method="post" name="post_form" id="post_form" enctype="multipart/form-data">
								<?php } else { ?>
									<form action ="add_post.php" method="post" name="post_form" id="post_form" enctype="multipart/form-data">
								<?php } ?>
								
                                    <div class="col-lg-9 col-md-8 col-sm-9 col-xs-12 padding-bottom-30 add_post_left_block">
                                            
										<div class="col-lg-3 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">

                                            <div class="form-group">
                                                <label class="form-label" for="field-1"><!--News Type--> Format </label>
                                                <span class="desc"></span>
                                                <div class="controls">
                                                   <select  class="form-control" name="news_type" id="news_type">
														<!--<option value="">Select News Type</option>-->
														<option value='Text News' <?php if($type=="Text News") echo"selected"; ?>>Text News</option>
														<option value='Video News' <?php if($type=="Video News") echo"selected"; ?>>Video News</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-9 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">

                                            <div class="form-group">
                                                <label class="form-label" for="field-1">Title</label>
                                                <span class="desc"></span>
                                                <div class="controls">
                                                    <input type="text" value="<?=$title?>" class="form-control" name="title" id="title" Placeholder="Enter Title Here">
                                                </div>
                                            </div>

                                        </div>
										<div class="col-lg-12 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">

                                            <div class="form-group">
                                                <label class="form-label" for="field-1">Slug <!--(Input Title in English or Message Language)--></label>
                                                <span class="desc"></span>
                                                <div class="controls">
                                                    <input type="text" value="<?=$sl_title?>" class="form-control" name="slug_title" id="slug_title">
                                                </div>
                                            </div>

                                        </div>
										
										<div class="col-lg-12 col-md-8 col-sm-9 col-xs-12 padding-bottom-30" style="padding-bottom: 30px;">

                                            <div class="form-group">
                                                <label class="form-label" for="field-1"><a href='#' class="reply">Upload Content Image <i class="fa fa-upload" aria-hidden="true" style="padding-left: 25px;     font-size: 25px;"></i></a></label>
												<div class="col-lg-12 image_container" style="overflow:scroll; height:155px;     border: 3px solid;">
                                                    
                                                    <?php
                                                        $directory = "../media-folder";
                                                        $images = glob($directory . "/*");
														
                                                        foreach($images as $image_name)
                                                        {
                                                            $digits = 3;
                                                            $id_sel=rand(pow(10, $digits-1), pow(10, $digits)-1);
                                                          //echo $image_name."<br>";
                                                            
                                                            $folder_name_array=explode("..",$image_name);
                                                            $org_image_name=$folder_name_array[1];
                                                            
                                                            $file_name_array=explode("media-folder/",$org_image_name);
                                                            $file_name_string=$file_name_array[1];
                                                            
                                                            $file_string_array=explode(".",$file_name_string);
                                                            $file_string=$file_string_array[0];
                                                            //echo $file_name_string;
                                                            
                                                            echo "<div class='col-lg-2' id='block-$file_string'>
                                                            <a href='#' id='$file_name_string' onclick='delete_media_file(this.id);' class='media_del' ><i class='fa fa-times' aria-hidden='true' style='font-size: 20px;'></i></a>
                                                            <img src='$image_name' class='$id_sel' style='width:95px; height:60px; margin-bottom:5px;'><input type ='hidde' value ='$redirectPath_site/$org_image_name' id='$id_sel'></br><a href='#' onclick='copy($id_sel);' class='btn' style='margin-bottom:5px;'>Copy Link</a></div>";
                                                        }
                                                   ?>
                                                    
												</div>
                                            </div>

                                        </div>
										
													
													
											<div class="news_img_bock" >		
												  <?php if(file_exists($full_img_path) && $post_image!=""){?>
													<div class="col-lg-12 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
														<div class="form-group">
															<label class="form-label" for="field-1">Featured Image</label>
															<div class="form-group col-md-12 col-sm-12 col-xs-12">
																<figure class="banner_image">
																<?php
																$action=base64_encode("delimg");
																?>
																	<img src="<?=$full_img_path?>" style='width: 266px;'>
																	<a class="btn btn-danger delbanner" href="add_post.php?act=<?=$action?>&tid=<?=$encode_tid?>">Change Image</a>
																</figure>
																
															</div>
														</div>
													</div>
													<?php } else { ?>
													<div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
														<div class="form-group">
														
																<label class="form-label" for="field-1">Featured Image (<small> Image size must be Minimum 800*450 </small>)</label>
																<span class="desc"></span>
																<div class="controls" >
																	<input type="file" name="post_img" id="post_img" class="form-control">
																</div>
																
														</div>
													</div>
													<?php } ?>
										</div>			
													
										  <?php 
										 if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
										 { 
										 ?>
                                         <div class="col-lg-6 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">

                                                <div class="form-group">
                                                    <label class="form-label" for="field-5">Published On</label>
                                                    <span class="desc"></span>
                                                    <div class="controls">
                                                        <input type="text" value="<?=$created_on?>" name="created_on" class="form-control datepicker" data-format="yyyy-mm-dd" value="">
                                                    </div>
                                                </div>
										</div>
										
										 <?php } ?>   
										 <div class="col-lg-4 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                                <div class="form-group">
                                                    <label class="form-label" for="field-1">Author </label>
                                                    <span class="desc"></span>
                                                    <div class="controls">
                                                        <input type="text" value="<?=$author?>" name="writer" class="form-control" id="field-1">
                                                    </div>
                                                </div>
										</div>
                                              	
                                            
                                    </div>
                                    <div class="col-lg-3 col-md-8 col-sm-9 col-xs-12 padding-bottom-30 add_post_right_block">
                                        
                                        <div class="col-lg-12 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
												<div class="form-group">
                                                    <label class="form-label" for="field-5">Categories</label>
                                                    <span class="desc"></span>
													<div class="form-group" style='overflow-y: scroll; height: 330px;border: 3px solid;'>
                                                    
																<?php
																$sel_record=$db->query("select * from khabarnewindia_category where status=1  order by name asc");
																$num_record=$sel_record->rowCount();
																if($num_record)
																{
																	while($fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC))
																	{
																		$t_id=$fetch_record['id'];
																		$title=$fetch_record['name'];

																		if(!($t_id==2||$t_id==3||$t_id==5||$t_id==7||$t_id==8||$t_id==9||$t_id==10||$t_id==11||$t_id==12 ||$t_id==16))
																		{
																		//if($ctaegory_id==$t_id)
																			if(in_array($t_id, $category_array))	
																			{
																				echo"<div class='col-lg-12 col-md-8 col-sm-9 col-xs-12'><label class='form-label'><input type='checkbox' name='catgeory_id[]' class='select' style='height: 10px; width: 40px;' class='iCheck' value='$t_id' checked> </label><label class='form-label'><strong style='font-size: 14px;'>$title</strong></label></div>";
																			}
																			else
																			{	
																				echo"<div class='col-lg-12 col-md-8 col-sm-9 col-xs-12'><label class='form-label'><input type='checkbox' name='catgeory_id[]' class='select' style='height: 15px; width: 40px;' class='iCheck' value='$t_id' > </label><label class='form-label'><strong style='font-size: 14px;'>$title</strong></label></div>";
																			}
																	    }
																	}	
																}
																?>
													</div>			
                                                </div>
											</div>
                                        
                                            <div class="col-lg-12 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                                <div class="form-group">
                                                    <label class="form-label" for="field-5">Tag (<small>Separate tags with comma and use '#' before</small>)</label>
                                                    <span class="desc"></span>
													 <input type="text" value="<?=$tag_id?>" name="tag_name" id="tag_name" class="form-control" id="field-1">
													 
													 <a id='choose_tag'>Choose from the most used tags</a>
                                                    <select multiple="multiple" class="form-control" name="tag_id" id="tag_id" style='display:none;'>
														<option value="" >Select Tag</option>
																<?php
																$sel_record=$db->query("select * from khabarnewindia_tags_details where status='active'  order by tag_name asc");
																$num_record=$sel_record->rowCount();
																if($num_record)
																{
																	while($fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC))
																	{
																		$t_id=$fetch_record['id'];
																		$title=$fetch_record['tag_name'];
																		if($tag_id==$t_id)
																		{
																			echo"<option value='$t_id' selected>$title</option>";
																		}
																		else
																		{	
																			echo"<option value='$t_id'>$title</option>";
																		}
																	}	
																}
																?>
                                                    </select>
                                                </div>
											</div>
                                    </div> 
                                    <div class="col-lg-12 content_block">    
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content_block">

                                                <div class="form-group" style="margin-bottom:0px;">
                                                    <label class="form-label" for="field-5">Content</label>
                                                    <span class="desc"></span>

                                                    <textarea  cols="80" id="editor1" name="editor1" rows="10"><?=$description?>
                                                    </textarea><br>
                                                </div>
                                         </div>    
                                    </div>  
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 Link_block" style='display:none;'>
											<div class="row">
												<div class="col-lg-12"> &nbsp; </div>
											</div>
											<div class="row" >
												<div class="col-lg-4">
													<div class="form-group">
														<label class="form-label" for="field-5">Video Type</label>
															<br/>
														  <input type="radio" id="video_type" name="video_type" value="youtube" <?php if($vdType=="Youtube") echo"checked"; ?>>
														  <label for="Youtube">Youtube Link</label><br>
														  <input type="radio" id="video_type" name="video_type" value="other" <?php if($vdType=="other") echo"checked"; ?>>
														  <label for="other">Video Upload</label><br>

														 <!--<input type="radio" value="<?=$link?>" class="form-control" name="video_link" id="video_link">-->
													</div>
												</div>
												<div class="col-lg-8" id="video_link_type_youtube">
													<div class="form-group">
														<label class="form-label" for="field-5">Video Link</label>
														

														 <input type="text" value="<?=$link?>" class="form-control" name="video_link" id="video_link">
													</div>
												</div>
												<div class="col-lg-8" id="video_upload_type_other">
													<div class="form-group">
														<label class="form-label" for="field-5">Upload Video</label>
														 <input type="file" name="video_upload" id="video_upload" class="form-control">
														 <?php if($link!='') { ?>
														 <video id="video1" controls>
															<source src="<?=$link?>" type="video/mp4">	
													  </video>
														 <?php } ?>
													</div>
												</div>
											</div>
										 </div>
										

											
                                    <div class="col-lg-12 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                        <div class="text-left" style="text-align: center;">

                                            <?php
                                            if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
                                            {
                                            ?>
                                            <button type="submit" name="update" id="save_click" class="btn btn-primary">Update</button>
                                            <?php } else { ?>
                                            <button type="submit" name="submit" id="save_click" class="btn btn-primary">Publish</button>
                                            <?php }?>
                                        </div>
                                    </div>    
                                    </form>
                               


                            </div>
                        </section></div>



                </section>
            </section>
            <!-- END CONTENT -->
   </div>
        <!-- END CONTAINER -->
        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


        <!-- CORE JS FRAMEWORK - START --> 
        <script src="assets/js/jquery-1.11.2.min.js" type="text/javascript"></script> 
        <script src="assets/js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <script src="assets/plugins/datepicker/js/datepicker.js" type="text/javascript"></script> <script src="assets/plugins/autosize/autosize.min.js" type="text/javascript"></script><script src="assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
		<!--<script src="assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>-->


        <!-- CORE TEMPLATE JS - START --> 
        <script src="assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
        <!-- Sidebar Graph - END --> 

	<script src="ckeditor/ckeditor.js"></script>


        
    </body>
<?php
if($type=="Text News")
{
?>
<script>
$(document).ready(function(){
	
	$(".Link_block").hide();
	$(".content_block").show();

	
});

});
</script>
<?php } ?>

<?php
if($type=="Video News")
{
?>
<script>
$(document).ready(function(){
	
	$(".content_block").hide();
    $(".Link_block").show();

	
	

});
</script>
<?php } ?>



});
</script>
</html>
