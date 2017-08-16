<?php
//============================================================+
// File name   : example_002.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 002 for TCPDF class
//               Removing Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Removing Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

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
$pdf->SetFont('stsongstdlight', '', 14, '', true);

// add a page
$pdf->AddPage();

$cat_name = "民生债";
$goods_name = "雅安荥经民生债001号";
$goods_serie = "雅安荥经民生债系列"; 
$company_name = "荥经县国有资产经营有限责任公司";
$company_code = "09814647-X";
$user_name = "小小王";
$user_id_number = "320501199201010101";
$amount_daxie = "伍万元整";
$amount_xiaoxie = "50000";
// set some text to print
$txt = <<<EOD
<div style="font-family:宋体;color:#111;">
		<div style="text-align:center;font-size:36px;font-weight:bold;">
			投资协议
		</div>
		<div style="line-height:24px;">
			<div style="font-size:18px;word-break:break-all">
				本次“<span style="text-decoration:underline;">$cat_name</span>”<span style="text-decoration:underline;"><span>$goods_name</span>投资协议</span>（简称“本协议”） <span>由</span><span>以</span><span>下</span><span>双</span><span>方</span><span>签</span><span>订</span><span>：</span>
			</div>
			<div style="font-size:18px;">
				甲方（姓名、企业名称）：<span>$company_name</span>（融资人）
				<br>
				身份证&nbsp;/&nbsp;组织机构代码号&nbsp;：$company_code
			</div>
			<div style="font-size:18px;">
				乙方（姓名、企业名称）：<span>$user_name</span>（投资人）
				<br>
				身份证&nbsp;/&nbsp;组织机构代码号&nbsp;：$user_id_number
			</div>
		</div>
		<div style="font-size:18px;line-height:24px;">
			<div>
				<div style="">鉴于：</div>
				<table>
					<tr>
						<td width="40">
							1、
						</td>
						<td width="600">
