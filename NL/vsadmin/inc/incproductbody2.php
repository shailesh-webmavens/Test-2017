<?php
//This code is copyright (c) Internet Business Solutions SL, all rights reserved.
//The contents of this file are protected under law as the intellectual property of Internet
//Business Solutions SL. Any use, reproduction, disclosure or copying of any kind 
//without the express and written permission of Internet Business Solutions SL is forbidden.
//Author: Vince Reid, vince@virtualred.net
$prodoptions='';
$extraimages=0;
if(@$imgcheckoutbutton=='') $imgcheckoutbutton='images/checkout.gif';
if(@$cs=='')$cs='';
$localcount=0;
if(@$currencyseparator=='') $currencyseparator=' ';
if(@$_SESSION['clientID']=='' || @$enablewishlists==FALSE || @$wishlistonproducts=='') $wishlistonproducts=FALSE;
if(@$overridecurrency!=TRUE || @$orcdecimals=='') $orcdecimals='.';
if(@$overridecurrency!=TRUE || @$orcthousands=='') $orcthousands=',';
productdisplayscript(@$noproductoptions!=TRUE,FALSE);
if(! @$usecsslayout) print '<table class="' . $cs . 'products" width="100%" border="0" cellspacing="0" cellpadding="3">';
if(@$productcolumns=="") $productcolumns=1;
if(! (@isset($showcategories) && @$showcategories==FALSE)){
	if(! @$usecsslayout) print '<tr><td colspan="' . $productcolumns . '"><div class="pation"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';
	print '<div class="pagin"><' . (@$usecsslayout ? 'div' : 'td align="left"') . ' class="prodnavigation">' . $sstrong . (! @$usecsslayout ? '' : '') . $tslist . (! @$usecsslayout ? '' : '') . $estrong . '</' . (@$usecsslayout ? 'div' : 'td') . '><div class="chrgb">' . "\r\n";
	if(! @$usecsslayout) print '</tr></table></td></tr>' . "\r\n";
	if(file_exists("pagecontent/".$catid.".html")){
    	echo file_get_contents("pagecontent/link.html");
    }else{
    	//echo "did not find the file :"."pagecontent/".$catid.".html";
    }
	print '<' . (@$usecsslayout ? 'div' : 'td align="right"') . ' class="checkoutbutton">' . (@$nobuyorcheckout!=TRUE ? imageorbutton($imgcheckoutbutton,$xxCOTxt,'checkoutbutton','cart.php', FALSE) : '') . '</' . (@$usecsslayout ? 'div' : 'td') . '></div></div>' . "\r\n";
	
}

        if(file_exists("pagecontent/".$catid.".html")){
        	echo file_get_contents("pagecontent/".$catid.".html");
        }else{
        	//echo "did not find the file :"."pagecontent/".$catid.".html";
         }

	
if(@$isproductspage) dofilterresults($productcolumns);
if(@$nowholesalediscounts==TRUE && @$_SESSION["clientUser"]!="")
	if((($_SESSION["clientActions"] & 8) == 8) || (($_SESSION["clientActions"] & 16) == 16)) $noshowdiscounts=TRUE;
