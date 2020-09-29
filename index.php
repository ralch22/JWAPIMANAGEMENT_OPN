<!DOCTYPE html>
<html lang="en">
   <head>
      <title>JW Player</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
      <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" integrity="sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9" crossorigin="anonymous"></script>
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css">
      <link rel="stylesheet" href="css/style.css">
      <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
   </head>
   <body>
      <nav class="navbar navbar-inverse bg-primary">
         <div class="container-fluid">
            <h1 class="text-white">OnePath Network JW Player API Management Panel</h1>
         </div>
      </nav>
      <section class="jw_table">
         <div class="container-fluid">
		 
            <form action="" method="post" class="search_form mb-4">
               <div class="row">
                  <div class="col-md-6 search_content">
                     <h1>Video Update Form</h1>
                     <?php
                        function file_get_contents_utf8($content)
                        {
                        
                            return htmlspecialchars(rawurlencode($content));
                        }

                        /*********************  API Key Detail *************************/
                        $api_key = 'xmjKAeDF';
                        $api_secret = 'uToPAoYsYXKylo02Hwy2xOwb';
                        
                        /***************************************************************/
                        $api_timestamp = time();
                        $api_nonce = mt_rand(10000000, 99999999);
                        
                        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
                        $URL = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0];
                        
                        $api_signature = 'api_format=json&api_key=' . $api_key . '&api_nonce=' . $api_nonce . '&api_timestamp=' . $api_timestamp;
                        
                        $ch = curl_init();
                        $headers = array(
                            'Accept: application/json',
                            'Content-Type: application/json',
                        
                        );
                        
                        /*********************  Update Values *************************/
                        if (isset($_POST['submit']))
                        {
                            $api_noncenew = mt_rand(10000000, 99999999);
                            $newapi_signature = 'api_format=json&api_key=' . $api_key . '&api_nonce=' . $api_noncenew . '&api_timestamp=' . $api_timestamp;
                        
                            $ne_signature = $newapi_signature;
                        
                            if (!empty($_POST['category']))
                            {
                                $ne_signature = $ne_signature . '&custom.category=' . str_replace(' ', '%20', $_POST['category']);
                            }
                            else
                            {
                                $ne_signature = $ne_signature . '&custom.category=';
                            }
                        
                            $_POST['inapp'] = (!empty($_POST['inapp'])) ? $_POST['inapp'] : 'NO';
                            $ne_signature = $ne_signature . '&custom.inapp=' . $_POST['inapp'];
							
							 $_POST['push'] = (!empty($_POST['push'])) ? $_POST['push'] : 'OFF';
                            $ne_signature = $ne_signature . '&custom.push=' . $_POST['push'];
							
                            
                           
                        
                            $_POST['seriesIndex'] = (!empty($_POST['seriesIndex'])) ? $_POST['seriesIndex'] : '';
                            $ne_signature = $ne_signature . '&custom.seriesIndex=' . $_POST['seriesIndex'];
                        
                            $_POST['seriesKey'] = (!empty($_POST['seriesKey'])) ? $_POST['seriesKey'] : '';
                            $ne_signature = $ne_signature . '&custom.seriesKey=' . $_POST['seriesKey'];
							
							$_POST['wordpress_post_id'] = (!empty($_POST['wordpress_post_id'])) ? $_POST['wordpress_post_id'] : '';
                            $ne_signature = $ne_signature . '&custom.wordpress_post_id=' . $_POST['wordpress_post_id'];
                        
						
                            // $_POST['video_size'] = (!empty($_POST['video_size'])) ? $_POST['video_size'] : 0;
                            // $ne_signature = $ne_signature.'&custom.video_size='.$_POST['video_size'];
                            
                        
                            if (!empty($_POST['tags']))
                            {
                                $ne_signature = $ne_signature . '&tags=' . rawurlencode($_POST['tags']);
                            }
                            if (!preg_match('/[^A-Za-z0-9]/', $_POST['title']))
                            {
                                $ne_signature = $ne_signature . '&title=' . str_ireplace("'", "&apos;", str_replace(" ", "%20", $_POST['title']));
                            }
                            else
                            {
                                $ne_signature = $ne_signature . '&title=' . file_get_contents_utf8($_POST['title']);
                            }
                        
                            $ne_signature = $ne_signature . '&video_key=' . $_POST['video_key'];
                        	
                        	/*********************  Api Call *************************/

                            curl_setopt($ch, CURLOPT_URL, 'https://api.jwplatform.com/v1/videos/update?' . $ne_signature . '&api_signature=' . sha1($ne_signature . $api_secret));
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                        
                            $videoUpdate = json_decode(curl_exec($ch));
							
						
							
                            if ($videoUpdate->status == 'ok')
                            {
                                echo '<div class="alert alert-success"> <strong>Success!</strong> Video successfully update.</div><script>setTimeout(function(){ window.location.href = "' . $URL . '" }, 1000);
                        </script>';
                            }
                        
                        }
                        /********************* Bulk Update Values *************************/
                        if (isset($_POST['videos_submit']))
                        {
                            $api_noncenew = mt_rand(10000000, 99999999);
                            $newapi_signature = 'api_format=json&api_key=' . $api_key . '&api_nonce=' . $api_noncenew . '&api_timestamp=' . $api_timestamp;
                        
                            $ne_signature = $newapi_signature;
                        
                            if (!empty($_POST['category']))
                            {
                                $ne_signature = $ne_signature . '&custom.category=' . str_replace(' ', '%20', $_POST['category']);
                            }
                            else
                            {
                                $ne_signature = $ne_signature . '&custom.category=';
                            }
                        
                            $_POST['inapp'] = (!empty($_POST['inapp'])) ? $_POST['inapp'] : 'NO';
                            $ne_signature = $ne_signature . '&custom.inapp=' . $_POST['inapp'];
							
							 $_POST['push'] = (!empty($_POST['push'])) ? $_POST['push'] : 'OFF';
                            $ne_signature = $ne_signature . '&custom.push=' . $_POST['push'];
							
                            
                           
                        
                            $_POST['seriesIndex'] = (!empty($_POST['seriesIndex'])) ? $_POST['seriesIndex'] : '';
                            $ne_signature = $ne_signature . '&custom.seriesIndex=' . $_POST['seriesIndex'];
                        
                            $_POST['seriesKey'] = (!empty($_POST['seriesKey'])) ? $_POST['seriesKey'] : '';
                            $ne_signature = $ne_signature . '&custom.seriesKey=' . $_POST['seriesKey'];
							
							$_POST['wordpress_post_id'] = (!empty($_POST['wordpress_post_id'])) ? $_POST['wordpress_post_id'] : '';
                            $ne_signature = $ne_signature . '&custom.wordpress_post_id=' . $_POST['wordpress_post_id'];
                        
						
                            // $_POST['video_size'] = (!empty($_POST['video_size'])) ? $_POST['video_size'] : 0;
                            // $ne_signature = $ne_signature.'&custom.video_size='.$_POST['video_size'];
                            
                        
                            if (!empty($_POST['tags']))
                            {
                                $ne_signature = $ne_signature . '&tags=' . rawurlencode($_POST['tags']);
                            }
                          
							foreach(explode(",",$_POST['video_key']) as $value ){
								
							$newsig = $ne_signature . '&video_key=' . $value;
                        	
                        	/*********************  Api Call *************************/

                            curl_setopt($ch, CURLOPT_URL, 'https://api.jwplatform.com/v1/videos/update?' . $newsig . '&api_signature=' . sha1($newsig . $api_secret));
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                        
                            $videoUpdate = json_decode(curl_exec($ch));
						
								
							}
                             
							
                            if ($videoUpdate->status == 'ok')
                            {
                                echo '<div class="alert alert-success"> <strong>Success!</strong> Video successfully update.</div><script>setTimeout(function(){ window.location.href = "' . $URL . '" }, 1000);
                        </script>';
                            }
                        
                        }
                        
                        if (isset($_GET['result_offset']))
                        {
                            $api_signature = $api_signature . '&result_offset=' . $_GET['result_offset'];
                        }
						
						
                        if (isset($_GET['search']) && !empty($_GET['search']))
                        {
							
							if (!preg_match('/[^A-Za-z0-9]/', $_GET['search']))
                            {
                               $api_signature = $api_signature . '&search=' . rawurlencode($_GET['search']);
                            }
                            else
                            {
								$api_signature = $api_signature . '&search=' . file_get_contents_utf8($_GET['search']); 
                            }
							
                            
                        }
                        if (isset($_GET['category']) && !empty($_GET['category']))
                        {
                            $api_signature = $api_signature . '&search:custom.category=' . str_ireplace("'", "&apos;", str_replace(" ", "%20", $_GET['category']));
                        }
                        
                        curl_setopt($ch, CURLOPT_URL, 'https://api.jwplatform.com/v1/videos/list?' . $api_signature . '&api_signature=' . sha1($api_signature . $api_secret));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                        
                        $videoList = json_decode(curl_exec($ch));
                        
                        /*********************  Fetch Data *************************/
  
                        if (isset($_GET['jw_id']) && !empty($_GET['jw_id']))
                        {
                        
                            curl_setopt($ch, CURLOPT_URL, 'https://cdn.jwplayer.com/v2/media/' . $_GET['jw_id'] . '?default_source_fallback=true');
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                        
                            $videoDetail = json_decode(curl_exec($ch));
                        
                        }
                        
						
						if(isset($_GET['ids'])){
                        ?>
						<div class="form-group">
                        <label for="jw_id">JW ID</label>
                        <input type="text" readonly required class="form-control" value="<?php echo (isset($_GET['ids'])) ? implode(",",$_GET['ids']) : '' ?>" name="video_key" id="jw_id">
                     </div>
						
						<?php }else{?>
                     <div class="form-group">
                        <label for="jw_id">JW ID</label>
                        <input type="text" readonly required class="form-control" value="<?php echo (isset($_GET['jw_id'])) ? $_GET['jw_id'] : '' ?>" name="video_key" id="jw_id">
                     </div>
						<?php }

					if(!isset($_GET['ids'])){	?>
                     <div class="form-group">
                        <label for="V-name">Video Name</label>
                        <input value="<?php echo (isset($videoDetail->title)) ? $videoDetail->title : '' ?>" type="text" name="title" class="form-control" id="V-name">
                     </div>
					 
					<?php } ?>
                     <div class="form-group">
                        <label for="V-tgs">Video Tags</label>
                        <textarea class="form-control" name="tags" rows="5" id="V-tgs"><?php echo (isset($videoDetail->playlist[0]
                           ->tags)) ? $videoDetail->playlist[0]->tags : '' ?></textarea>
                     </div>
                  </div>

                  <!--*********************  Custom Parameters *************************-->

                  <div class="col-md-6">
                     <h2>Custom Parameters</h2>
                     <div class="form-group v_s">
                        <label for="V-tgs">Category</label>
                        <select class="form-control" name="category" id="sel1">
                           <option value="" selected disabled>Select Category</option>
                           <?php
                              $selected = '';
                              foreach (array(
							  
                              'news' 		=> 		'News',
                              'kids' 		=>     'Kids',
                              'the_prophet' =>    'The Prophet',
                              'history' 	=>    'History',
                              'society' 	=>    'Society',
                              'listen' 		=>    'Listen',
                              'quran' 		=>    'Quran',
                              'arabic_shows'	=>    'Arabic Shows',
                              'talk_islam' 		=>    'Talk Islam',
                              'living_muslim'	=>    'Living Muslim',
                              'spirituality' 	=>   'Spirituality',
                              'education' 		=>   'Education',
                              'premium' 		=>    'Premium'
                              )  as $key => $value)
                              {
                                  if (isset($videoDetail->playlist[0]
                                      ->category))
                                  {
                                      $selected = ($videoDetail->playlist[0]->category == $key) ? 'selected' : '';
                                  }
                                  echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                              }
                              ?> 
                        </select>
                     </div>
                     <div class="form-group v_s">
                        <label for="push">WordPress Post Id</label>
                        <input type="text" class="form-control" name="wordpress_post_id" value="<?php if (isset($videoDetail->playlist[0]
                           ->wordpress_post_id))
                           {
                           echo $videoDetail->playlist[0]->wordpress_post_id;
                           } ?>" id="V-name">
                     </div>
                     <div class="form-group ">
                        <label for="push">Push</label>
                        <div class="switchToggle">
                           <input type="checkbox" name="push" value="on" <?php if (isset($videoDetail->playlist[0]
                              ->push))
                              {
                              echo ($videoDetail->playlist[0]->push == 'on') ? 'checked' : '';
                              } ?> id="switch1">
                           <label for="switch1">Toggle</label>
                        </div>
                     </div>
                     <div class="form-group ">
                        <label for="inapp">In App</label>
                        <div class="switchToggle switch2">
                           <input type="checkbox" name="inapp" value="yes" <?php if (isset($videoDetail->playlist[0]
                              ->inapp))
                              {
                              echo ($videoDetail->playlist[0]->inapp == 'yes') ? 'checked' : '';
                              } ?> id="switch2">
                           <label for="switch2">Toggle</label>
                        </div>
                     </div>
                     <?php
                        if (isset($videoDetail->playlist[0]->category))
                        {
                            $display = ($videoDetail->playlist[0]->category == 'premium') ? 'block' : 'none';
                        }
                        else
                        {
                            $display = 'none';
                        }
                        
                        ?>
                     <div class="premium" style="display:<?php echo $display ?>">
                        <div class="form-group v_s">
                           <label for="seriesKey">Series key</label>
                           <input type="text" class="form-control" name="seriesKey" value="<?php if (isset($videoDetail->playlist[0]
                              ->seriesKey))
                              {
                              echo $videoDetail->playlist[0]->seriesKey;
                              } ?>" id="seriesKey">
                        </div>
                        <div class="form-group v_s">
                           <label for="seriesIndex">Series index</label>
                           <input type="text" class="form-control" name="seriesIndex" value="<?php if (isset($videoDetail->playlist[0]
                              ->seriesIndex))
                              {
                              echo $videoDetail->playlist[0]->seriesIndex;
                              } ?>" id="seriesIndex">
                        </div>
                     </div>
					 
					 <?php 
					 if(isset($_GET['ids'])){
						 
						 echo '<button type="submit" name="videos_submit" class="btn update_v">Update Videos</button>';
						 
					 }else{
						 echo '<button type="submit" name="submit" class="btn update_v">Update Videos</button>';
					 }
					 ?>
                     
                  </div>
               </div>
            </form>
            <div class="row">
               <div class="col-md-12 exprt_table">
                  <h1>Export</h1>

                  <!--*********************  Seach Filter *************************-->

                  <form>
                     <div class="row">
                        <div class="col-md-5">
                           <div class="form-group">     
                              <input type="text" placeholder="Search by video name or JW ID." class="form-control mb-1" name="search" value="<?php echo (isset($_GET['search'])) ? $_GET['search'] : ''; ?>"> 
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <select class="form-control mb-1" name="category">
                                 <option value="" selected disabled>Select Category</option>
                                 <?php
                                    $selected = '';
                                    foreach (array(
                                         'news' 		=> 		'News',
                              'kids' 		=>     'Kids',
                              'the_prophet' =>    'The Prophet',
                              'history' 	=>    'History',
                              'society' 	=>    'Society',
                              'listen' 		=>    'Listen',
                              'quran' 		=>    'Quran',
                              'arabic_shows'	=>    'Arabic Shows',
                              'talk_islam' 		=>    'Talk Islam',
                              'living_muslim'	=>    'Living Muslim',
                              'spirituality' 	=>   'Spirituality',
                              'education' 		=>   'Education',
                              'premium' 		=>    'Premium'
                                    )  as $key => $value)
                                    {
                                    
                                        echo '<option value="'.$key.'">' . $value . '</option>';
                                    }
                                    ?> 
                              </select>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <button type="submit" class="btn update_v">Search</button>
                           <a href="<?php echo $URL ?>csv.php" id="csv" class="btn btn-success">Export CSV</a>
                        </div>
                     </div>
                     <?php if (isset($_GET['search']))
                        { ?>
                     <a href="<?php echo $URL ?>" class="btn btn-info">Back</a>
                     <?php
                        } ?>
                  </form>

                  <!--*********************  Data Show *************************-->
			<form>
                  <table id="example" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                        <tr>
                           <th><button type="submit" class="btn">Edit</button></th>
                           <th>Videoname</th>
                           <th>JW ID</th>
                           <th>WordPress Post ID</th>
                           <th>Category</th>
                           <th>Push</th>
                           <th>In App</th>
                           <th>Series key</th>
                           <th>Series index</th>
                           <th>Tags</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           if ($videoList->status == 'ok')
                           {
                               $push = '';
                               $inapp = '';
                               foreach ($videoList->videos as $value)
                               {
                                   $custom = $value->custom;
                           
                                   $push = (isset($custom->push)) ? $custom->push : '';
                                   $inapp = (isset($custom->inapp)) ? $custom->inapp : '';
                           
                                   $wordpress_post_id = (isset($custom->wordpress_post_id)) ? $custom->wordpress_post_id : '';
                                   $seriesKey = (isset($custom->seriesKey)) ? $custom->seriesKey : '';
                                   $seriesIndex = (isset($custom->seriesIndex)) ? $custom->seriesIndex : '';
                                   $category = (isset($custom->category)) ? $custom->category : '';
                           
                                   echo '<tr>
           								<td><input name="ids[]" value="' . $value->key . '" type="checkbox"></td>
           								<td><a href="?jw_id=' . $value->key . '">' . $value->title . '</a></td>
           								<td>' . $value->key . '</td>
           								<td>' . $wordpress_post_id . '</td>
           								<td>' . $category . '</td>
           								<td>' . $push . '</td>
           								<td>' . $inapp . '</td>
           								<td>' . $seriesKey . '</td>
           								<td>' . $seriesIndex . '</td>
           								<td>' . $value->tags . '</td>
           							</tr>';
                           
                               }
                           }
                           
                           ?>
                  </table>
				  </form>
                  <?php
                     if ($videoList->offset != 0)
                     {
                         echo '<a href="?result_offset=' . ($videoList->offset - $videoList->limit) . '">Previous</a>';
                     }
                     $total = $videoList->total - $videoList->offset;
                     echo 'Showing ' . $videoList->offset . ' to ' . ($videoList->offset + $videoList->limit) . ' of ' . $videoList->total . ' entries  ';
                     
                     $offset = $videoList->offset + $videoList->limit;
                     echo '<a href="?result_offset=' . $offset . '">Next</a>';
                     
                     ?>
               </div>
            </div>
         </div>
      </section>
      <style>#example_paginate, #example_info {
         display: none;
         }
      </style>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>
      <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>
      <script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js" ></script>
      <script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.flash.min.js" ></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" ></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" ></script>
      <script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js" ></script>
      <script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.print.min.js" ></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" ></script>

      <!--*********************  Premium Funtionality *************************-->

      <script>
         $(document).ready(function() {
         	$("#sel1").change(function(){
         		
         		if($(this).val() == 'Premium'){
         			$(".premium").css("display","block");
         		}else{
         			$(".premium").css("display","none");
         			$("#seriesIndex").val("");
         			$("#seriesKey").val("");
         		}
         	});
         	$("#csv").click(function(){
         		 
         	});
         
             $('#example').DataTable( {
                 dom: 'Bfrtip',
         		"pageLength": 50,
         		"searching": false,
                 buttons: [
                     // 'csv'
                 ]
             } );
         } );
      </script>
   </body>
</html>