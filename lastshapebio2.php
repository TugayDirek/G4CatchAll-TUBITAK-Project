<?php

//------------------------------VARİABLES----------------------------
session_start();
$checknumber = false;
$checkletter = false;


if(isset($_POST['minG2L'])){
$minG2L = $_POST['minG2L'];

}
if(isset($_POST['maxG2L'])){
$maxG2L = $_POST['maxG2L'];

}
if(isset($_POST['minG3L'])){
$minG3L = $_POST['minG3L'];

}
if(isset($_POST['maxG3L'])){
$maxG3L = $_POST['maxG3L'];

}
if(isset($_POST['minXL'])){
$minXL = $_POST['minXL'];

}
if(isset($_POST['maxXL'])){
$maxXL = $_POST['maxXL'];

}
if(isset($_POST['minMAX'])){
$minMAX = $_POST['minMAX'];
}
if(isset($_POST['maxMAX'])){
$maxMAX = $_POST['maxMAX'];
$max_GQ_length2 = $maxMAX;
}
if(isset($_POST['Iparameter'])){
$Iparameter = $_POST['Iparameter'];

}
if(isset($_POST['Bparameter'])){
$Bparameter = $_POST['Bparameter'];

}
if(isset($_POST['Eparameter'])){
$Eparameter = $_POST['Eparameter'];

}
if(isset($_POST['Rparameter'])){
	$Rparameter = $_POST['Rparameter'];

}
if(isset($_POST['Fparameter'])){
	$Fparameter = $_POST['Fparameter'];

}
if(isset($_POST['Mparameter'])){
	$Mparameter = $_POST['Mparameter'];

}


//---------------------------------VARİABLES----------------------------


$G2sAllowed = FALSE;

//$shrtLoopMin = "1";
//$shrtLoopMax = "2";

if(isset($_POST['minG2L'])){
$minG2L = $_POST['minG2L'];
$shrtLoopMin = $minG2L;

}
if(isset($_POST['maxG2L'])){
$maxG2L = $_POST['maxG2L'];
$shrtLoopMax = $maxG2L;

}

if(!isset($_POST['minG2L'])){
$shrtLoopMin = "0";

}
if(!isset($_POST['maxG2L'])){
$shrtLoopMax = "0";

}

if($shrtLoopMin != "0" || $shrtLoopMax != "0"){
	$G2sAllowed = TRUE;
}

$typLoopMin ="1";
$typLoopMax = "8";


if(isset($_POST['minG3L'])){
$minG3L = $_POST['minG3L'];
$typLoopMin = $minG3L;

}
if(isset($_POST['maxG3L'])){
$maxG3L = $_POST['maxG3L'];
$typLoopMax = $maxG3L;

}



$ExtremeAllowed = false;
$ExtremeAllowedForG2s = false;

//$extLoopMin = "1";
//$extLoopMax = "30";


if(isset($_POST['minXL'])){
$minXL = $_POST['minXL'];
$extLoopMin = $minXL;

}
if(isset($_POST['maxXL'])){

$maxXL = $_POST['maxXL'];
$extLoopMax = $maxXL;
}

if(!isset($_POST['minXL'])){
$extLoopMin = "0";

}
if(!isset($_POST['maxXL'])){
$extLoopMax = "0";

}

//$Eparameter = "3";
//$Iparameter = 1;
//$Bparameter = FALSE;
//$Rparameter = true;

if($extLoopMin != "0" || $extLoopMax != "0"){
	$ExtremeAllowed = TRUE;
}
if($Eparameter == "2"){
	$ExtremeAllowedForG2s = TRUE;
}
if($Eparameter == "3" || $Eparameter == "0"){
	$ExtremeAllowedForG2s = FALSE;
}
$ImperfectTractsAllowed = $Iparameter;
//$ImperfectTractsAllowed = "2";
//$BulgedTractsOnly = $Bparameter;
if($Bparameter == "N"){
	$BulgedTractsOnly = FALSE;
}else if($Bparameter == "Y"){
	$BulgedTractsOnly = TRUE;
}
if(!$G2sAllowed || !$ExtremeAllowed){
	$ExtremeAllowedForG2s = false;
}

