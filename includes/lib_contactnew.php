<?php
function creatContact($order_id){

// 获取订单信息
$sql = "SELECT p.*,o.pay_time,o.amount,g.goods_period,g.goods_interest_rate,u.true_name,o.pay_sn FROM ".$GLOBALS["ecs"]->table("order_new")." AS o 
			LEFT JOIN ".$GLOBALS["ecs"]->table("users"). " AS u ON u.user_id = o.user_id 
			LEFT JOIN ".$GLOBALS["ecs"]->table("goods"). " AS g ON g.goods_id = o.goods_id 
			LEFT JOIN ".$GLOBALS["ecs"]->table("project"). " AS p ON g.project_id = p.project_id 
			WHERE o.order_id = ".$order_id;
$order_info = $GLOBALS["db"]->getRow($sql);
$ssn = $order_info["pay_sn"];
$project_id = $order_info["project_id"];
$img = '<img src="themes/ecmoban_jumei/images/tampon'.$project_id.'.png" width="300">';
$owner_name 	= $order_info["owner_name"];
$owner_address	= $order_info["owner_address"];
$owner_faren 	= $order_info["owner_faren"];
$owner_money 	= $order_info["owner_money"];
$project_name 	= $order_info["project_name"];
$project_short	= $order_info["project_short"];
$amount			= $order_info["amount"];
$amountW		= $order_info["amount"]/10000;
$goods_interest_rate = $order_info["goods_interest_rate"];
$true_name		= $order_info["true_name"];
$format_paytime = local_date("Y年m月d日",$order_info["pay_time"]);
$contract_no1	= $order_info["contract_no1"];
$contract_no2	= $order_info["contract_no2"];
$project_max_cn	= $order_info["project_max_cn"];
$project_max	= $order_info["project_max"];
$project_usage	= $order_info["project_usage"];
$project_garentee = $order_info["project_garentee"];
$goods_period = $order_info["goods_period"];
$A = $order_info["A"];
$B = $order_info["B"];
$C = $order_info["C"];
$D = $order_info["D"];
$E = $order_info["E"];
$F = $order_info["F"];
if ($goods_period == $A*30){
	$letter = "A";
}elseif($goods_period == $B*30){
	$letter = "B";
}elseif($goods_period == $C*30){
	$letter = "C";
}elseif($goods_period == $D*30){
	$letter = "D";
}elseif($goods_period == $E*30){
	$letter = "E";
}elseif($goods_period == $F*30){
	$letter = "F";
}
$contract_no = "RG".$project_short.local_date("Ymd",$order_info["pay_time"])."(H)";

// 计算该订单是当天的第几个订单
$sql = "SELECT pay_time FROM ".$GLOBALS["ecs"]->table("order_new")." ORDER BY pay_time";
$res = $GLOBALS["db"]->getAll($sql);
$count = 0;
foreach ($res as $k =>$v){
	if (local_date("Ymd",$v["pay_time"]) == local_date("Ymd",$order_info["pay_time"])){
		if ($v["pay_time"] <= $order_info["pay_time"]){
			$count++;
		}
	}
}
if ($count< 10){
	$count = "0".$count;
}
$contract_no .= $count;

// 获取该项目的所有相关商品的起投金额
$sql = "SELECT distinct(goods_min_buy) from ".$GLOBALS["ecs"]->table("goods")." WHERE project_id = ".$project_id." AND goods_min_buy>1000 ORDER BY goods_min_buy";
$r_list = $GLOBALS["db"]->getAll($sql);
$count = 0;
foreach ($r_list as $k=>$v){
	$count ++;
	$r_list[$k]["name"] = "R".$count;
	if ($r_list[$k+1]["goods_min_buy"]){
		$r_list[$k]["range"] = ($r_list[$k]["goods_min_buy"]/10000)."万元≤认购资金＜".($r_list[$k+1]["goods_min_buy"]/10000)."万元";
	}else{
		$r_list[$k]["range"] = ($r_list[$k]["goods_min_buy"]/10000)."万元≤认购资金";
	}
	$sql = "SELECT goods_period, goods_interest_rate from ".$GLOBALS["ecs"]->table("goods")." WHERE project_id = ".$project_id." AND goods_min_buy=".$v["goods_min_buy"]." ORDER BY goods_min_buy";
	$goods_list_mb = $GLOBALS["db"]->getAll($sql);
	foreach($goods_list_mb as $key=>$val){
		if ($val["goods_period"]==$A*30){
			$r_list[$k]["A"] = $val["goods_interest_rate"]."%";
		}elseif ($val["goods_period"]==$B*30){
			$r_list[$k]["B"] = $val["goods_interest_rate"]."%";
		}elseif ($val["goods_period"]==$C*30){
			$r_list[$k]["C"] = $val["goods_interest_rate"]."%";
		}elseif ($val["goods_period"]==$D*30){
			$r_list[$k]["D"] = $val["goods_interest_rate"]."%";
		}elseif ($val["goods_period"]==$E*30){
			$r_list[$k]["E"] = $val["goods_interest_rate"]."%";
		}elseif ($val["goods_period"]==$F*30){
			$r_list[$k]["F"] = $val["goods_interest_rate"]."%";
		}
	}
}
$table_string1 = "";
$table_string2 = "";
$table_string_A = "<td>A类(".$A."个月)</td>";
$table_string_B = "<td>B类(".$B."个月)</td>";
$table_string_C = "<td>C类(".$C."个月)</td>";
$table_string_D = "<td>D类(".$D."个月)</td>";
$table_string_E = "<td>E类(".$E."个月)</td>";
$table_string_F = "<td>F类(".$F."个月)</td>";
$table_string3 = "";
foreach ($r_list as $k=>$v){
	$table_string1.= "<td> ".$v["range"]."</td>";
	$table_string2.= "<td> ".$v["name"]."</td>";
	if($A){
		$table_string_A.= "<td> ".$v["A"]."</td>";
	}
	if($B){
		$table_string_B.= "<td> ".$v["B"]."</td>";
	}
	if($C){
		$table_string_C.= "<td> ".$v["C"]."</td>";
	}
	if($D){
		$table_string_D.= "<td> ".$v["D"]."</td>";
	}
	if($E){
		$table_string_E.= "<td> ".$v["E"]."</td>";
	}
	if($F){
		$table_string_F.= "<td> ".$v["F"]."</td>";
	}
}
if($A){
	$table_string3.="<tr>".$table_string_A."</tr>";
}
if($B){
	$table_string3.="<tr>".$table_string_B."</tr>";
}
if($C){
	$table_string3.="<tr>".$table_string_C."</tr>";
}
if($D){
	$table_string3.="<tr>".$table_string_D."</tr>";
}
if($E){
	$table_string3.="<tr>".$table_string_E."</tr>";
}
if($F){
	$table_string3.="<tr>".$table_string_F."</tr>";
}
/* 将数字年份转换为中文年份 */
function transfer_year($year){
	$number_array = array("〇","一","二","三","四","五","六","七","八","九");
	$first_number = floor($year/1000);
	$second_number = floor(($year-1000*$first_number)/100);
	$third_number = floor(($year-1000*$first_number-100*$second_number)/10);
	$last_number = $year-1000*$first_number-100*$second_number - 10*$third_number;
	$result = $number_array[$first_number].$number_array[$second_number].$number_array[$third_number].$number_array[$last_number];
	return $result;
}
/* 将数字月份转换为中文年份 */
function transfer_month($month){
	$number_array = array("〇","一","二","三","四","五","六","七","八","九","十","十一","十二");
	return $number_array[(int)$month];
}
// 将购买日期转换为中文
$contract_year =  transfer_year(local_date("Y",$order_info["pay_time"]));
$contract_month =  transfer_month(local_date("m",$order_info["pay_time"]));

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('政金网');
$pdf->SetTitle('政金网客户投资合同');
$pdf->SetSubject('政金网客户投资合同');
$pdf->SetKeywords('政金网, PDF, 投资合同, 和瀚金融, 无忧存证');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('stsongstdlight', '', 26, '', true);

// add a page
$pdf->AddPage();

// set some text to print
$txt = <<<EOD
		<p></p><p></p>
		<p style="text-align:center;font-weight:bold">$owner_name</p>
		<p style="text-align:center;font-weight:bold">“<span>$project_name</span>”收益权转让计划</p>
		<p style="text-align:center;font-weight:bold">认购合同</p>
		<p style="width:100%;height:1px"></p>
EOD;
		
$pdf->writeHTMLCell(0, 0, '', '', $txt, 0, 1, 0, true, '', true);
$pdf->SetFont('stsongstdlight', '', 15, '', true);
$pdf->Write(5, "                                           合同编号：", '', 0, '', false, 0, false, false, 0);
$pdf->SetFont('times', '', 15, '', true);
$pdf->Write(5, "$contract_no\n", '', 0, '', false, 0, false, false, 0);
$pdf->SetFont('stsongstdlight', '', 16, '', true);
$txt = <<<EOD
		<p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p>
		<p style="margin-top:200px;text-align:center;font-weight:bold"><span>$contract_year</span>年<span>$contract_month</span>月</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt, 0, 1, 0, true, '', true);