“<span>$goods_serie</span>” 经“政金网”登记、撮合、交易，“政金网”平台（www.zhengjinnet.com）为和瀚金融信息服务（上海）有限公司所属的互联网金融信息服务撮合平台；
						</td>
					</tr>
					<tr>
						<td>2、</td>
						<td>
						甲方作为融资人在“政金网”上线本计划；乙方作为投资人，承诺符合《政金网网站注册用户服务协议（个人用户/企业用户）》的要求，向甲方投资计划。
						<br>
						甲、 乙双方就计划的投资事宜，达成以下协议：
						</td>
					</tr>
				</table>
				<br><br>
				<table>
					<tr>
						<td width="55">一、</td>
						<td width="600">
							计划的基本情况<br>
							关于本计划的基本情况，详见“政金网”平台关于本计划“相关资料”中的《 <span>$goods_serie</span>投资说明书》（以下简称“计划投资说明书”）。甲、乙双方签署本协议，视作同意按照计划投资说明书各相关条款执行。<br>
						</td>
					</tr>
					<tr>
						<td>二、</td>
						<td>
						交易数量和价格<br>
						乙方同意基于计划投资说明书中交易额度和价格的相关条款投资本计划，投资金额人民币<span style="text-decoration:underline;">$amount_daxie</span>（小写<span style="text-decoration:underline;">$amount_xiaoxie</span>元），投资计划简称“<span>$goods_name</span>”。<br>
						</td>
					</tr>
					<tr>
						<td>三、</td>
						<td>
						交易方式<br>
						计划通过“政金网”平台协议方式交易。<br>
						</td>
					</tr>
					<tr>
						<td>四、</td>
						<td>
						交易流程<br>
						4.1&nbsp;甲乙交易双方须为“政金网”用户，尚未开户的须在交易前开立账户。<br>
						4.2&nbsp;乙方应于交易前选择确认“遵从本投资协议”，乙方确认后视作认同签署本投资协议，本协议成立并立即生效。<br>
						4.3&nbsp;乙方在本计划可投资范围内，自主选择相应额度的计划（以下简称“标的计划”）及金额进行投资。<br>
						4.4&nbsp;乙方应在投资前将投资标的计划所需的资金总额充入自己的资金托管账户，投资成功后，投资标的计划的资金将自动冻结，并由第三方支付系统在当天清算交割完成后即视为标的计划已投资成功。<br>
						</td>
					</tr>
					<tr>
						<td>五、</td>
						<td>
						计划清算和登记<br>
						本计划在“政金网”交易时间内投资的（交易时间以计划投资说明书及“政金网”公告为准），于当日完成清算登记，“政金网”根据清算数据将所投资的标的计划登记在乙方名下。<br>
						</td>
					</tr>
					<tr>
						<td>六、</td>
						<td>
						效力<br>
						自标的计划投资成功之日起，乙方即成为标的计划的持有人，继承甲方根据计划投资说明书及本协议约定所享有的对标的计划的所有权利及义务。<br>
						</td>
					</tr>
					<tr>
						<td>七、</td>
						<td>
						违约责任<br>
						由于非人力可控制原因或第三方原因，如技术条件限制、通讯线路故障等原因，导致标的计划无法完成交易，遇上上述情形的一方不承担违约或赔偿责任，但应在知晓上述情况后立即将情况通知对方。<br>
						</td>
					</tr>
					<tr>
						<td>八、</td>
						<td>
						陈述与保证<br>
						8.1&nbsp;甲、乙双方均保证其为合法设立并有效存续的法人或具有完全民事行为能力的自然人，有权签署并履行本协议。<br>
						8.2.1&nbsp;乙方本次交易行为以及投资资金来源均符合有关法律法规性文件的规定，包括但不限于有关反洗钱等方面法律法规和规范性文件的规定。乙方确认其清楚并愿意严格遵守中华人民共和国反贪污受贿等法律法规及规范性文件的规定，承诺在签订并履行本协议时，廉洁自律，不接受不当利益。<br>
						8.2.2&nbsp;乙方承诺有足够的专业胜任能力对本计划的投资作独立的投资分析及决定。<br>
						8.2.3&nbsp;乙方已认真阅读本计划的投资说明书及其他有关的信息披露文件，其投资本计划在完全知悉和充分考虑本计划投资风险的基础上，作出的独立投资判断。<br>
						8.3&nbsp;甲乙双方承诺，知晓本计划的交易完全是一种市场行为，本计划不存在优先受偿权。若未来出现融资人未能到期兑付该项目融资款等情形，风险由双方自行承担，与本次投资登记方“政金网”无关。<br>
						</td>
					</tr>
					<tr>
						<td>九、</td>
						<td>
						无可抗力<br>
						如发成不可抗力事件，遭受该事件的一方应立即用可能的最快捷的方式通知对方，并在十五天内提供书面证明文件说明有关事件的细节和不能履行或需延迟履行本协议的原因，然后由各方协商是否延期履行本协议或终止本协议。<br>
						“不可抗力”是指本协议各方的注册地、营业地或本协议履行地发生对其不能预见、不能避免和不能克服的事件，该事件妨碍、影响或延误任何乙方根据本协议履行其全部或部分义务。该事件包括但不限于：<br>
						（1）地震、台风、水灾、火灾、战争等不可抗力之情况；<br>
						（2）新的法律、法规的颁布、实施和现行的法律、法规的修改或有权机构对现行法律、法规的解释的变动；<br>
						（3）国家的政治、经济、金融等状况的重大变化。<br>
						</td>
					</tr>
					<tr>
						<td>十、</td>
						<td>
						争议解决机制<br>
						对因本协议收益分配、偿付等其他有关事项的解释和履行发生的争议，以及履行本协议而产生或与本协议有关的任何争议，各方应首先通过协商解决。若协商未成，甲、乙双方可向投资人住所地法院申请司法诉讼。<br>
						</td>
					</tr>
					<tr>
						<td>十一、</td>
						<td>
						其他<br>
						11.1&nbsp;本协议适用中华人民共和国法律并从其解释。甲乙双方均确认，若本协议中的任何一条或多条违反适用的法律法规，则该条被视为无效，但该无效条款并不影响本协议其他条款的效力。<br>
						11.2&nbsp;本协议的任何修改、补充均以“政金网”电子文本形式作出。投资说明书、补充协议与本协议具有同等法律效力。<br>
						11.3&nbsp;本协议双方委托“政金网”保管所有本协议有关的书面文件和电子信息。<br>
						</td>
					</tr>
				</table>
			</div>
		</div>

</div>

EOD;

// print a block of text using Write()
$pdf->writeHTMLCell(0, 0, '', '', $txt, 0, 1, 0, true, '', true);

// add a page
$pdf->AddPage();
$txt2 = <<<EOD
		<div style="padding:50px 0px 50px 0px;font-size:18px;line-height:24px;">
			（本页无正文，为《<span style="text-decoration:underline;"><span>$goods_serie</span>投资协议</span>》签章页）
		</div>
		<br><br><br><br><br><br>

		<img src="images/tampon.jpg" alt="test alt attribute" width="100" height="100" border="0" />

EOD;
$pdf->writeHTMLCell(0, 0, '', '', $txt2, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