if($Fparameter == "N"){
	$InclFlanks = false;
}else if($Fparameter == "Y"){
	$InclFlanks = true;
}

if($Mparameter == "N"){
	$MergeOverlapping = false;
}else if($Mparameter == "Y"){
	$MergeOverlapping = true;
}

//$InclFlanks = false;
//$MergeOverlapping = true;//meybeeeeee

if($Rparameter =="Y"){
	$NoReverse = false;
}else if($Rparameter == "N"){
	$NoReverse = true;
}
//$NoReverse = $Rparameter;

//-------------------------REGEX--------------------------------------



 $bulgeOnly="[Gg]{2,}[ATUCatuc][Gg]+|[Gg]+[ATUCatuc][Gg]{2,}";
 $mismatch="[Gg]{2,}|[Gg]+[ATUCatuc][Gg]+";
 $Dimp1='(?J)(?P<imp1>)';//$Dimp1 = "?";//
 $Dimp2='(?J)(?P<imp2>)';//$Dimp2 = "?";//
 $imp='('.$mismatch.')';
 if ($BulgedTractsOnly){
	 $imp='('.$bulgeOnly.')';
 }
 $Timp1='?(imp1)';//$Timp1 = "?";//
 $Timp2='?(imp2)';//$Timp2 = "?";//
 $shrt='\w{'.$shrtLoopMin.','.$shrtLoopMax.'}';
$Tshrt='?(G2GQ)';// $Tshrt = "?";//
 $Dshrt='(?J)(?P<G2GQ>[Gg]{2})';//?P<G2GQ>
 $typ='\w{'.$typLoopMin.','.$typLoopMax.'}';
 $ext='\w{'.$extLoopMin.','.$extLoopMax.'}';
$Dext='(?J)(?P<extLoop>)'; //$Dext = "?";//
$Text='?(extLoop)';// $Text= "?";//

//# Construct Tract 1:
 $Tract1='[Gg]{3,}';
if ($ImperfectTractsAllowed=="1" || $ImperfectTractsAllowed=="2"){
	 $Tract1=$Tract1.'|('.$Dimp1.$imp.')';
}
 //$G2sAllowed = true;
 if($G2sAllowed){
	 $Tract1=$Tract1.'|('.$Dshrt.')';
 }
// # Construct Loop 1:
 $Loop1=$typ;
 if ($ExtremeAllowed){
	 $Loop1=$Loop1.'|('.$Dext.$ext.')';
 }
 if ($G2sAllowed){
    $shrtAdd = $shrt;
    if ($ExtremeAllowedForG2s){
		$shrtAdd = $shrtAdd . '|(' . $Dext . $ext.')';
    }
	$Loop1 = $Tshrt . '(' . $shrtAdd . ')|('.$Loop1.')';
 }
 
// # Construct Tract 2:
 $Tract2='[Gg]{3,}';
 if ($ImperfectTractsAllowed=="2"){
	 $Tract2=$Tract2.'|('.$Dimp2.$imp.')';
 }
 if ($ImperfectTractsAllowed=="1" || $ImperfectTractsAllowed=="2"){
	 $Tract2=$Timp1.'('.$Tract2.')|([Gg]{3,}|('.$Dimp1.$imp.'))';//sonra
 }
 if ($G2sAllowed){
	 $Tract2=$Tshrt.'[Gg]{2,}|('.$Tract2.')';
 }
// # Construct Loop 2:
 $Loop2=$typ;
 if ($ExtremeAllowed){
	 $Loop2=$Text.$Loop2.'|('.$typ.'|('.$Dext.$ext.'))';
 }
	 if ($G2sAllowed){
    $shrtAdd=$shrt;
    if ($ExtremeAllowedForG2s){
		$shrtAdd = $Text. $shrtAdd . '|('.$shrt.'|(' . $Dext . $ext.'))';
	 }   
   $Loop2=$Tshrt.'('.$shrtAdd.')|('.$Loop2.')';
 }
 
