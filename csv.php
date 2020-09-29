<?php 


 
function videoList($result_offset = 0){
	
	
	   /*********************  API Key Detail *************************/
  $api_key = 'xmjKAeDF';
  $api_secret = 'uToPAoYsYXKylo02Hwy2xOwb';
  
  /***************************************************************/
  $api_timestamp = time();
  $api_nonce = mt_rand( 10000000, 99999999);

  	$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
	$URL = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
	
  $api_signature = 'api_format=json&api_key='.$api_key.'&api_nonce='.$api_nonce.'&api_timestamp='.$api_timestamp;
    $ch = curl_init();
   $headers = array(
    'Accept: application/json',
    'Content-Type: application/json',

    );
		$api_signature = $api_signature.'&result_limit=100&result_offset='.$result_offset;
	 
curl_setopt($ch, CURLOPT_URL, 'https://api.jwplatform.com/v1/videos/list?'.$api_signature.'&api_signature='.sha1($api_signature.$api_secret));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

 $videoList= json_decode(curl_exec($ch));
	return $videoList;
}

$videoMainList = videoList(0);
$i=1;
$p = ceil($videoMainList->total / 100);
$collectVideos[] = ['VideoName','JW ID','WordPress Post ID','Category','Push','In App','Series key','Series index','Tags'];
if($videoMainList->status == 'ok'){ 
	$collectVideos = array_merge($collectVideos,collectFields($videoMainList));
}
 while($i <= $p) {
	 
	 $videoMiniList = videoList($i.'00');
	 
	 if($videoMiniList->status == 'ok'){
		 
		$collectVideos =array_merge($collectVideos, collectFields($videoMiniList));
	   
				}
	 
	 $i++;
	 
 }
  
 outputCSV( $collectVideos,"numbers.csv");
 


 function collectFields($videoMiniList){
	 $collectVideos=[];
	  foreach($videoMiniList->videos as $value){
					$custom = $value->custom;
					 
				 
						$push =(isset($custom->push)) ? $custom->push : '';
						$inapp =(isset($custom->inapp)) ? $custom->inapp : '';
				 
				 
					$wordpress_post_id = (isset($custom->wordpress_post_id)) ? $custom->wordpress_post_id : '' ;
					$seriesKey = (isset($custom->seriesKey)) ? $custom->seriesKey : '' ;
					$seriesIndex = (isset($custom->seriesIndex)) ? $custom->seriesIndex : '' ;
					$category = (isset($custom->category)) ? $custom->category : '' ;
					 
					
					$collectVideos[] = [$value->title,$value->key,$wordpress_post_id,$category,$push,$inapp,$seriesKey,$seriesIndex,$value->tags];
				 
					
				}
			
				return $collectVideos;
 }

 function outputCSV($someData,$filename = 'file.csv') {
	 $outputCSv ='';
  $newTab  = "\t";
    $newLine  = "\n";
	
foreach ($someData as $data) {
 
 
    $outputCSv .='"'. implode('"'.$newTab.'"', $data).'"'.$newLine;  
}
 header('Content-Encoding: UTF-8'); 	 
       # output headers so that the file is downloaded rather than displayed
        header("Content-Type: text/csv;charset=UTF-8");
		
header('Content-Disposition: attachment;filename='.$filename);

  # Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        # Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        # Disable caching - Proxies
        header("Expires: 0");
		
print chr(255) . chr(254).mb_convert_encoding($outputCSv, 'UTF-16LE', 'UTF-8');
    }
?>