if(@$noshowdiscounts != TRUE){
	$sSQL = "SELECT DISTINCT ".getlangid("cpnName",1024)." FROM coupons LEFT OUTER JOIN cpnassign ON coupons.cpnID=cpnassign.cpaCpnID WHERE (";
	$addor = "";
	if($catid != "0"){
		$sSQL .= $addor . "((cpnSitewide=0 OR cpnSitewide=3) AND cpaType=1 AND cpaAssignment IN ('" . str_replace(",","','",$topsectionids) . "'))";
		$addor = " OR ";
	}
	$sSQL .= $addor . "(cpnSitewide=1 OR cpnSitewide=2)) AND cpnNumAvail>0 AND cpnEndDate>='" . date("Y-m-d",time()) ."' AND cpnIsCoupon=0 AND ((cpnLoginLevel>=0 AND cpnLoginLevel<=".$minloglevel.") OR (cpnLoginLevel<0 AND -1-cpnLoginLevel=".$minloglevel.")) ORDER BY cpnID";
	$result2 = mysql_query($sSQL) or print(mysql_error());
	if(mysql_num_rows($result2) > 0){
		if(! @$usecsslayout) print '<tr><td align="left" class="allproddiscounts" colspan="' . $productcolumns . '">';
		print '<div class="discountsapply allproddiscounts"' . (@$nomarkup?'':' style="font-weight:bold;"') . '>' . $xxDsProd . '</div><div class="proddiscounts allproddiscounts"' . (@$nomarkup?'':' style="font-size:9px;color:#FF0000;"') . '>';
		while($rs2=mysql_fetch_assoc($result2)){
			print $rs2[getlangid('cpnName',1024)] . '<br />';
		}
		print '</div>';
		if(! @$usecsslayout) print '</td></tr>';
	}
	mysql_free_result($result2);
}
	if($iNumOfPages > 1 && @$pagebarattop==1){
		if(@$usecsslayout) print '<div class="pagenums" style="width:100%">' . "\r\n"; else print '<tr><td colspan="' . $productcolumns . '" align="center" class="pagenums"><p class="pagenums">';
		print writepagebar($CurPage,$iNumOfPages,$xxPrev,$xxNext,$pblink,$nofirstpg);
		if(@$usecsslayout) print '</div>' . "\r\n"; else print '<br /><img src="images/clearpixel.gif" width="50" height="5" alt="" /></p></td></tr>';
	}
	if(@$usecsslayout) print '<div class="' . $cs . 'products">';
	$totrows = mysql_num_rows($allprods);
	if(mysql_num_rows($allprods) == 0)
		print (! @$usecsslayout ? '<tr><td colspan="' . $productcolumns . '" align="center">' : '') . '<p>'.$xxNoPrds.'</p>' . (! @$usecsslayout ? '</td></tr>' : '');
	else while($rs = mysql_fetch_array($allprods)){
		$thedetailslink = 'proddetail.php?prod=' . urlencode($rs['pId']) . (@$catid!='' && @$catid != '0' && $catid != $rs['pSection'] && @$nocatid != TRUE ? '&amp;cat=' . $catid : '');
		$allimages='';
		$numallimages=0;
		$needdetaillink=trim(str_replace('<br />','',$rs[getlangid('pLongDescription',4)]))!='';
		$result2 = mysql_query("SELECT imageSrc FROM productimages WHERE imageType=0 AND imageProduct='" . escape_string($rs['pId']) . "' ORDER BY imageNumber") or print(mysql_error());
		while($rs2 = mysql_fetch_assoc($result2)) $allimages[$numallimages++]=$rs2;
		mysql_free_result($result2);
		if((@$forcedetailslink!=TRUE && ! $needdetaillink) || @$detailslink!=''){
			$result2 = mysql_query("SELECT imageSrc FROM productimages WHERE imageType=1 AND imageProduct='" . escape_string($rs['pId']) . "' ORDER BY imageNumber LIMIT 0,1") or print(mysql_error());
			if($rs2 = mysql_fetch_assoc($result2)){ $needdetaillink=TRUE; $plargeimage=$rs2['imageSrc']; }
			mysql_free_result($result2);
		}
		if(@$forcedetailslink==TRUE || $needdetaillink){
			if($rs['pStaticPage'] != 0){
				$thedetailslink = cleanforurl($rs[getlangid('pName',1)]) . '.php' . (@$catid!='' && @$catid != '0' && $catid != $rs['pSection'] && @$nocatid != TRUE ? '?cat=' . $catid : '');
				$startlink='<a class="ectlink" href="' . $thedetailslink . '">';
				$endlink='</a>';
			}elseif(@$detailslink!=''){
				$startlink=str_replace('%pid%', $rs['pId'], str_replace('%largeimage%', $plargeimage, $detailslink));
				$endlink=@$detailsendlink;
			}else{
				$startlink='<a class="ectlink" href="'. $thedetailslink .'">';
				$endlink='</a>';
			}
		}else{
			$startlink='';
			$endlink='';
		}
		for($cpnindex=0; $cpnindex < $adminProdsPerPage; $cpnindex++) $aDiscSection[$cpnindex][0] = "";
		if(! $isrootsection){
			$thetopts = $rs["pSection"];
			$gotdiscsection = FALSE;
			for($cpnindex=0; $cpnindex < $adminProdsPerPage; $cpnindex++){
				if($aDiscSection[$cpnindex][0]==$thetopts){
					$gotdiscsection = TRUE;
					break;
				}elseif($aDiscSection[$cpnindex][0]=="")
					break;
			}
			$aDiscSection[$cpnindex][0] = $thetopts;
			if(! $gotdiscsection){
				$topcpnids = $thetopts;
				for($index=0; $index<= 10; $index++){
					if($thetopts==0)
						break;
					else{
						$sSQL = "SELECT topSection FROM sections WHERE sectionID=" . $thetopts;
						$result2 = mysql_query($sSQL) or print(mysql_error());
						if(mysql_num_rows($result2) > 0){
							$rs2 = mysql_fetch_assoc($result2);
							$thetopts = $rs2["topSection"];
							$topcpnids .= "," . $thetopts;
						}else
							break;
					}
				}
				$aDiscSection[$cpnindex][1] = $topcpnids;
			}else
				$topcpnids = $aDiscSection[$cpnindex][1];
		}
		$alldiscounts = "";
		if(@$noshowdiscounts != TRUE){
			$sSQL = "SELECT DISTINCT ".getlangid("cpnName",1024)." FROM coupons LEFT OUTER JOIN cpnassign ON coupons.cpnID=cpnassign.cpaCpnID WHERE (cpnSitewide=0 OR cpnSitewide=3) AND cpnNumAvail>0 AND cpnEndDate>='" . date("Y-m-d",time()) ."' AND cpnIsCoupon=0 AND ((cpaType=2 AND cpaAssignment='" . $rs["pId"] . "')";
			if(! $isrootsection) $sSQL .= " OR (cpaType=1 AND cpaAssignment IN ('" . str_replace(",","','",$topcpnids) . "') AND NOT cpaAssignment IN ('" . str_replace(",","','",$topsectionids) . "'))";
			$sSQL .= ') AND ((cpnLoginLevel>=0 AND cpnLoginLevel<='.$minloglevel.') OR (cpnLoginLevel<0 AND -1-cpnLoginLevel='.$minloglevel.')) ORDER BY cpnID';
			$result2 = mysql_query($sSQL) or print(mysql_error());
			while($rs2=mysql_fetch_row($result2))
				$alldiscounts .= $rs2[0] . '<br />';
			mysql_free_result($result2);
		}
		if(($localcount % $productcolumns)==0 && ! @$usecsslayout) print '<tr>';
		if(! @$usecsslayout) print '<td width="' . (int)(100 / $productcolumns) . '%" align="center" valign="top" class="' . $cs . 'product">';
		print '<div class="' . $cs . 'product" align="center">';
		if(@$perproducttaxrate==TRUE && ! is_null($rs['pTax'])) $thetax = $rs['pTax']; else $thetax = $countryTaxRate;
		updatepricescript(@$noproductoptions!=TRUE,$thetax,FALSE);
		$thedesc = trim($rs[getlangid('pDescription',2)]);
		if(@$shortdescriptionlimit!='') $thedesc = substr($thedesc, 0, $shortdescriptionlimit) . (strlen($thedesc)>$shortdescriptionlimit && $shortdescriptionlimit!=0 ? '...' : '');
		print '<form method="post" name="tForm' . $Count . '" id="ectform' . $Count . '" action="cart.php" style="margin:0;padding:0;" onsubmit="return formvalidator' . $Count . '(this)">';
		if(! @$usecsslayout) print '<table width="100%" border="0" cellspacing="4" cellpadding="4">';
		if(@$showproductid==TRUE) print (! @$usecsslayout ? '<tr><td>' : '') . '<div class="'.$cs.'prodid">' . $sstrong . $xxPrId . ': ' . $estrong . $rs['pId'] . '</div>' . (! @$usecsslayout ? '</td></tr>' : '');
		if(@$manufacturerfield!='' && ! is_null($rs['mfName'])) print (! @$usecsslayout ? '<tr><td>' : '') . '<div class="'.$cs.'prodmanufacturer">' . $sstrong . $manufacturerfield . ': ' . $estrong . $rs['mfName'] . '</div>' . (! @$usecsslayout ? '</td></tr>' : '');
		if(@$showproductsku!='' && $rs['pSKU']!='') //print (! @$usecsslayout ? '<tr><td>' : '') . '<div class="'.$cs.'prodsku">' . $sstrong . $showproductsku . ': ' . $estrong . $rs['pSKU'] . '</div>' . (! @$usecsslayout ? '</td></tr>' : '');
		if(! @$usecsslayout) print '<tr><td width="100%" align="center" height="128" class="' . $cs . 'prodimage">';
		if(! is_array($allimages)){
			print '&nbsp;';
		}else{
			if(@$usecsslayout)
				print '<div class="prodimage imghbox">';
			else{
				if($numallimages>1) print '<table border="0" cellspacing="1" cellpadding="1"><tr><td colspan="3">';
			}
			print $startlink.'<img id="prodimage'.$Count.'" class="'.@$cs.'smallpimg" src="'.str_replace('%s','',$allimages[0]['imageSrc']).'" border="0" alt="'.str_replace('"', '&quot;', strip_tags($rs[getlangid('pName',1)])).'" />'.$endlink;
			if($numallimages>1)
				print (@$usecsslayout ? '<div class="imagenavigator">' : '</td></tr><tr><td class="imagenavigator" align="left">') . '<img border="0" class="previousimage" src="images/leftimage.gif" onclick="return updateprodimage(' . $Count . ', false);" onmouseover="this.style.cursor=\'pointer\'" alt="' . $xxPrev . '"' . (@$usecsslayout ? ' />' : 'style="float:left;margin:0px;" /></td><td align="center">') . '<span class="extraimage extraimagenum" id="extraimcnt' . $Count . '">1</span> <span class="extraimage">' . $xxOf . ' ' . $extraimages . '</span>' . (@$usecsslayout ? '' : '</td><td align="right">') . '<img border="0" class="nextimage" src="images/rightimage.gif" onclick="return updateprodimage(' . $Count . ', true);" onmouseover="this.style.cursor=\'pointer\'" alt="' . $xxNext . '"' . (@$usecsslayout ? ' /></div>' : 'style="float:right;margin:0px;" /></td></tr></table>');
			if(@$usecsslayout) print '</div>';
		}
		if(! @$usecsslayout) print '</td></tr><tr><td width="100%" align="center">';
		print '<div class="'.$cs.'prodname">' . $startlink . $rs[getlangid("pName",1)] . $endlink . $xxDot . '</div>';
		print '<div class="plitsize">Size:'. $rs["pUDF2"] . '</div>';
		if(isset($rs['pDims']) && $rs['pDims']!='xx' && $rs['pDims']!='x' && $rs['pDims']!=''){
				$dims = explode("x",substr($rs['pDims'] ,strpos($rs['pDims'], 'x')+1));
				print '<div class="sized"><span>Size:</span> '.$dims[0] .'" (W) x '.$dims[1]. '" (H) - inches</div>';
	}
		
		if($alldiscounts != "") print ' ' . (@$nomarkup?'':'<font color="#FF0000">') .$sstrong.'<span class="discountsapply">' . $xxDsApp . '</span>'.$estrong . (@$nomarkup?'':'</font>') . '<br /><div class="'.$cs.'proddiscounts"' . (@$nomarkup?'':' style="font-size:11px;color:#FF0000;"') . '>' . $alldiscounts . '</div>';
		if(@$ratingsonproductspage==TRUE && $rs['pNumRatings']>0) print showproductreviews(2, $cs.'prodrating');
		if($useStockManagement && @$showinstock==TRUE){ if((int)$rs['pStockByOpts']==0) print '<div class="'.$cs.'prodinstock">' . $sstrong . $xxInStoc . ': ' . $estrong . $rs['pInStock'] . '</div>'; }
		if($thedesc!='') print '<div class="'.$cs.'proddescription">' . $thedesc . '</div>'; else print '';
		$optionshavestock=true;
		$hasmultipurchase = 0;
		if(is_array($prodoptions)){
			if($noproductoptions==TRUE){
				$hasmultipurchase=2;
			}else{
				if($prodoptions[0]['optType']==4 && @$noproductoptions!=TRUE) $thestyle=''; else $thestyle=' width="100%"';
				$optionshtml = displayproductoptions($sstrong . '<span class="prodoption">','</span>'.$estrong,$optdiff,$thetax,FALSE,$hasmultipurchase,$optjs);
				if($optjs!='') print '<script language="javascript" type="text/javascript">/* <![CDATA[ */'.$optjs.'/* ]]> */</script>';
				if($optionshtml!='') print '<div class="'.$cs.'prodoptions">' . (! @$usecsslayout ? '<table class="'.$cs.'prodoptions" border="0" cellspacing="1" cellpadding="1"'.$thestyle.'>' : '') . $optionshtml . (! @$usecsslayout ? '</table>' : '') . '</div>';
				$rs['pPrice'] += $optdiff;
			}
			if($hasmultipurchase==2) print '';
		}
		if($rs['pId']!=$giftcertificateid && $rs['pId']!=$donationid && @$noprice!=TRUE){
			if((double)$rs['pListPrice']!=0.0) print '<div class="'.$cs.'listprice">' . str_replace('%s', FormatEuroCurrency($rs['pListPrice']), $xxListPrice) . '</div>';
			print '<div class="'.$cs.'prodprice"><strong>' . $xxPrice . ':</strong> <span class="price" id="pricediv' . $Count . '">' . ($rs['pPrice']==0 && @$pricezeromessage!='' ? $pricezeromessage : FormatEuroCurrency(@$showtaxinclusive===2 && ($rs['pExemptions'] & 2)!=2 ? $rs['pPrice']+($rs['pPrice']*$thetax/100.0) : $rs['pPrice'])) . '</span> ';
			if(@$showtaxinclusive==1 && ($rs['pExemptions'] & 2)!=2) printf('<span id="taxmsg' . $Count . '"' . ($rs['pPrice']==0 ? ' style="display:none"' : '') . '>' . $ssIncTax . '</span>','<span id="pricedivti' . $Count . '">' . ($rs['pPrice']==0 ? '-' : FormatEuroCurrency($rs['pPrice']+($rs['pPrice']*$thetax/100.0))) . '</span> ');
			print '</div>';
			$extracurr = '';
			if($currRate1!=0 && $currSymbol1!='') $extracurr = str_replace('%s',number_format($rs['pPrice']*$currRate1,checkDPs($currSymbol1),$orcdecimals,$orcthousands),$currFormat1) . $currencyseparator;
			if($currRate2!=0 && $currSymbol2!='') $extracurr .= str_replace('%s',number_format($rs['pPrice']*$currRate2,checkDPs($currSymbol2),$orcdecimals,$orcthousands),$currFormat2) . $currencyseparator;
			if($currRate3!=0 && $currSymbol3!='') $extracurr .= str_replace('%s',number_format($rs['pPrice']*$currRate3,checkDPs($currSymbol3),$orcdecimals,$orcthousands),$currFormat3);
			if($extracurr!='') print '<div class="'.$cs.'prodcurrency"><span class="extracurr" id="pricedivec' . $Count . '">' . ($rs['pPrice']==0 ? '' : $extracurr) . '</span></div>';
		}
		if(! @$usecsslayout) print '</td></tr>';
		if(@$nobuyorcheckout != TRUE){
			if($rs['pId']==$giftcertificateid || $rs['pId']==$donationid) $hasmultipurchase=2;
			if(! @$usecsslayout) print '<tr><td align="center">';
			if($useStockManagement)
				if($rs['pStockByOpts']!=0) $isinstock = $optionshavestock; else $isinstock = ((int)($rs['pInStock']) > 0);
			else
				$isinstock = ($rs['pSell'] != 0);
			if($rs['pPrice']==0 && @$nosellzeroprice==TRUE)
				print '&nbsp;';
			else{
				if(@$usecsslayout) print '<div class="addtocart">';
				if(! $isinstock && !($useStockManagement && $hasmultipurchase==2) && $rs['pBackOrder']==0 && @$notifybackinstock!=TRUE){
					print '<div class="outofstock">' . $sstrong . $xxOutStok . $estrong . '</div>';
				}elseif($hasmultipurchase==2){
					if(@$usecsslayout) print '<div class="configbutton">';
					print imageorbutton(@$imgconfigoptions,$xxConfig,'configbutton',$thedetailslink, FALSE);
					if(@$usecsslayout) print '</div>';
				}else{
					$isbackorder=! $isinstock && $rs['pBackOrder']!=0;
					writehiddenvar('id', $rs['pId']);
					writehiddenvar('mode', 'add');
					if($wishlistonproducts) writehiddenvar('listid', '');
					if(@$showquantonproduct && $hasmultipurchase==0 && ($isinstock || $isbackorder)){
						print (@$usecsslayout ? '<div class="quantitydiv">' : '<table><tr><td align="center">');
						print '<input type="text" name="quant" size="2" maxlength="5" value="1" alt="'.$xxQuant.'" />' . (@$usecsslayout ? '</div>' : '</td><td align="center">');
					}
					if($isbackorder)
						print imageorsubmit(@$imgbackorderbutton,$xxBakOrd,'buybutton backorder');
					elseif(! $isinstock && @$notifybackinstock)
						print '<div class="outofstock notifystock">' . imageorlink(@$imgnotifyinstock, $xxNotBaS, "return notifyinstock(false,'".str_replace("'","\\'",$rs['pId'])."','".str_replace("'","\\'",$rs['pId'])."',".($rs['pStockByOpts']!=0&&!@$optionshavestock?'-1':'0').")", TRUE) . '</div>';
					else{
						if(@$custombuybutton!='') print $custombuybutton; else print imageorsubmit(@$imgbuybutton,$xxAddToC,'buybutton');
					}
					if($wishlistonproducts) print '<br />' . imageorlink(@$imgaddtolist,$xxAddLis,'gtid='.$Count.';return displaysavelist(event,window)',TRUE);
					if(@$showquantonproduct && $hasmultipurchase==0 && ($isinstock || $isbackorder)) print (! @$usecsslayout ? '</td></tr></table>' : '');
				}
				if(@$usecsslayout) print '</div>';
			}
			if(! @$usecsslayout) print '</td></tr>';
		}
		if(! @$usecsslayout) print '</table>';
		print '</form></div>';
		if(! @$usecsslayout) print '</td>';
		$Count++;
		$localcount++;
		if((($localcount % $productcolumns)==0) && ! @$usecsslayout){
			print '</tr>';
			if(! ($localcount==$totrows) && $localcount < $adminProdsPerPage){
				if(@$noproductseparator!=TRUE){
					print '<tr>';
					for($index=1; $index <= $productcolumns; $index++)
						print '<td class="prodseparator">' . (@$prodseparator!='' ? $prodseparator : '') . '</td>';
					print '</tr>';
				}
			}
		}
	}
	if((($localcount % $productcolumns)!=0) && ! @$usecsslayout){
		while($localcount % $productcolumns != 0){
			print '<td class="'.$cs.'noproduct" width="' . (int)(100 / $productcolumns) . '%" align="center">&nbsp;</td>';
			$localcount++;
		}
		print '</tr>';
	}
	if($iNumOfPages>1 && @$nobottompagebar!=TRUE){
		if(@$usecsslayout) print '<div class="pagenums" style="width:100%">' . "\r\n"; else print '<tr><td colspan="' . $productcolumns . '" align="center" class="pagenums"><p class="pagenums">';
		print writepagebar($CurPage,$iNumOfPages,$xxPrev,$xxNext,$pblink,$nofirstpg);
		if(@$usecsslayout) print '</div>' . "\r\n"; else print '<br /><img src="images/clearpixel.gif" width="50" height="5" alt="" /></p></td></tr>';
	}
	if(@$usecsslayout) print '</div>'; else print '</table>';
	if($defimagejs!='') print '<script language="javascript" type="text/javascript">' . $defimagejs . '</script>';
?>