// # Construct Tract 3:
 $Tract3='[Gg]{3,}';
 if ($ImperfectTractsAllowed=="2"){
	 $Tract3=$Timp2.$Tract3.'|([Gg]{3,}|('.$Dimp2.$imp.'))';
 }
 if ($ImperfectTractsAllowed=="1" || $ImperfectTractsAllowed=="2"){
	 $Tract3=$Timp1.'('.$Tract3.')|([Gg]{3,}|('.$Dimp1.$imp.'))';
 }
 if ($G2sAllowed){
 $Tract3=$Tshrt.'[Gg]{2,}|('.$Tract3.')';
}
 
 
 
 //---------------------------------xxxx------------------------
 //---------------------------xxxx-------------------------------
 
 
  $reg="(".$Tract1.")(".$Loop1.")(". $Tract2.")(".$Loop2.")(".$Tract3.")(".$Loop2.")(".$Tract3.")";
 if ($InclFlanks){
	 $reg=/*r*/'\w'.$reg./*r*/'\w';
 }



//""" Reverse forward match """
 $intab = 'actguACTGU';
 $outtab = 'tgacaTGACA';
$regrev="";
 if($NoReverse==false){
     $regrev = strtr($reg,$intab, $outtab);
     //$regrev = reg.translate(transtab)
 } 
 else
     $regrev = '';


 






//---------------------------REGEX--------------------------------------



function G4HScore($seq,$minRepeat,$penalizeGC){
    $i=0;
    $baseScore=array();
	//unset($baseScore);
    //$baseScore =  array();
	$baseScore2 = array();
    while($i<strlen($seq)){
		$tractScore =  array();
		//unset($tractScore);
        //$tractScore =  array();//[0];
		//$tractScore2 = array();
        $k=1;
        $GTract=false;
		//$i+=1;
		//echo $seq[$i];echo $i;
        while($seq[$i]=="G"){ 
		//$min = (min($k-1,4));
		unset($tractScore);
        $tractScore =  array();
        for($ia = 0;$ia<$k ; $ia++){
      
         array_push($tractScore,min($k-1,4) );
		 //array_push($tractScore2,min($k-1,4) );
         } //derivation from original algorithm: tractScore=[min(k-1,16)]*k
            // region derivation from original algorithm: if prev is "C" apply bigger penalty. penalizes GCs
            if ($penalizeGC){
              //  try{
                  //  pass
                    if ($seq[$i-$k]=="C"){
						//$baseScore[count($baseScore)-1]=-2;
						$baseScore[count($baseScore)-1] = -2;
						//array_push($baseScore2,-2);
					}
				//}
              /*  catch(Exception $e){
					//   pass
				}*/
			}///# endregion
            $k++;
            $i++;
            $GTract=True;
	if ($i==strlen($seq))
		break;
	}
        if(!$GTract){
            while ($seq[$i]=="C"){
                //$tractScore=[max(-$k+1,-4)]*$k;
				unset($tractScore);
                $tractScore =  array();
				for($ii = 0;$ii< $k ; $ii++){
      
                array_push($tractScore,max(-$k+1,-4));
				//array_push($tractScore2,max(-$k+1,-4));
                }
	                if ($penalizeGC){
                 //   try{
                        if ($seq[$i-$k]== "G"){
							//$baseScore[count($baseScore)-1] = 2;
							$baseScore[count($baseScore)-1] = 2;
							array_push($baseScore2,2);
						}
				//	}
                  /*  catch(Exception $e){
                        //pass
					}*/
                }//# endregion
                $k++;
                $i++;
                $GTract=True;
		if ($i == strlen($seq)){
			break;
		}
		}}
        //$baseScore=$baseScore+($tractScore);//__add__
		//echo "before base";
		///print_r($baseScore);
		//echo "before tract";
		//print_r($tractScore);
		//$baseScoree = $baseScore;
		//$tractScoree = $tractScore;
		//$result=array_merge($baseScoree,$tractScoree);
        $baseScore=array_merge($baseScore,$tractScore);
	//	 $result=array_merge($baseScore2,$tractScore2);
		//$baseScore=$baseScore+($tractScore);
        //echo "after base";
		//print_r($baseScore);
		if(!$GTract){
			$i++;
		}
	}//# print baseScore}
   

   $Score=0;
    foreach($baseScore as $value){
	  $Score+=$value;
	}
	
	/*$Score2=0;
    foreach($result as $value2){
	 $Score2+=$value2;
	}*/
	
//	$Score += $Score2;
	 /*   echo "before base";
		print_r($baseScore);
		echo "before tract";
		print_r($tractScore);
	
	echo $Score;//echo "score2";echo $Score2;
	echo "--";echo $Score2;echo "--";
	echo strlen($seq);	echo "--";*/
	//echo $Score;echo "--";echo $Score2;echo "--";
    return floatval($Score)/(strlen($seq));
}


