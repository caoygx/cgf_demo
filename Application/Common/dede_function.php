<?php
/**
 *  文档自动分页
 *
 * @access    public
 * @param     string  $mybody  内容
 * @param     string  $spsize  分页大小
 * @param     string  $sptag  分页标记
 * @return    string
 */
function SpLongBody($mybody, $spsize, $sptag)
{
    if(strlen($mybody) < $spsize)
    {
        return $mybody;
    }
    $mybody = stripslashes($mybody);
    $bds = explode('<', $mybody);
    $npageBody = '';
    $istable = 0;
    $mybody = '';
    foreach($bds as $i=>$k)
    {
        if($i==0)
        {
            $npageBody .= $bds[$i]; continue;
        }
        $bds[$i] = "<".$bds[$i];
        if(strlen($bds[$i])>6)
        {
            $tname = substr($bds[$i],1,5);
            if(strtolower($tname)=='table')
            {
                $istable++;
            }
            else if(strtolower($tname)=='/tabl')
            {
                $istable--;
            }
            if($istable>0)
            {
                $npageBody .= $bds[$i]; continue;
            }
            else
            {
                $npageBody .= $bds[$i];
            }
        }
        else
        {
            $npageBody .= $bds[$i];
        }
        if(strlen($npageBody)>$spsize)
        {
            $mybody .= $npageBody.$sptag;
            $npageBody = '';
        }
    }
    if($npageBody!='')
    {
        $mybody .= $npageBody;
    }
    return addslashes($mybody);
}

function ShowLongBody($mybody, $spsize, $sptag)
{
    $bodylen = strlen($mybody);
	$reckonPageNum = $bodylen / $spsize; //预估能分多少而，如果第一次explode页数小于此页，则进行下一个explode
	$reckonPageNum  = 2;
	if($bodylen < $spsize)
    {
        return array($mybody);
    }
	
	$arr = splitBody($mybody,'',$reckonPageNum);
	
/*	$spliter = '</p>';
	$arr = explode($spliter,$mybody);
	
	if(count($arr) < $reckonPageNum){
		$spliter = '<br />';
		$arr = explode($spliter,$mybody);
		if(count($arr) < $reckonPageNum){
			$spliter = '<br>';
			$arr = explode($spliter,$mybody);
		}
	}
*/
	$temp = '';
	$c = count($arr);
	for($i = 0; $i < $c; $i+=2){
		if($i != $c-1)
			$temp .= $arr[$i].$arr[$i+1];
		//var_dump($temp);
		//var_dump($arr[)	
		if(strlen($temp) >= $spsize){
			$pageContent[] = $temp;
			$temp = '';
			
		}
	}
	if(!empty($temp)){ //末尾不足分页大小的部分
		$pageContent[] = $temp;
	}
	//print_r($pageContent);exit;
	return $pageContent;
}

function splitBody($str,$spliter,$reckonPageNum){
	$r = preg_split('/(<\/p>|<br>|<br \/>|<\/div>)/',$str,-1,PREG_SPLIT_DELIM_CAPTURE);
	return $r;
	
	print_r($r);exit('---------');
	//先查找分隔符数量，然后选取最接近预估数的作为分隔符 ,如果每个分隔块与分块大小之差大于50%,则需两次分割
	$spliters = array('</p>', '<br>','<br />', '</div>');
	$spliter_nums = array();
	foreach($spliters as $v){
		//echo $v;
		$spliter_nums[] = substr_count($str,$v);
	}
	var_dump($spliter_nums);exit;
	
	$spliter = '</p>';
	$pnum = substr_count($str,$spliter);
	
	$spliter = '<br />';
	$bnum = substr_count($str,$spliter);
	 
	$spliter = '<br>';
	$b2num = substr_count($str,$spliter);
	
	$spliter = '</div>';
	$dnum = substr_count($str,$spliter);
	
	max(array($pnum,$b2num,$bnum,$dnum));
	
}


/**
 *  文档自动分页
 *
 * @access    public
 * @param     string  $mybody  内容
 * @param     string  $spsize  分页大小
 * @param     string  $sptag  分页标记
 * @return    string
 */
function ShowLongBodyxxxxx($mybody, $spsize, $sptag)
{
    if(strlen($mybody) < $spsize)
    {
        return $mybody;
    }
    $mybody = stripslashes($mybody);
    $bds = explode('</', $mybody);
    $npageBody = '';
    $istable = 0;
    $mybody = '';
	$pageContent = array();
    foreach($bds as $i=>$k)
    {
        if($i==0)
        {
            $npageBody .= $bds[$i]; continue;
        }
        $bds[$i] = "</".$bds[$i];
        if(strlen($bds[$i])>6)
        {
            $tname = substr($bds[$i],1,5);
            if(strtolower($tname)=='table')
            {
                $istable++;
            }
            else if(strtolower($tname)=='/tabl')
            {
                $istable--;
            }
            if($istable>0)
            {
                $npageBody .= $bds[$i]; continue;
            }
            else
            {
                $npageBody .= $bds[$i];
            }
        }
        else
        {
            $npageBody .= $bds[$i];
        }
        if(strlen($npageBody)>$spsize)
        {
            $pageContent[] = $npageBody.$sptag;
            $npageBody = '';
        }
    }
    if($npageBody!='')
    {
        $mybody .= $npageBody;
    }
	
	print_r($pageContent);
	return $pageContent;
    return addslashes($mybody);
}



?>