$pdf->SetFont('stsongstdlight', '', 11, '', true);
$txt = <<<EOD
		<p></p><p></p><p></p>
		<p style="text-align:center;">第1页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt, 0, 1, 0, true, '', true);

// add a page
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 16, '', true);
$txt2 = <<<EOD
	<p style="text-align:center;">目录</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt2, 0, 1, 0, true, '', true);
$pdf->SetFont('stsongstdlight', '', 12, '', true);
$txt2 = <<<EOD
	
	<p>一、认购风险申明书....................................................................................................................................3</p>
	<p>二、前言.........................................................................................................................................................6</p>
	<p>三、释义.........................................................................................................................................................6</p>
	<p>四、标的计划的要素....................................................................................................................................7</p>
	<p>五、标的计划的认购....................................................................................................................................9</p>
	<p>六、标的计划成立与募集成功的条件......................................................................................................10</p>
	<p>七、标的计划项下资金的管理、运用......................................................................................................11</p>
	<p>八、投资收益及分配...................................................................................................................................11</p>
	<p>九、风险揭示和承担...................................................................................................................................12</p>
	<p>十、标的计划的信息披露...........................................................................................................................14</p>
	<p>十一、标的计划的变更、解除、终止和清算.........................................................................................15</p>
	<p>十二、认购人的权利与义务.......................................................................................................................16</p>
	<p>十三、发行人的权利和义务.......................................................................................................................16</p>
	<p>十四、违约责任............................................................................................................................................17</p>
	<p>十五、税收处理............................................................................................................................................18</p>
	<p>十六、通知与送达........................................................................................................................................18</p>
	<p>十七、适用法律与争议处理.......................................................................................................................19</p>	
	<p>十八、其他事项............................................................................................................................................19</p>
	<p>十九、认购合同的效力...............................................................................................................................19</p>
	<p>二十、认购合同签署...................................................................................................................................20</p>
	
	<p style="text-align:center;">第2页</p>
EOD;


$pdf->writeHTMLCell(0, 0, '', '', $txt2, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', 'B', 16, '', true);
$txt3 = <<<EOD
<p style="text-align:center">“<span>$project_name</span>”收益权转让计划</p>
<p style="text-align:center">一、认购风险申明书</p>
<p></p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt3, 0, 1, 0, true, '', true);
$pdf->SetFont('stsongstdlight', 'B', 11, '', true);
$txt3 = <<<EOD
<p style="text-align:center">第一部分 风险申明</p>
<p>尊敬的认购人：</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt3, 0, 1, 0, true, '', true);
$pdf->SetFont('stsongstdlight', '', 11, '', true);

$tmpa = "发行人".$owner_name."作为融资人发行“15余姚经开债”。";
$txt3 = <<<EOD
<p></p>
<p style="text-indent: 20px;">感谢您加入<span>$project_name</span>收益权转让计划（以下简称“标的计划”）。</p>

<p>“政金网”平台（www.zhengjinnet.com）系和瀚金融信息服务（上海）有限公司所属的金融信息服务撮合平台。</p>

<p>$tmpa</p>
<p>转让人和瀚金融作为“15余姚经开债”3000万票面持有人在“政金网”上线标的计划，标的计划经“政金网”登记、撮合、交易。</p>
<p style="text-indent: 20px;">    为了维护您的利益，在您决定是否认购标的计划前，请仔细阅读标的计划的认购合同、标的计划募集说明书以及本认购风险申明书（以下与认购合同、募集说明书统称“投资文件”）的具体内容，独立做出是否签署投资文件的决定。</p>
<p style="text-indent: 20px;">    本公司作为标的计划发行人，向您郑重申明：</p>
<p style="text-indent: 20px;">    （1）标的计划不承诺保本和最低收益，具有一定的投资风险，适合风险识别、评估、承受能力较强的合格投资者；</p>
<p style="text-indent: 20px;">    （2）认购人应当以自己合法所有或管理的资金认购标的计划，不得非法汇集他人资金参与标的计划；采用多人拼凑方式认购标的计划的，其拼凑人的债权和收益权不受法律保护；</p>
<p style="text-indent: 20px;">    （3）标的计划的受托管理人为中新力合股份有限公司，受托管理人承诺恪尽职守，遵循诚实、信用、谨慎、有效的原则管理和监督标的计划下的财产，同时做好与标的计划相关的信息发布与披露。</p>
<p style="text-indent: 20px;">    标的计划项下的财产在管理运用或处分过程中可能面临多种风险，包括但不限于法律与政策风险、市场风险、经营风险、信用风险、流动性风险、担保措施风险、标的计划认购不成功风险、标的计划产品不成立风险、标的计划受益权提前终止或标的计划提前终止风险、标的计划延期终止风险、受托人管理风险及保管人保管风险、信息传递风险和其他风险。</p>
<p style="text-indent: 20px;">    您在认购标的计划前，应认真阅读投资文件，并特别关注投资文件中揭示的标的计划的相关风险事项。&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
	<p></p><p></p><p></p><p></p>
	<p style="text-align:center;">第3页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt3, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);
if ($A){$sA = "□A类";}
if ($B){$sB = "□B类";}
if ($C){$sC = "□C类";}
if ($D){$sD = "□D类";}
if ($E){$sE = "□E类";}
if ($F){$sF = "□F类";}
if ($letter == "A"){$sA = "<span style='border:1px solid #000'>█</span>A类";}
if ($letter == "B"){$sB = "<span style='border:1px solid #000'>█</span>B类";}
if ($letter == "C"){$sC = "<span style='border:1px solid #000'>█</span>C类";}
if ($letter == "D"){$sD = "<span style='border:1px solid #000'>█</span>D类";}
if ($letter == "E"){$sE = "<span style='border:1px solid #000'>█</span>E类";}
if ($letter == "F"){$sF = "<span style='border:1px solid #000'>█</span>F类";}
$tmp = "    认购人认购“".$project_name."”收益权转让计划";
$ext = new Ext_Num2Cny();
$amount_daxie = $ext->ParseNumber($amount);
$tmp2 = "    认购资金：人民币 <u>".$amount_daxie."</u>（小写金额￥ ".$amountW." 万元整）。";
$tmp3 = "    认购人认购的标的计划的预期年化收益率R为 <u> ".$goods_interest_rate."%/年</u>。";
$txt4 = <<<EOD
<p style="text-align:center">第二部分 认购信息</p>
<p style="text-indent: 20px;">$tmp</p>
<p style="text-indent: 20px;">计划期限<sapn>$goods_period</span>天，如果产品提前兑付，以实际投资期限为准。</p>
<p style="text-indent: 20px;">$tmp2</p>
<p style="text-indent: 20px;">$tmp3</p>
<p style="text-indent: 20px;">    （特别提示：预期年化收益率仅为计算投资利益方便而设，并不代表发行人或任何第三方保证认购人的最低收益。）</p>


	<p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p>
	<p></p><p></p><p></p><p></p><p></p><p></p>
	<p style="text-align:center;">第4页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt4, 0, 1, 0, true, '', true);