function ReverseComplement($seq){
    //$seq1 = 'ATCGNWSMKRYBDHVatcgnwsmkrybdhv';
    //$seq2 = 'TAGCNWSKMYRVHDBtagcnwskmyrvhdb';
	
	
	
	$seq_dict = array("A" => "T", "T" => "A", "G" => "C", "C" => "G", "a" => "t", "t" => "a", "c" => "g", "g" => "c", "n" => "n", "N" => "N");
	//$REVSEQ = strrev($seq);
	
	$resultseq = "";
	
	for($i = 0; $i < strlen(($seq)); $i++){
		
		$resultseq = $resultseq.($seq_dict[strrev($seq)[$i]]);
	}
	
	return $resultseq;
}


 //$reg="(".$Tract1.")(".$Loop1.")(". $Tract2.")(".$Loop2.")(".$Tract3.")(".$Loop2.")(".$Tract3.")";
 $intab = 'actguACTGU';
 $outtab = 'tgacaTGACA';
     $regrev = strtr($reg,$intab, $outtab);
 
 $chr = " ";
 
 
  $contentlength = 0;
 $sequencelength = 0;
 $file;
 if(isset($_FILES['download']['tmp_name'])&&!empty($_FILES['download']['tmp_name'])){
$file = $_FILES['download']['tmp_name'];
$content = file_get_contents($file);

$contentlength = strlen($content);
}


if(isset($_POST['sequence'])){
$sequence = $_POST['sequence'];

$sequencelength = strlen($sequence);
}

// $refseq = "nnn";

// if($contentlength > 0){
//     $content = str_replace(' ', '', $content);
//	 $refseq = $content;
// }

// elseif($sequencelength > 0){
//	$sequence = str_replace(' ', '', $sequence);
//	$sequence = str_replace('<br>', '', $sequence);
//	$refseq = trim(preg_replace('/\s\s+/', '', $sequence));
//
// }

 //$max_GQ_length2 = 0;
 $max_GQ_length = false;
 if($maxMAX != "0")
	 $max_GQ_length = true;
//$refseq ="TTGGGTTGGGACTGGGTACGGGAATAAATAGGTTAGGAATGGATAGGAT";TTGGGTTTTGGGTTTTGGGTTTTGGGTTTTGGGTT
 $G4HThreshold = 0;
 //echo $reg;
  $regrev = "(?=(".$regrev."))";
 //$reg="([Gg]{1,3})";
 $reg = "(?=(".$reg."))";
 $gquad_list = array();
 
 $file2 = fopen($file, "r");
 


//echo $content;
//$chr = preg_replace("(>)", "", $line);
//echo $chr;
//$line = fgets($file2);$line = str_replace(' ', '', $line);
//echo $line;
$ref_seq = " ";
$new_seq = " ";
$refseq = " ";

