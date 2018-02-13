<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>RSS feed fetcher</title>
    <link rel="stylesheet" href="css/default.css" />
    <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
    <script src="js/myScript.js" type="text/javascript"></script>
</head>
<body>
<div class="content">

 <?php

 $url = "https://flipboard.com/@raimoseero/feed-nii8kd0sz?rss";
 if(isset($_POST['submit'])){
   if($_POST['feedurl'] != ''){
     $url = $_POST['feedurl'];
   }
 }

 $invalidurl = false;
 if(@simplexml_load_file($url)){
  $feeds = simplexml_load_file($url);
 }else{
  $invalidurl = true;
  echo "<h2>Invalid RSS feed URL.</h2>";
 }


 $i=0;
 if(!empty($feeds)){

  $site = $feeds->channel->title;
  $sitelink = $feeds->channel->link;

  foreach ($feeds->channel->item as $item) {
      
   $image = $item->children('media', True)->content->attributes();
  
   $title = $item->title;
   $link = $item->link;
   $description = $item->description;
   $postDate = $item->pubDate;
   $pubDate = date('D, d M Y',strtotime($postDate));
    
      
   if($i>=6) break;
  ?>
   <div class="post">
     <div class="post-head">
         <img src="<?php echo $image ?>"><h2><a href="#" class="feed_title" onClick="javascript:window.open('<?php echo $link; ?>', '_blank','toolbar=no,width=600,height=600');"><?php echo $title; ?></a></h2>
       <span style="margin-left: 5px"><?php echo $pubDate; ?></span>
     </div>
     <div class="post-content">
       <?php echo implode(' ', array_slice(explode(' ', $description), 0, 500)) . "..."; ?> <a href="#" onClick="javascript:window.open('<?php echo $link; ?>', '_blank','toolbar=no,width=600,height=600');">Read more</a>
     </div>
   </div>

   <?php
    $i++;
   }
 }else{
   if(!$invalidurl){
     echo "<h2>No item found</h2>";
   }
 }
 ?>
</div>

</body>
</html>