$pdf->AddPage();
$pdf->SetFont('stsongstdlight', 'B', 14, '', true);
$txt5 = <<<EOD
<p style="text-align:center;font-size:20px;font-weight:bold">认购风险申明书签署确认页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt5, 0, 1, 0, true, '', true);
$pdf->SetFont('stsongstdlight', 'B', 11, '', true);
$txt5 = <<<EOD
<p style="text-indent: 20px;font-weight:bold">    本人/本机构作为认购人签署本认购风险申明书，即表明：</p>
<p style="text-indent: 20px;">    （1）已经详细阅读投资文件，并独立作出了签署本认购风险申明书的决定，且同意受投资文件的约束，愿意承担相应的投资风险；</p>
<p style="text-indent: 20px;">    （2）同意发行人和受托人按照投资文件的约定管理、运用、处分投资财产&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<p></p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt5, 0, 1, 0, true, '', true);
$pdf->SetFont('stsongstdlight', '', 11, '', true);
$txt5 = <<<EOD
<p style="text-indent: 20px;">    本认购风险申明书一式贰份，认购人和转让人各持壹份。</p>
<p style="text-indent: 20px;">    如认购人系“政金网”用户，合同双方一致同意委托“政金网”保管本认购风险申明书及电子信息。</p>
<p></p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt5, 0, 1, 0, true, '', true);
$pdf->SetFont('stsongstdlight', 'B', 11, '', true);
$txt5 = <<<EOD
<p>认购人：$true_name</p>
<p>自然人（签字）</p>
<p></p>
<p>机构（公章）</p>
<p>机构法定代表人或授权代表（签字或盖章）</p>
<p></p>
<p>转让人：</p>
$img
<p></p>
<p>签署日期：$format_paytime</p>
<p></p>

	<p></p><p></p>
	<p style="text-align:center;">第5页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt5, 0, 1, 0, true, '', true);

$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);
if($F){
	$tt = "A类认购人、B类认购人、C类认购人、D类认购人、E类认购人和F类认购人";
}elseif($E){
	$tt = "A类认购人、B类认购人、C类认购人、D类认购人和E类认购人";
}elseif($D){
	$tt = "A类认购人、B类认购人、C类认购人和D类认购人";
}elseif($C){
	$tt = "A类认购人、B类认购人和C类认购人";
}
$tt = "A类认购人、B类认购人、C类认购人和D类认购人";
$tmp0 = "    10.认购人：指认购加入标的计划的投资者，即具有完全民事行为能力且符合法律规定的合格投资者条件的自然人、法人及依法成立的其他组织，如认购人系“政金网”注册用户，其须承诺符合《政金网网站注册用户服务协议（个人用户/企业用户）》的要求。";
$tmp = "    根据《中华人民共和国合同法》以及其他有关法律法规的规定，在平等自愿、诚实信用、充分保护投资者合法权益的原则基础上，订立《".$owner_name."“".$project_name."”收益权转让计划认购合同》（以下简称“认购合同”）。";
$tmp2 = "    4.认购合同：指认购人与转让人签订的《".$owner_name."“".$project_name."”收益权转让计划认购合同》及其任何有效修订和补充。";
$tmp3 = "    5.标的计划：指转让人根据本合同设立的“".$owner_name."‘".$project_name."’收益权转让计划”。";
//$tmp4 = "    6.投资计划说明书：指《".$owner_name."“".$project_name."”收益权转让计划募集说明书》及其任何有效修订和补充。";
$tmp5 = "    6.认购风险申明书：指投资者认购标的计划时签署的《".$owner_name."“".$project_name."”收益权转让计划认购风险申明书》及其任何有效修订和补充。";
$tmp6 = "    21.计划核算日：指标的计划存续期间，发行人计算认购人可获得分配的投资收益具体金额的定期核算基准日。其中，标的计划成立时取得的投资计划份额的核算日为标的计划成立日起每届满3个月之日。";
//$tmp7 = "    23.《应收账款转让及回购合同》：指发行人和【和瀚金融信息服务（上海）有限公司】签订的《应收账款转让及回购合同》及其有效修订和补充的统称。";
//$tmp8 = "    25.《受托管理协议》：指发行人和和瀚金融信息服务（上海）有限公司签订的《受托管理协议》及其有效修订和补充的统称。";
$tmp9 = "    1、标的计划的名称为“".$owner_name."‘".$project_name."’收益权转让计划”。";
$tmp10 = "    2、标的计划项下募集资金总额不超过".$project_max_cn."元（小写：￥".number_format($project_max,2)."，含本数，下同）。";
$tmp11 = "    名称：".$owner_name;
$tmp12 = "    注册地址：".$owner_address;
$tmp13 = "    法定代表人：".$owner_faren;
$tmp14 = "    注册资本：人民币".$owner_money."元";
$tmp15 = "    发行人发行标的计划所融资金将用于".$project_usage."，具体事宜以《投资计划说明书》及在“政金网”上披露相关材料为准。";
$tmp16 = "    ".$project_garentee."为".$owner_name."在“".$project_name."”投资计划下的回购义务提供的连带责任保证担保属于信用担保。就该等信用担保的担保权利实现而言，担保人自有资产、担保能力或商业信用发生的任何不利变化可能影响担保权利的行使和执行程序中所实现的资金数额，且实现担保权利所回收的资金可能不足以清偿被担保范围内的全部债权。此外，实现担保权利的收入回收距违约时点尚有一定时间滞后，而担保权利的行使和执行程序中的迟延可能会对通过该程序实现的收入数额产生不利影响，从而使认购人遭受损失。";
$tl = "";
if ($A){$tl.= "A类预计存续期限为【".$A."】个月，";}
if ($B){$tl.= "B类预计存续期限为【".$B."】个月，";}
if ($C){$tl.= "C类预计存续期限为【".$C."】个月，";}
if ($D){$tl.= "D类预计存续期限为【".$D."】个月，";}
if ($E){$tl.= "E类预计存续期限为【".$E."】个月，";}
if ($F){$tl.= "F类预计存续期限为【".$F."】个月，";}
$tmpletter = "    3、标的计划的预计存续期限为自本标的计划成立之日起至存续期限届满时终止。";

$txt6 = <<<EOD
<p style="text-align:center;font-weight:bold">二、前言</p>
<p style="text-indent: 20px;">$tmp</p>
<p style="text-indent: 20px;">    认购合同是规定合同当事人之间权利义务的基本法律文件，其他与本投资计划相关的涉及认购合同当事人之间权利义务关系的任何文件或表述，均以认购合同为准。认购合同当事人按照《中华人民共和国合同法》、《认购合同》及其他有关法律法规的规定享有权利、承担义务。</p>
<p style="text-indent: 20px;">    发行人在认购合同之外披露的涉及本投资计划的信息，其内容涉及界定认购合同当事人之间权利义务关系的，应以认购合同为准。</p>

<p style="text-align:center;font-weight:bold">三、释义</p>

<p></p><p></p><p></p>