$separator = "\n\r";
if ($contentlength > 0){
    $line = fgets($file2);	//$line = str_replace(' ', '', $line);
    }else if($sequencelength > 0){
    $line =strtok($_POST['sequence'], $separator);//$line = str_replace(' ', '', $line);
}
 while(TRUE){

		while(!(substr( $line, 0, 1 ) == ">")){
		$refseq = $refseq.$line;
		//echo $line."<br>";

		if ($contentlength > 0){
        $line = fgets($file2);	$line = str_replace(' ', '', $line);
        }else if($sequencelength > 0){
        $line =strtok( $separator);$line = str_replace(' ', '', $line);
		//$line = strtok(" ");
        }
		//$line = fgets($file2);$line = str_replace(' ', '', $line);
		if($line == ""){
			break;
		}
	}
$refseq = trim(preg_replace('/\s\s+/', '', $refseq));

 preg_match_all("/".$reg."/" ,$refseq,  $matches,PREG_OFFSET_CAPTURE);
print_r($matches);




      if(preg_match_all("/".$reg."/" ,$refseq,  $matches,PREG_OFFSET_CAPTURE)){

     foreach ($matches[1] as $m){
		 echo "m0";
		 echo $m[0];
		 echo $m[1];
        if (!$max_GQ_length || strlen($m[0])<=$max_GQ_length2){
			echo "firstfirst";
		if ($MergeOverlapping && count($gquad_list)>0 && $gquad_list[count($gquad_list)-1][4]=="+" && $m[1]<=$gquad_list[count($gquad_list)-1][2] && $chr==$gquad_list[count($gquad_list)-1][0]){
                echo "first";
				$orj=$gquad_list[count($gquad_list)-1];
				//echo "orj2a".$orj[2].$m[1]."orj2";
				//echo $m[0];
				//echo "m0orj2".$m[0][$orj[2]-$m[1]]."mm";
				$new_seq = $orj[5];
				if(strlen($m[0])>$orj[2]-$m[1]){
				//echo "heyyyyyyyyyyyyy";
				//try{
                //$new_seq=$orj[5].$m[0][$orj[2]-$m[1]];

				for($i = $orj[2]-$m[1];$i < strlen($m[0]);$i++){
					$new_seq = $new_seq.$m[0][$i];
				}
                //}catch(Exception $e){}
				}
				$G4Hscore=G4HScore($new_seq,2,True);
                if (abs($G4Hscore)>=($G4HThreshold)){
                    //print_r($gquad_list);
					echo "first2";
					$gquad_list[count($gquad_list)-1]=array($chr, $orj[1], $m[1]+strlen($m[0]), $m[1]+ strlen($m[0])-$orj[1], '+', $new_seq,$new_seq,G4HScore($new_seq,2,True));
					//array_push($gquad_list,[$chr, $orj[1], $m[1]+strlen($m[0]), $m[1]+ strlen($m[0])-$orj[1], '+', $new_seq,$new_seq,G4HScore($new_seq,2,True),"..."]);

					//print_r($gquad_list);
				}
            }
			else{
                $G4Hscore=G4HScore($m[0],2,True);
				echo "else";
                if (abs($G4Hscore)>=($G4HThreshold)){
					echo "else if";
					//echo $m[0];
                    array_push($gquad_list, [$chr, $m[1], $m[1]+strlen($m[0]/*[0]*/), strlen($m[0]), '+', $m[0],$m[0],G4HScore($m[0],2,True)]);//  # modification: added sequence again
					//$gquad_list[count($gquad_list)-1]= array($chr, $m[1], $m[1]+strlen($m[0]/*[0]*/), strlen($m[0]), '+', $m[0],$m[0],G4HScore($m[0],2,True),"...");//  # modification: added sequence again
					//print_r($gquad_list);
	 }}}}}
preg_match_all("/".$regrev."/" ,$refseq,  $matches2,PREG_OFFSET_CAPTURE);
//print_r($matches2);
	if ($NoReverse == false){
		echo "reverse";
        if (!$max_GQ_length || strlen($m[0]) <= $max_GQ_length2){
			echo "reverse2";
			if(preg_match_all("/".$regrev."/" ,$refseq,  $matches2,PREG_OFFSET_CAPTURE)){
            foreach ($matches2[1] as $m){
				echo "reverse2for";
                if ($MergeOverlapping && (count($gquad_list) > 0) && $gquad_list[count($gquad_list)-1][4]=="-" && $m[1] <= $gquad_list[count($gquad_list)-1][2] && ($chr == $gquad_list[count($gquad_list)-1][0])){
                    echo "reverse3";
					$orj = $gquad_list[count($gquad_list)-1];
                    //$new_seq = $orj[5] + $matches2[0][0][0][$orj[2] - $m[1]];

					$new_seq = $orj[5];
				if(strlen($m[0])>$orj[2]-$m[1]){
				//echo "heyyyyyyyyyyyyy";
				//try{
                //$new_seq=$orj[5].$m[0][$orj[2]-$m[1]];

				for($i = $orj[2]-$m[1];$i < strlen($m[0]);$i++){
					$new_seq = $new_seq.$m[0][$i];
				}
                //}catch(Exception $e){}
				}

                    $G4Hscore = G4HScore($new_seq, 2, True);
                    if (abs($G4Hscore) >= ($G4HThreshold)){
                        $gquad_list[count($gquad_list)-1] = array($chr, $orj[1], $m[1]+strlen($m[0]), $m[1]+strlen($m[0]) - $orj[1], '-', $new_seq,ReverseComplement($new_seq),G4HScore($new_seq,2,True));
				}}
                else{
                    //echo "-----------------".$matches2[0][0][0];
                    $G4Hscore = G4HScore($m[0], 2, True);
                    if (abs($G4Hscore) >= ($G4HThreshold)){
						echo "reverse4";
					array_push($gquad_list,[ $chr, $m[1], $m[1]+strlen($m[0]), strlen($m[0]), '-', $m[0],ReverseComplement($m[0]), G4HScore($m[0],2,True)]);  //# modification: added reverse complement

		}}}}}}


		$chr = preg_replace("(>)", "", $line);
		echo $chr;
	$refseq = "";

		if ($contentlength > 0){
        $line = fgets($file2);//	$line = str_replace(' ', '', $line);
        }else if($sequencelength > 0){
        $line =strtok( $separator);$line = str_replace(' ', '', $line);
        }


	//$line = fgets($file2);$line = str_replace(' ', '', $line);
	if($line == ""){
		break;
	}
 }
 //echo $ref_seq;

	//print_r($gquad_list);								   
