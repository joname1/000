<?php
error_reporting(E_ALL^E_NOTICE);
$v=$_GET[v];
//判断设备
if(empty($v)){
$g_et='true';
}
function isMobile(){    
    $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';    
    $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';      
    function CheckSubstrs($substrs,$text){    
        foreach($substrs as $substr)    
            if(false!==strpos($text,$substr)){    
                return true;    
            }    
            return false;    
    }  
    $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');  
    $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod','iPad');    
                
    $found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||    
              CheckSubstrs($mobile_token_list,$useragent);    
                
    if ($found_mobile){    
        return true;    
    }else{    
        return false;    
    }    
}  
if (isMobile()){}
else{
     //如果电脑访问
header("Location: video.php?v=$v"); 
//确保重定向后，后续代码不会被执行 
exit;
}
//获取原始下载地址
//require 'inc/parser.php';
$parserurl='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
$parserurl=dirname($parserurl);


$geturl= $parserurl.'/parser/index.php?videoid='."$v";

$w=file_get_contents($geturl);

$cv=json_decode($w); 

//print_r($cv);

//echo $cv[Download][1][url];
function object_array($array)
{
   if(is_object($array))
   {
    $array = (array)$array;
   }
   if(is_array($array))
   {
    foreach($array as $key=>$value)
    {
     $array[$key] = object_array($value);
    }
   }
   return $array;
}
$rr=object_array($cv);
$aaaks=array_reverse(($rr[Download]));
$vname=$rr[title];//视频名称
$pagetitle=$vname;

//加密传输视频
// Declare the class

require 'pheader.php';
$API_key=$youtube_api;
$jsonurl='https://www.googleapis.com/youtube/v3/search?part=snippet&order=relevance&amp;regionCode=lk&key='.$API_key.'&part=snippet&maxResults=20&relatedToVideoId='.$v.'&type=video';
//To try without API key: $video_list = json_decode(file_get_contents(''));
$video_list = json_decode(file_get_contents($jsonurl));
$video_list1=object_array($video_list);
?>
<script src="js/mediaelement.js"></script>
<div class="wrapper container">
<div class="row">
  <video width="100%" height="auto" id="player1" controls="controls" poster="./thumbnail.php?vid=<?php echo $v ?>">
    <source src="./mpaly.php?id=<?php echo $v ?>" type='video/mp4' />
    <source src="./mpaly.php?id=<?php echo $v ?>" type='video/webm' />
    <source src="./mpaly.php?id=<?php echo $v ?>" type='video/ogg' />
    您的浏览器不支持HTML5视频播放.
  </video>
<script>
MediaElement('player1', {success: function(me) {
  me.play();
  
}});
</script>
</div>
<div class="col-xs-12">
<h3><?php echo $vname ?></h3> 
<p>无法播放? <a href="./m_video.php?v=<?php echo $v ?>"><span class="label label-warning">点击刷新</a></span></p>
</div>
<!-- 多说评论 start -->
<div class="ds-thread" data-thread-key="<?php echo $v ?>" data-title="<?php echo $vname ?>" data-url="http://y0utube.gq/video.php?v=<?php echo $v ?>"></div>
<script type="text/javascript">
var duoshuoQuery = {short_name:"joname"};
    (function() {
        var ds = document.createElement('script');
        ds.type = 'text/javascript';ds.async = true;
        ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
        ds.charset = 'UTF-8';
        (document.getElementsByTagName('head')[0] 
         || document.getElementsByTagName('body')[0]).appendChild(ds);
    })();
    </script>
</div>
<!-- 多说评论 end -->
        <div class="col-xs-12">
 <span class="list-group-item active label label-default">
  相关视频
</span>
<?php
for($i=0;$i<=10;$i++){
      echo'<a href="video.php?v='.$video_list1[items][$i][id][videoId].' "target="_blank" class="list-group-item"><img src="./thumbnail.php?vid='.$video_list1[items][$i][id][videoId].'"style="height:60px;width:90px;"><span style="height:50px;width:140px;margin:0 auto;float:right;">'.$video_list1[items][$i][snippet][title].'</span></a>'; 
    
}
?>     

</div>

    </div> 

</div>
<?php require 'footer.php';?>