<p style="text-indent: 20px;">    在本合同中，除上下文另有解释或文义另有所指，下列词语具有以下含义：</p>
<p style="text-indent: 20px;">    1.发行人：指<font>$owner_name</font>。</p>
<p style="text-indent: 20px;">    2.融资人:<span>$owner_name</span>。</p>
<p style="text-indent: 20px;">    3.转让人: 指和瀚金融信息服务（上海）有限公司。</p>
<p style="text-indent: 20px;">$tmp2</p>
<p style="text-indent: 20px;">$tmp3</p>
<p style="text-indent: 20px;">$tmp5</p>
<p style="text-indent: 20px;">    7.投资文件：指包括但不限于认购合同、投资计划说明书、认购风险申明书等书面文件在内的规定本投资项目项下各方当事人权利义务关系的法律文件。 </p>
<p style="text-indent: 20px;">    8.投资收益：指认购人投资标的计划获得的收益，为其获得全利益中超出投资本金的部分。</p>
<p style="text-indent: 20px;">    9.投资受益权：指认购人享有的权利，包括但不限于取得发行人分配的投资收益的权利。</p>
<p style="text-indent: 20px;">$tmp0</p>
<p style="text-indent: 20px;">    11.认购：指标的计划募集期内，投资者购买标的计划份额的行为。</p>
<p style="text-align:center;">第6页</p>

<p style="text-indent: 20px;">    12.认购资金：指各认购人因认购标的计划而交付给发行人的资金。</p>
<p style="text-indent: 20px;">    13.投资资金/投资本金：指认购人交付的用于认购标的计划并划入投资财产专户的资金。</p>
<p style="text-indent: 20px;">    14.标的计划资金：指本合同认购人以及与认购人具有共同投资目的的其他投资者向发行人交付的投资资金的总额。</p>
<p style="text-indent: 20px;">    15.投资财产专户：指发行人为投资计划开立的专用银行账户。</p>
<p style="text-indent: 20px;">    16.合格投资者：指符合法律法规、投资文件规定以及承诺符合《政金网网站注册用户服务协议（个人用户/企业用户）》的投资者。</p>
<p style="text-indent: 20px;">    17.开放募集期/开放期：指标的计划存续期内，发行人开放发行标的计划份额并接受认购人认购申请的期间，该期间的起始日期和期限由发行人根据标的计划运营情况确定。</p>
<p style="text-indent: 20px;">    18.标的计划成立日：指标的计划成立的当日，即投资文件约定的标的计划成立条件全部满足时，发行人宣告标的计划成立的日期。</p>
<p style="text-indent: 20px;">    19.标的计划终止日：标的计划如期终止的，为标的计划预计存续期限届满之日；标的计划提前终止或延期后终止的，标的计划终止日为投资财产处置变现完毕，发行人宣布标的计划终止之日。</p>
<p style="text-indent: 20px;">    20.延长期：指发生认购合同约定的情形从而导致标的计划预计存续期限届满后未能如期终止而进入延长期的，自标的计划预计存续期限届满之日起至标的计划终止日的期间。</p>
<p style="text-indent: 20px;">$tmp6</p>
<p style="text-indent: 20px;">    22.分配日：指由发行人决定的向认购人分配投资利益之日，为计划核算日后十个工作日内的任一日。</p>
<p style="text-indent: 20px;">    23.“政金网”：网址为www.zhengjinnet.com，系和瀚金融信息服务（上海）有限公司所属的互联网金融信息服务撮合平台。</p>
<p style="text-indent: 20px;">    24.法律法规：指中国现行有效并公布实施的法律、行政法规、部门规章、司法解释及监管部门的决定、通知等。</p>
<p style="text-indent: 20px;">    25.工作日：指中华人民共和国国务院规定的金融机构正常营业日。</p>
<p style="text-indent: 20px;">    26.年、月、日：指日历年、月、日。</p>
<p style="text-indent: 20px;">    27.中国：指中华人民共和国，在认购合同中，不包括香港特别行政区、澳门特别行政区和台湾地区。</p>
<p style="text-indent: 20px;">    28.元：指人民币元。</p>
<p style="text-indent: 20px;">    29.受托管理人：中新力合股份有限公司。</p>


<p style="text-align:center;font-weight:bold">四、标的计划的要素</p>



<p style="text-align:center;">第7页</p>

<p style="text-indent: 20px;">    （一）标的计划的基本要素</p>

<p style="text-indent: 20px;">$tmp9</p>

<p style="text-indent: 20px;">$tmp10</p>
<p style="text-indent: 20px;">    发行人有权对发行的标的计划资金总额和各类别的发行金额进行调整。</p>
<p style="text-indent: 20px;">$tmpletter</p>
<p style="text-indent: 20px;">    （二）标的计划的相关主体</p>
<p style="text-indent: 20px;">    1、认购人</p>
<p style="text-indent: 20px;">    认购人应为符合法律规定的，能够判断、识别、评估和承受本标的计划投资风险的投资者。</p>
<p style="text-indent: 20px;">    （1）合格投资者</p>
<p style="text-indent: 20px;">    认购人应当是能够识别、判断和承担标的计划相应风险的合格投资者。</p>
<p style="text-indent: 20px;">    合格投资者可以是自然人、法人或者依法成立的其他组织。</p>
<p style="text-indent: 20px;">    认购人若为“政金网”用户，尚未开户的，须在投资前开立账户。</p>
<p style="text-indent: 20px;">    （2）认购人陈述与保证</p>
<p style="text-indent: 20px;">    投资者在认购标的计划份额时做出如下陈述与保证：</p>
<p style="text-indent: 20px;">    1合法存续。在认购人为机构投资者的情形，认购人是一家按照中国法律合法成立的法人或者依法成立的其他组织，并合法存续；在认购人为自然人的情形，认购人为在中国境内居住的具有完全民事权利能力和完全民事行为能力的自然人。</p>
<p style="text-indent: 20px;">    2具备投资者资格，并符合《政金网网站注册用户服务协议（个人用户/企业用户）》的要求。</p>
<p style="text-indent: 20px;">    3合法授权。认购人对本合同的签署、交付和履行，以及认购人作为当事人一方对与本合同有关的其他协议、承诺及文件的签署、交付和履行，是在其权利范围内的，得到必要的授权，并不会导致其违反对其具有约束力的法律和合同、协议等契约性文件规定的其对第三方所负的义务。认购人为自然人且已有配偶或其他共同共有人的，其对本合同的签署、交付和履行，以及认购人作为当事人一方对与本合同有关的其他协议、承诺及文件的签署、交付和履行已得到其配偶或其他共同共有人的同意。认购人已就认购标的计划取得了一切必要的权力、权利及授权。</p>
<p style="text-indent: 20px;">    4认购的正当性。认购人对金融风险包括投资风险等有较高的认知度和承受能力，并根据其自己独立的审核以及其认为适当的专业意见，认购人认购标的计划份额完全符合其财务需求、目标和条件，对其而言是合理、恰当而且适宜的投资；不违反任何对其有约束力的任何投资政策、指引和限制、合同、承诺及法律法规、政府命令、判决及裁决；未损害其债权人或任何第三人的合法权益。</p>
<p style="text-indent: 20px;">    5投资财产来源及用途合法。认购人按照本合同认购标的计划份额所运用的资金来源合法，为其合</p>

<p style="text-align:center;">第8页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt6, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);