//	session_start();ECHO "-----------".$matches[0][0][1];
$_SESSION['result'] = $gquad_list;



/*
if ($NoReverse == false){
        if (!$max_GQ_length || strlen($matches[0][0][0]) <= $max_GQ_length2){
			if(preg_match_all("/".$regrev."/" ,$refseq,  $matches2,PREG_OFFSET_CAPTURE)){
            foreach ($matches2[0] as $m){
                if ($MergeOverlapping && (count($gquad_list) > 0) && $gquad_list[count($gquad_list)-2][4]=="-" && $matches2[1] <= $gquad_list[count($gquad_list)-2] && ($chr == $gquad_list[count($gquad_list)-1][0])){
                    $orj = $gquad_list[count($gquad_list)-1];
                    $new_seq = $orj[5] + $matches2[0][0][0][$orj[2] - $matches2[0][0][1]];
                    
                    $G4Hscore = G4HScore($new_seq, 2, True);
                    if (abs($G4Hscore) >= ($G4HThreshold)){
                        $gquad_list[count($gquad_list)-1] = array($chr, $orj[1], $matches2[0][0][1]+strlen($matches2[0][0][0]), $matches2[0][0][1]+strlen($matches2[0][0][0]) - $orj[1], '-', $new_seq,ReverseComplement($new_seq),G4HScore($new_seq,2,True));
				}}
                else{
                    echo "-----------------".$matches2[0][0][0];
                    $G4Hscore = G4HScore($matches2[0][0][0], 2, True);
                    if (abs($G4Hscore) >= ($G4HThreshold)){
					array_push($gquad_list, $chr, $matches2[0][0][1], $matches2[0][0][1]+strlen($matches2[0][0][0]), strlen($matches2[0][0][0]), '-', $matches2[0][0][0],ReverseComplement($matches2[0][0][0]), G4HScore($matches2[0][0][0],2,True));  //# modification: added reverse complement

		}}}}}}

*/

?>