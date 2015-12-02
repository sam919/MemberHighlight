             <div id="memberHighlight">
             <h1> Member Hightlight </h1>
              <?  
                $queryBio = "SELECT m.member_id, m.first_name, m.last_name, p.position, m.bio, m.image_id, m.highlight_count
                    FROM members m
                    INNER JOIN position p ON p.position_id = m.position_id
                    INNER JOIN section s ON s.section_id = p.section_id
                    INNER JOIN (SELECT MAX(highlight_count) as Max from members) as Max
                    WHERE m.status_id =1 and m.highlight_count < Max.Max and m.image_id >= 0
                    ORDER BY member_id ASC 
                    LIMIT 1";
                $resultsetBio = mysql_query($queryBio);
                $bio = mysql_fetch_array($resultsetBio);
                $member_id = $bio['member_id'];
                $name = $bio['first_name']." ".$bio['last_name'];
                $position = $bio['position'];
                $mbio = $bio['bio'];
                $image_id = $bio['image_id'];
                if($image_id){
                $imageQuery = "SELECT * FROM image WHERE image_id = ".$image_id;
                $resultsetImage = mysql_query($imageQuery);
                $image = mysql_fetch_array($resultsetImage);
                $ilocation = $image['location'];
                $idesc = $image['image_desc'];
                }
                
                $now = time();
                $myfile = "member.txt";
                //$now = mktime(0,0,0,9,21,2014);
                if(file_exists($myfile)){
                   $mUpdate = fopen($myfile, "r");
                    $update= fgets($mUpdate);
                    //echo $update;
                }
                else {
                    $myfileopen = fopen($myfile, "w");
                    $txt = $name;
                    fwrite($myfileopen, $now);
                }
                $wDay = date("d",$update);
                $wMonth = date("m",$update);
                $wYear = date("y",$update);
                $start = mktime(0,0,0,$wMonth, $wDay, $wYear);   // start count from this date in secs
                $startvalue = 100;						//start  value
                $week = (($now - $start) / 604800);     //Week = 604800secs
                $week = intval($week);
                $value = (($week * 100) + $startvalue);
                //print("<br/>".$week);
                $sql="UPDATE members SET highlight_count = highlight_count + 1 WHERE member_id= ".$member_id;
                    //echo "Updated data successfully\n";
                //if($week == 0 and file_exists("member.txt")){
                //    unlink("member.txt");
                //}
                if($week > 0 ){
                    $retval = mysql_query( $sql );
                    if(! $retval )
                    {
                    die('Could not update data: ' . mysql_error());
                    }
                    $myfileopen = fopen($myfile, "w");
                    $txt = $name;
                    fwrite($myfileopen, $now); 
                }
                ?>
            <div id="memberBio">
            <div id="memberPic"><?if($image_id){?><img alt="<?php echo $idesc;?>" src="<? print("../../NewDesign/".$ilocation);?>"><?}?></div>
            <div id="memberName"><?print($name); ?></div>
            <?if($mbio)
            { 
                if(strlen($mbio) >380)
                    {
                    print(substr($mbio, ' ', strpos($mbio, ' ', 380))."... <a href=\"\">Full Bio</a>");
                    } else{print($mbio);} 
            }?>
                
                <!-- Example:  Jane Doe joined the Utah Premiere Brass during her high school
                years from 2004-2006 as a substitute in the tenor horn section. She became
                an official member from 2008-2010 and has returned as an official member once again.
                Rebecca started to pursue a career in French horn performance and and 
                played through her junior high and high school years, along with two years &#133 -->
                  
                </div><!-- memberBio -->
            
            </div><!--memberHighlight -->