$txt7 = <<<EOD
<p>法所有或合法管理的资金，非为毒品犯罪、黑社会性质的组织犯罪、恐怖活动犯罪、走私犯罪、贪污贿赂犯罪、金融诈骗犯罪等犯罪所得，并非金融机构信贷资金，借贷资金或其他负债资金，且不存在任何已有的或潜在的法律纠纷且可用于本合同约定之用途。认购人不得非法汇集他人资金参与标的计划；采用多人拼凑方式购买标的计划的，其拼凑人的债权和收益权不受法律保护。认购人承诺认购人有合法且完整的权利将资金用于标的计划，该等运用符合法律及其他相关合同的要求，并符合相关产业政策。</p>
<p style="text-indent: 20px;">    6信息披露的真实性。认购人向发行人及受托管理人提供的所有财务报表、文件、记录、报告、协议以及其他书面资料均属真实和准确，且不存在任何重大错误或遗漏。</p>
<p style="text-indent: 20px;">    2、发行人</p>
<p style="text-indent: 20px;">    （1）发行人基本信息如下：</p>
<p style="text-indent: 20px;">$tmp11</p>
<p style="text-indent: 20px;">$tmp12</p>
<p style="text-indent: 20px;">$tmp13</p>
<p style="text-indent: 20px;">$tmp14</p>
<p style="text-indent: 20px;">    （2）发行人向认购人做出以下的陈述和保证：</p>
<p style="text-indent: 20px;">    ①公司存续。发行人是一家按照中国法律正式注册并有效存续的公司，具有签订本合同所需的所有权利、授权和批准，并且具有充分履行其在本合同项下每项义务所需的所有权利、授权和批准。</p>
<p style="text-indent: 20px;">    ②合法授权。无论是本合同的签署还是对本合同项下义务的履行，均不会抵触、违反或违背其章程、内部规章制度以及营业许可范围或任何法律法规或任何政府机构或机关的批准，或其为签约方的任何合同或协议的任何规定。</p>
<p style="text-indent: 20px;">    ③信息披露的真实性。发行人向认购人提供的所有投资文件以及其他所有与本合同相关的资料和信息均属真实和准确，且不存在任何重大错误或遗漏。</p>
<p style="text-indent: 20px;">    3、受托管理人</p>
<p style="text-indent: 20px;">    名称：中新力合股份有限公司</p>
<p style="text-indent: 20px;">    注册地址：杭州市西湖区天目山路159号(现代国际大厦)8层806室</p>
<p style="text-indent: 20px;">    法定代表人：陈杭生</p>
<p style="text-indent: 20px;">    注册资本：人民币53000万元。</p>
<p style="text-indent: 20px;">    受托管理人与发行人签署受托管理合同，规定双方在标的计划项下资金管理、运用等方面的权利义务。</p>
<p style="text-align:center;font-weight:bold">五、标的计划的认购</p>
<p style="text-align:center;">第9页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt7, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);

$txt8 = <<<EOD
<p style="text-indent: 20px;">    （一）认购期间</p>
<p style="text-indent: 20px;">    1、认购标的计划的认购人应于募集期内，至转让人指定营业场所办理认购标的计划的手续，包括签署认购风险申明书、签署认购合同、交付认购资金。</p>
<p style="text-indent: 20px;">    若认购人系“政金网”注册用户，认购标的计划的认购人应于募集期内，通过“政金网”平台以协议方式进行交易，包括选择确认认购风险申明书、选择确认认购合同、在标的计划可投资范围内，自主选择相应额度的标的计划及金额、将投资标的计划所需的资金总额充入自己的资金托管账户。</p>
<p style="text-indent: 20px;">    2、各类标的计划募集成功的具体日期以“政金网”公告载明的日期为准。如标的计划首期实际募集规模已达到标的计划最高募集规模的, 标的计划将不再进行后续募集；如首期募集期内实际募集规模未达到标的计划最高募集规模的，标的计划将进行后续募集，直至实际募集规模达到标的计划最高募集规模。</p>
<p style="text-indent: 20px;">    （二）认购要求及资金缴付</p>
<p style="text-indent: 20px;">    1、认购主体</p>
<p style="text-indent: 20px;">    认购人应符合《政金网网站注册用户服务协议（个人用户/企业用户）》及有关监管规定条件的合格投资者。</p>
<p style="text-indent: 20px;">    2、资金要求</p>
<p style="text-indent: 20px;">    （1）认购资金应当是人民币资金。</p>
<p style="text-indent: 20px;">    （2）合格投资者认购标的计划份额的单笔认购资金金额最低为人民币1万元，并可按人民币1万元的整数倍增加。发行人有权根据标的计划募集情况决定单笔认购资金的最低金额。</p>
<p style="text-indent: 20px;">    3、认购资金的交付</p>
<p style="text-indent: 20px;">    发行人不接受现金认购，非“政金网”用户须通过银行转账的方式交付认购资金。</p>
<p style="text-indent: 20px;">    “政金网”注册用户须在“政金网”开立资金账户，并在确认认购金额后，将认购资金总额充入自己的资金托管账户，认购成功后，其认购资金将自动冻结，并由第三方支付系统在当天清算交割完成后即视为标的计划已投资成功。</p>

<p></p><p></p><p></p>

<p style="text-align:center;">第10页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt8, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);

$txt9 = <<<EOD

<p style="text-align:center;font-weight:bold">六、标的计划项下资金的管理、运用</p>
<p style="text-indent: 20px;">    （一）资金管理的方法</p>
<p style="text-indent: 20px;">    标的计划项下的资金管理、运用和处分由受托管理人进行。</p>
<p style="text-indent: 20px;">    （二）资金运用的方向</p>
<p style="text-indent: 20px;">$tmp15</p>
<p></p>
<p style="text-align:center;font-weight:bold">七、投资收益及分配</p>
<p style="text-indent: 20px;">    （一）投资收益的分配原则</p>
<p style="text-indent: 20px;">    1、发行人按照本合同的约定以全部投资金额扣除相关管理费用、承销费用、税费后的余额为限向认购人分配投资收益。</p>
<p style="text-indent: 20px;">    2、发行人以现金形式向认购人分配投资收益；</p>
<p style="text-indent: 20px;">    3、根据投资计划类别及认购人单笔认购资金的不同，各类投资计划的预期年化收益率以政金网上线产品为准。</p>


<p style="text-indent: 20px;">    （二）投资利益计算与分配</p>
<p style="text-indent: 20px;">    投资利益包括投资收益和投资本金两部分。</p>
<p style="text-indent: 20px;">    1、期间定期分配</p>
<p style="text-indent: 20px;">    标的计划存续期间，发行人于各类投资计划各自的定期核算日核算并支付应付利息。</p>
<p style="text-indent: 20px;">    发行人将应付利息通过受托管理人所管理的资金专用账户扣除应付未付相关管理费用后的余额为限向认购人进行定期分配，认购人持有的标的计划份额每个定期核算日的预期投资收益如下：</p>
<p style="text-indent: 20px;">    投资计划某期间的预期投资收益＝该期间该投资计划每日预期投资收益之和；</p>
<p style="text-indent: 20px;">    投资计划每日预期投资收益=认购金额×R÷365；</p>
<p style="text-indent: 20px;">    “R”指按本条第（一）款第3项或《认购风险申明书》第二部分“认购信息”条款确定的投资计划对应的预期年化收益率。</p>
<p style="text-align:center;">第11页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt9, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);


