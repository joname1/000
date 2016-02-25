<?php
error_reporting(E_ALL^E_NOTICE);
$v=$_GET[v];
//判断get是否为空？
$p=$_GET[p];
if(empty($v)){
$g_et='true';
}
//判断设备
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
if (isMobile()){  
  //如果手机访问
header("Location: m_video.php?v=$v"); 
//确保重定向后，后续代码不会被执行 
exit;
}
else{
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
if($p=='720'){
   
$furl=$aaaks[5][url];//720p地址
}elseif($p=='480'){
$furl=$aaaks[3][url];
}else{
$furl=$aaaks[2][url];   
    
}

$murl=$aaaks[3][url];//mp4视频地址(480p)


//加密传输视频
// Declare the class
class GoogleUrlApi {
	
	// Constructor
	function GoogleURLAPI($key,$apiURL = 'https://www.googleapis.com/urlshortener/v1/url') {
		// Keep the API Url
		$this->apiURL = $apiURL.'?key='.$key;
	}
	
	// Shorten a URL
	function shorten($url) {
		// Send information along
		$response = $this->send($url);
		// Return the result
		return isset($response['id']) ? $response['id'] : false;
	}
	
	// Expand a URL
	function expand($url) {
		// Send information along
		$response = $this->send($url,false);
		// Return the result
		return isset($response['longUrl']) ? $response['longUrl'] : false;
	}
	
	// Send information to Google
	function send($url,$shorten = true) {
		// Create cURL
		$ch = curl_init();
		// If we're shortening a URL...
		if($shorten) {
			curl_setopt($ch,CURLOPT_URL,$this->apiURL);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode(array("longUrl"=>$url)));
			curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: application/json"));
		}
		else {
			curl_setopt($ch,CURLOPT_URL,$this->apiURL.'&shortUrl='.$url);
		}
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		// Execute the post
		$result = curl_exec($ch);
		// Close the connection
		curl_close($ch);
		// Return the result
		return json_decode($result,true);
	}		
}


require 'pheader.php';

// Create instance with key
$key = $gurl_api;
$googer = new GoogleURLAPI($key);

// Test: Shorten a URL
//加密后的视频流链接
$flvurl1 = $googer->shorten("$furl");//flv
$mp4url1 = $googer->shorten("$murl");//mp4
//获取视频列表

$flvurl= $parserurl.'/ytproxy/browse.php?u='.$flvurl1;
$mp4url= $parserurl.'/ytproxy/browse.php?u='.$mp4url1;

$vname1=$vname;

$API_key=$youtube_api;
// $jsonurl='https://www.googleapis.com/youtube/v3/search?key='.$API_key.'&part=snippet&q='.$vname1.'&maxResults=20&type=video';

$jsonurl='https://www.googleapis.com/youtube/v3/search?part=snippet&order=relevance&amp;regionCode=lk&key='.$API_key.'&part=snippet&maxResults=40&relatedToVideoId='.$v.'&type=video';


//To try without API key: $video_list = json_decode(file_get_contents(''));
$video_list = json_decode(file_get_contents($jsonurl));
$video_list1=object_array($video_list);
?>
<div class="wrapper container">
<div  class="pull-left" id="a1" style="width:850px">
<link href="css/video-js.min.css" rel="stylesheet">
<script src="js/video.min.js"></script>
<script>
    videojs.options.flash.swf = "js/video-js.swf";
</script>
<video id="really-cool-video" class="video-js vjs-default-skin" controls autoplay width="854" height="480" data-setup='{"playbackRates": [1, 1.5, 2]}'>
    <source src="http://bak.y0utube.gq/mpaly.php?id=<?php echo $v ?>" type='video/mp4' />
    <source src="http://bak.y0utube.gq/mpaly.php?id=<?php echo $v ?>" type='video/webm' />
    <source src="http://bak.y0utube.gq/mpaly.php?id=<?php echo $v ?>" type='video/ogg' />
    您的浏览器太过陈旧,不支持视频播放.
</video>
<!-- <div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    选择清晰度 <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="video.php?v=<?php echo $v ?>">流畅</a></li>  
    <li><a href="video.php?v=<?php echo $v ?>&p=480">标清</a></li>
    <li><a href="video.php?v=<?php echo $v ?>&p=720">高清</a></li>
  </ul>
</div> -->
<h1><strong><?php echo $vname ?></strong></h1>
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
<div  class="pull-right" style="width:270px">
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
<?php require 'footer.php';?>