$txt10 = <<<EOD
<p style="text-indent: 20px;">    每个投资计划定期核算日分配的投资收益不超过上述预期投资收益。</p>
<p style="text-indent: 20px;">    发行人于每个定期核算日前10个工作日内将投资收益及相关管理费用汇入资金专用账户，由受托管理人向认购人进行分配。</p>
<p style="text-indent: 20px;">    2、到期还本付息</p>
<p style="text-indent: 20px;">    标的计划的投资本金及尚未获得分配的投资收益在标的计划终止日后的10个工作日内进行分配，但另有约定的除外。</p>
<p style="text-indent: 20px;">    各类各期投资计划预计存续期限届满时，投资计划应分配的投资本金及收益应不超过其到期时的预期投资本金及收益之和：</p>
<p style="text-indent: 20px;">    投资计划到期时的预期投资本金及收益之和=投资本金+预期投资总收益-已获分配的投资收益；</p>
<p style="text-indent: 20px;">    发行人于标的计划预计存续期间到期前10个工作日内将本类投资计划融资本金总额及剩余利息、相关管理费用汇入资金专用账户，由受托管理人向认购人进行分配。</p>
<p style="text-indent: 20px;">    （三）特别提示</p>
<p style="text-indent: 20px;">    受托管理人于分配日将认购人可获得分配的投资收益及可获得分配的投资本金（如有）划付至认购人用于接收投资收益和投资本金的指定账户。因认购人上述指定账户变更、注销或银行系统故障等原因，致使受托管理人无法按时向认购人进行分配的，受托管理人不承担责任。</p>
<p></p>
<p style="text-align:center;font-weight:bold">八、风险揭示和承担</p>
<p style="text-indent: 20px;">    （一）标的计划风险揭示</p>
<p style="text-indent: 20px;">    标的计划项下的投资资金运作存在盈利的机会，也存在损失的风险。尽管发行人和受托管理人将恪尽职守，履行诚实、信用、谨慎、有效管理的义务，以认购人获得最大利益为目的管理、运用、处分投资资金，但并不意味着承诺投资资金运用无风险。</p>
<p style="text-indent: 20px;">    投资资金在投资管理运用过程中，存在以下风险：</p>
<p style="text-indent: 20px;">    1.法律与政策风险</p>
<p style="text-indent: 20px;">    国家货币政策、财政税收政策、产业政策、投资政策、金融业监管政策等宏观政策及相关法律法规的调整与变化，都可能影响标的计划的设立及管理，从而影响投资财产的收益，进而影响认购人的收益水平。</p>
<p style="text-indent: 20px;">    2.市场风险</p>
<p></p><p></p><p></p>
<p style="text-align:center;">第12页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt10, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);


$txt11 = <<<EOD
<p style="text-indent: 20px;">    由于受到宏观经济运行的周期性变化或者通货膨胀等因素影响，标的计划的投资收益可能受到影响。</p>
<p style="text-indent: 20px;">    如果在标的计划期限内，市场利率发生变化，本标的计划项下已经发行份额的预期收益率及实际收益率均不随市场利率变动而变动。</p>
<p style="text-indent: 20px;">    3.经营风险</p>
<p style="text-indent: 20px;">    发行人可能因经营管理不善，利润减少，资产价值降低，从而影响本标的计划投资利益的实现。</p>
<p style="text-indent: 20px;">    4.信用风险</p>
<p style="text-indent: 20px;">    如果发行人的财务、资产、业务等发生任何不利变化，或发行人、担保人关于其签署的与本标的计划相关的交易文件中对其财务、资产、业务等的陈述或说明存在虚假、误导或遗漏，或违反其签署的与本标的计划有关的交易文件，或不履行其签署的与本标的计划有关的交易文件项下的义务，将可能对投资财产的价值或受托人管理、运用和处置投资财产造成不利影响，从而使认购人遭受损失。</p>
<p style="text-indent: 20px;">    5.流动性风险</p>
<p style="text-indent: 20px;">    认购人无权随时要求赎回其持有的投资受益权，可能导致其需要资金时不能随时变现，并可能使其丧失其他投资机会的风险。</p>
<p style="text-indent: 20px;">    6.担保措施风险</p>
<p style="text-indent: 20px;">$tmp16</p>
<p style="text-indent: 20px;">    7.标的计划提前终止风险</p>
<p style="text-indent: 20px;">    由于标的计划的预期投资收益按照标的计划实际存续天数计算，如发生标的计划提前终止，即发行人提前还本付息的情形，认购人的投资收益总额将减少。</p>
<p style="text-indent: 20px;">    8.标的计划延期终止风险</p>
<p style="text-indent: 20px;">    标的计划预计存续期限届满，因任何原因导致资金管理专户内的资金不足支付标的计划终止后预计应予支付的税费、规费、管理费、融资本金、投资收益等费用且标的计划项下投资财产尚未变现完毕的，本标的计划将自动进入延长期，且无须就此延期事宜召开认购人大会。延长期至投资财产全部变现完毕且发行人宣布标的计划终止之日止或虽投资财产未全部变现但投资财产中的现金部分足以支付预计应予支付的税费、规费、管理费、融资本金、投资收益等费用而发行人决定不再变现投资财产并宣布标的计划终止之日止。该种延期将导致认购人无法在原标的计划预计存续期限内实现投资收益。如发生延期终止的情形，投资财产的变现将可能导致标的计划投资利益的减少，从而影响到认购人预期投资利益的实现。</p>
<p style="text-indent: 20px;">    9.信息传递风险</p>
<p style="text-align:center;">第13页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt11, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);


$txt12 = <<<EOD
<p style="text-indent: 20px;">    发行人将按照投资文件有关“信息披露”的约定，通过“政金网”平台进行本标的计划的信息披露，认购人应根据“信息披露”的约定及时进行查询。如果认购人未及时查询，或由于通讯故障、系统故障以及其他不可抗力等因素的影响使得认购人无法及时了解产品信息，并由此影响认购人的投资决策，因此而产生的责任和风险由认购人自行承担。另外，认购人预留在“政金网”的有效联系方式变更的，应及时予以更改，如投资者未及时更改联系方式的，受托管理人将可能在需要联系投资者时无法及时联系上，并可能会由此影响投资者的投资决策，因此而产生的责任和风险由认购人自行承担。</p>
<p style="text-indent: 20px;">    10.其他风险</p>
<p style="text-indent: 20px;">    除上述提及的主要风险以外，战争、动乱、自然灾害等不可抗力因素和不可预料的意外事件的出现，将会严重影响经济的发展，可能导致投资资金的损失。</p>

<p style="text-align:center;font-weight:bold">九、标的计划的信息披露</p>
<p style="text-indent: 20px;">    （一）信息披露形式</p>
<p style="text-indent: 20px;">    发行人有权选择以下几种方式之一进行信息披露：</p>
<p style="text-indent: 20px;">    1、在“政金网”上发布（网址：http://www.zhengjinnet.com/）；</p>
<p style="text-indent: 20px;">    2、按认购人预留地址寄送；</p>
<p style="text-indent: 20px;">    3、按认购人预留电子邮件发送电子邮件；</p>
<p style="text-indent: 20px;">    4、发行人指定的场所存放备查。</p>
<p style="text-indent: 20px;">    如因认购人预留联系方式不完整或者错误的原因导致发行人不能及时有效通知，其损失由认购人承担。</p>
<p style="text-indent: 20px;">    发行人通过任意一种信息披露方式进行披露即视为发行人履行完毕信息披露义务。</p>
<p style="text-indent: 20px;">    （二）定期信息披露</p>
<p style="text-indent: 20px;">    1、募集情况报告</p>
<p style="text-indent: 20px;">    标的计划成立日或募集成功日后10个工作日内公布募集情况报告。</p>
<p style="text-indent: 20px;">    2、清算报告</p>
<p style="text-indent: 20px;">    标的计划终止后10个工作日内公布清算报告。</p>
<p style="text-indent: 20px;">    （三）临时信息披露</p>
<p></p><p></p><p></p>
<p style="text-align:center;">第14页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt12, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);


$txt13 = <<<EOD
<p style="text-indent: 20px;">    在标的计划运作过程中发生下列可能对认购人利益产生重大影响的事件时，发行人或受托管理人将于获知有关情况后3个工作日内向认购人披露，并自披露之日起7个工作日内向认购人提出应对措施：</p>
<p style="text-indent: 20px;">    1、标的计划提前终止；</p>
<p style="text-indent: 20px;">    2、投资资金发生或者可能面临重大损失；</p>
<p style="text-indent: 20px;">    3、标的计划的担保方不能继续提供有效的担保；</p>
<p style="text-indent: 20px;">    4、法律法规规定其他重大事项。</p>
<p style="text-indent: 20px;">    （四）其他</p>
<p style="text-indent: 20px;">    1、其他与标的计划相关且应当披露的信息根据国家法律、法规、规章的规定和监管部门的通知或决定的要求进行披露。</p>
<p style="text-indent: 20px;">    2、发行人通过“政金网”平台进行的信息披露，如果认购人未及时上网查看，则发行人不承担其后果。</p>
<p></p>
<p style="text-align:center;font-weight:bold">十、标的计划的变更、解除、终止和清算</p>
<p style="text-indent: 20px;">    （一）标的计划的变更、解除</p>
<p style="text-indent: 20px;">    本合同项下的标的计划设立后，除本合同另有规定的以外，未经发行人书面同意，认购人不得变更、撤销、解除或终止标的计划和/或《认购合同》。</p>
<p style="text-indent: 20px;">    （二）标的计划的终止</p>
<p style="text-indent: 20px;">    发生下述情形的，发行人有权决定是否终止标的计划：</p>
<p style="text-indent: 20px;">    （1）标的计划预计存续期限届满且未进入延长期；</p>
<p style="text-indent: 20px;">    （2）标的计划投资目的已经实现或无法实现；</p>
<p style="text-indent: 20px;">    （3）标的计划的结构和管理运作必须符合法律法规的规定，标的计划存续期限内如因任何原因导致计划项目的结构和管理运作与法律法规的规定存在冲突的；</p>
<p style="text-indent: 20px;">    （4）标的计划项下的债权本金及利息已全部偿还或债权、担保权已全部消灭；</p>
<p style="text-indent: 20px;">    （5）认购人大会决议或全体认购人一致以书面形式同意终止标的计划；</p>
<p style="text-indent: 20px;">    （6）在标的计划预计存续期限内或者延长期内，发行人根据投资文件或者交易文件的约定决定变现投资财产，或者根据标的计划运营情况自行决定变现投资财产，且投资财产已全部变现，或虽未变现但变现所得已足以支付标的计划终止后预计应予支付的税费、规费、管理费用、全部标的计划的本金及投资收益，发行人决定终止标的计划的；</p>
<p style="text-align:center;">第15页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt13, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);

$txt14 = <<<EOD
<p style="text-indent: 20px;">    （7）法律法规规定的其他情形。</p>
<p style="text-indent: 20px;">    （三）标的计划终止后的清算</p>
<p style="text-indent: 20px;">    标的计划终止，发行人和受托管理人应负责投资资金的保管、清理、变现、确认和分配。</p>
<p style="text-indent: 20px;">    标的计划终止，发行人按照本合同第七条规定的方式分配投资收益并通过受托管理人执行。</p>
<p style="text-indent: 20px;">    发行人在标的计划终止后10个工作日内编制清算报告，并以本合同第九条规定的方式报告认购人。全体认购人一致同意，标的计划清算报告无需审计。</p>
<p></p>
<p style="text-align:center;font-weight:bold">十一、认购人的权利与义务</p>
<p style="text-indent: 20px;">    （一）权利</p>
<p style="text-indent: 20px;">    1、有权按照投资文件的规定了解投资资金的管理、运用、处分及收支情况，并有权要求发行人或受托管理人作出说明。</p>
<p style="text-indent: 20px;">    2、有权查询、抄录或者复制与投资财产有关的账目以及处理投资事务的其他文件。</p>
<p style="text-indent: 20px;">    3、发行人违反投资目的处分投资资金或者因发行人原因处理资金不当致使投资财产受到损失的，有权组织其他认购人成立认购人大会，要求发行人恢复投资财产的原状或者予以赔偿。</p>
<p style="text-indent: 20px;">    4、受托管理人处分投资资金不当或者管理运用、处分投资资金有重大过失的，有权通过认购人大会申请人民法院解任受托管理人。</p>
<p style="text-indent: 20px;">    5、投资文件及法律法规规定的其他权利。</p>
<p style="text-indent: 20px;">    （二）义务</p>
<p style="text-indent: 20px;">    1、按投资文件的规定及时交付认购资金，并保证资金来源的合法性。</p>
<p style="text-indent: 20px;">    2、保证其享有签署投资文件的权利，并且就签署行为已经履行必要的批准授权手续。</p>
<p style="text-indent: 20px;">    3、投资文件及法律法规规定的其他义务。</p>
<p></p>
<p style="text-align:center;font-weight:bold">十二、发行人的权利和义务</p>
<p style="text-indent: 20px;">    1、发行人依据本合同及相关法律、法规的规定享有相应权利、承担相应义务，按期支付标的计划的利息及本金。</p>
<p style="text-indent: 20px;">    2、在标的计划存续期间，发行人应当根据本合同、相应法律法规及其他投资文件中的规定切实履行信息披露义务。</p>
<p style="text-indent: 20px;">    3、发行人应当指定专人负责本次标的计划发行和信息披露相关事务。</p>
<p style="text-align:center;">第16页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt14, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);

$txt15 = <<<EOD
<p style="text-indent: 20px;">    4、如发行人发生以下任何事件，发行人应当及时通知受托管理人并向认购人进行披露：</p>
<p style="text-indent: 20px;">    1）发行人未能按照本合同或募集说明书的约定按时、足额将到期的利息和本金划入指定账户；</p>
<p style="text-indent: 20px;">    2）发行人预计不能按照本合同或募集说明书的约定按时、足额支付即将到期的利息和本金；</p>
<p style="text-indent: 20px;">    3）发行人发生未能清偿其他到期债务的违约情况；</p>
<p style="text-indent: 20px;">    4）发行人新增借款或对外提供担保超过上年末净资产的20%；</p>
<p style="text-indent: 20px;">    5）发行人放弃债权或财产超过上年末净资产的10%；</p>
<p style="text-indent: 20px;">    6）发行人发生超过上年末净资产10%的重大损失；</p>
<p style="text-indent: 20px;">    7）发行人作出减资、合并、分立、解散及申请破产的决定；</p>
<p style="text-indent: 20px;">    8）发行人涉及重大诉讼、仲裁事项或者受到重大行政处罚的；</p>
<p style="text-indent: 20px;">    9）发行人高级管理人员涉及重大民事、刑事诉讼，或者已就重大经济事件接受有关部门调查；</p>
<p style="text-indent: 20px;">    10）法律、法规规定的其他应当披露的情形。</p>
<p style="text-indent: 20px;">    5、发行人从事经营活动，应当遵守法律法规的规定和本合同的约定，不得损害国家利益、社会公众利益和他人的合法权益。</p>

<p style="text-align:center;font-weight:bold">十三、违约责任</p>
<p style="text-indent: 20px;">    （一）违约责任</p>
<p style="text-indent: 20px;">    1、若发行人或认购人未履行其在本合同项下的义务，或一方在本合同项下的承诺或保证虚假或不真实，视为该方违反本合同。</p>
<p style="text-indent: 20px;">    2、投资文件各方应严格遵守投资文件的约定，任何一方违反文件的部分或全部约定，均应向守约方承担违约责任，并赔偿因其违约给守约方（含标的计划）造成的损失。</p>
<p style="text-indent: 20px;">    3、违约方应赔偿因其违约而给守约方造成的全部损失，包括合同履行后可以获得的利益，但不得超过违反合同一方订立合同时可以预见或应当预见的因违反合同可能造成的损失。</p>
<p style="text-indent: 20px;">    4、除非法律另有规定，认购人违约导致本标的计划被撤销或被确认无效，由此给标的计划项下其他的认购人和标的计划的财产造成损失的，由导致标的计划被撤销或被确认无效的认购人承担损失赔偿责任。</p>
<p style="text-indent: 20px;">    （二）免责</p>
<p style="text-indent: 20px;">    发生下列不可抗力情形时，当事人对于因下列原因而引起的损失可以免于承担相应责任：</p>
<p style="text-align:center;">第17页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt15, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);

$txt16 = <<<EOD
<p style="text-indent: 20px;">    1、地震、台风、水灾、火灾、战争等不可抗力之情况。</p>
<p style="text-indent: 20px;">    2、新的法律、法规的颁布、实施和现行的法律、法规的修改或有权机构对现行法律、法规的解释的变动。</p>
<p style="text-indent: 20px;">    3、国家的政治、经济、金融等状况发生重大变化。</p>

<p style="text-align:center;font-weight:bold">十四、税收处理</p>
<p style="text-indent: 20px;">    认购人与发行人应按有关法律规定各自依法纳税。</p>
<p style="text-indent: 20px;">    应当由投资财产承担的税费，按照法律、法规及国家有关部门的规定办理。</p>

<p style="text-align:center;font-weight:bold">十五、通知与送达</p>
<p style="text-indent: 20px;">    （一）地址变更的通知</p>
<p style="text-indent: 20px;">    认购人的通讯地址或联系方式以认购人在“政金网”注册填写/认购风险申明书中填写的内容为准。认购人通讯地址或联系方式发生变化的，应及时在“政金网”平台上进行修改/以书面形式在发生变化后的3个工作日内通知受托管理人或发行人。未经告知的，不得以此变更对抗发行人。</p>
<p style="text-indent: 20px;">    由于认购人的原因造成通知不能送达或送达有误的，所产生的后果由认购人自行承担。</p>
<p style="text-indent: 20px;">    发行人及受托管理人通讯地址、联系方式以投资计划说明书中约定为准。发行人通讯地址、联系方式发生变更的，发行人可自行选择以本合同规定的任一信息披露方式披露。</p>
<p style="text-indent: 20px;">    （二）通知的送达</p>
<p style="text-indent: 20px;">    认购人以专人送达、挂号信、传真、特快专递、电子邮件的方式，就处理投资事务过程中需要通知的事项通知本合同各方，通知在下列日期视为送达被通知方：</p>
<p style="text-indent: 20px;">    （1）专人送达：通知方取得的被通知方签收单所示日。</p>
<p style="text-indent: 20px;">    （2）挂号信邮递：发出通知方持有的国内挂号函件收据所示日后第5日</p>
<p style="text-indent: 20px;">    （3）传真：收到成功发送确认之日。</p>
<p style="text-indent: 20px;">    （4）特快专递：发出通知方持有的发送凭证上邮戳日起第4日。</p>
<p style="text-indent: 20px;">    （5）电子邮件：发件人邮件系统显示已成功发送之日。</p>
<p style="text-indent: 20px;">    发行人选择以专人送达、挂号信、传真、特快专递、电子邮件的方式就处理投资事务过程中需要通知的事项通知认购人的，通知送达日期的确定适用上一款的规定。</p>
<p style="text-indent: 20px;">    任何一方的通讯地址、电子邮箱和/或传真号码中的一项或多项发生变更，均应立即按照本合同规定以书面形式通知另一方；任何一方未就其通讯地址、电子邮箱、和/或传真号码中一项或多项的变更按照本条规定立即通知另一方的，另一方按照变更一方变更前的通讯地址和/或传真号码发送的书面通知，在发生本条规定情形时即视为有效送达，变更一方应自行承担因此而导致的任何法律、经济责任。</p>

<p style="text-align:center;">第18页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt16, 0, 1, 0, true, '', true);
$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);

$txt17 = <<<EOD
<p style="text-align:center;font-weight:bold">十六、适用法律与争议处理</p>
<p style="text-indent: 20px;">    本合同的订立、生效、履行、解释、修改和终止等事项适用中国法律。</p>
<p style="text-indent: 20px;">    与本合同有关的任何争议，各方应友好协商解决；若协商不能解决，任何一方均有权就有关争议向认购人住所地有管辖权的人民法院提起诉讼。</p>
<p style="text-indent: 20px;">    除双方发生争议的事项外，双方仍应当本着善意的原则按照本合同的规定继续履行各自义务。</p>

<p style="text-align:center;font-weight:bold">十七、其他事项</p>
<p style="text-indent: 20px;">    1、《认购风险申明书》是本合同不可分割的组成部分，和本合同具有同等法律效力。</p>
<p style="text-indent: 20px;">    2、本标的计划不因发行人的名称变更、法人变更、依法解散、被宣告破产或者被依法撤销而终止，也不因受托管理人的解任而终止，但法律或者投资文件另有规定的除外。</p>

<p style="text-indent: 20px;">    3、富友支付：上海富友支付服务有限公司作为持有第三方支付全牌照的第三方支付公司，为政金网客户资金提供第三方存管服务和支持。</p>

<p style="text-align:center;font-weight:bold">十八、认购合同的效力</p>
<p style="text-indent: 20px;">    1、认购合同自认购人（机构）法定代表人、负责人或其授权代表在认购合同上签字（或签章）并加盖单位公章之日或者认购人（自然人）在认购合同上签字之日，且转让人法定代表人或其授权代表在认购合同上签字（或签章或电子签章）并加盖单位公章（或电子签章）之日起生效。</p>
<p style="text-indent: 20px;">    通过“政金网”平台认购的注册用户（自然人）以其在“政金网”上点击确认的本认购合同内容且将认购资金充入自己的资金托管账户之日，且转让人法定代表人或其授权代表在认购合同上签字（或签章或电子签章）并加盖单位公章（或电子签章）之日起生效。</p>
<p style="text-indent: 20px;">    2、认购人签署或网上确认认购风险申明书、认购合同，即表明其愿意承担标的计划的各项风险，同意受认购合同约束。</p>
<p style="text-indent: 20px;">    3、认购合同可与其他投资文件共同印制成册，供投资者在转让人指定的办公场所或营业场所查阅。</p>
<p style="text-indent: 20px;">    4、针对“政金网”注册用户，本合同双方委托“政金网”保管所有本合同有关的书面文件和电子信息。</p>
<p style="text-indent: 20px;">    针对非“政金网”注册用户/机构，本认购合同一式贰份，认购人持壹份，转让人持壹份，具有同等法律效力。</p>
<p>（以下无正文）</p>
<p></p><p></p>
<p style="text-align:center;">第19页</p>
EOD;

$pdf->writeHTMLCell(0, 0, '', '', $txt17, 0, 1, 0, true, '', true);

$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 11, '', true);
$tmp1  = "（此页为编号为【".$contract_no."】的《".$owner_name."“".$project_name."”收益权转让计划认购合同》之签署页，无正文）";
$img1 = '<img src="themes/ecmoban_jumei/images/hehan_seal.png" width="300">';

$txt18 = <<<EOD
<p>$tmp1</p>
<p></p>
<p">认购人：</p>
<p">自然人（签字）</p>
<p></p>	
<p>机构（公章）</p>
<p>机构法定代表人、负责人或授权代表（签字或盖章）</p>
<p></p>

<p></p>
<p>转让人；</p>
<p></p>
$img
<p></p>
<p>签署日期：$format_paytime</p>
<p></p><p></p>
<p style="text-align:center;">第20页</p>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt18, 0, 1, 0, true, '', true);
// ---------------------------------------------------------

//Close and output PDF document
//$pdf->Output('/contact/test.pdf', 'I');
$pdf->Output('/contact/contact_'.$ssn.'.pdf', 'F');

}
//============================================================+
// END OF FILE
//============================================================+
