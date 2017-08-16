<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
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
 * @abstract TCPDF - Example: Default Header and Footer
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


// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('stsongstdlight', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = <<<EOD
<div style="padding:0px 200px 0px 200px;font-family:宋体;color:#111;">
		<div style="text-align:center;font-size:36px;font-weight:bold;">
			投资协议
		</div>
		<div style="line-height:24px;">
			<div style="padding:10px 0px 20px 0px;font-size:18px;">
				本次“<span style="text-decoration:underline;">民生债</span>” <span style="text-decoration:underline;">雅安荥经民生债1号投资协议</span>（简称“本协议”）由以下双方签订：
			</div>
			<div style="padding:10px 0px 0px 0px;font-size:18px;">
				甲方（姓名、企业名称）：<span style="text-decoration:underline;">荥经县国有资产经营有限责任公司</span>（融资人）
			</div>
			<div style="padding:0px 0px 20px 0px;font-size:18px;">
				身份证 /组织机构代码号：<span style="text-decoration:underline;">09814647-X</span>
			</div>
			<div style="padding:10px 0px 0px 0px;font-size:18px;">
				乙方（姓名、企业名称）：<span style="text-decoration:underline;">小小王</span>（投资人）
			</div>
			<div style="padding:0px 0px 0px 0px;font-size:18px;">
				身份证 /组织机构代码号：<span style="text-decoration:underline;">320501199201010101</span>
			</div>
		</div>
		<div style="font-size:18px;line-height:24px;">
			<div style="padding:30px 0px 10px 0px;">
				<div style="">鉴于：</div>
				<div style="padding:10px 0px 5px 0px;">
					<div style="float:left;width:4%;">1、</div>
					<div style="float:left;width:94%;text-align: justify;text-justify:inter-ideograph;">
						“ ”经“政金网”登记、撮合、交易，“政金网”平台（www.zhengjinnet.com）为和瀚金融信息服务（上海）有限公司所属的互联网金融信息服务撮合平台；
					</div>
					<div class="clearfix">&nbsp;</div>
				</div>
				<div style="padding:5px 0px 5px 0px;">
					<div style="float:left;width:4%;">2、</div>
					<div style="float:left;width:94%;text-align: justify;text-justify:inter-ideograph;">
						甲方作为融资人在“政金网”上线本计划；乙方作为投资人，承诺符合《政金网网站注册用户服务协议（个人用户/企业用户）》的要求，向甲方投资计划。
					</div>
					<div class="clearfix">&nbsp;</div>
					<div style="padding-left:37px;">
						甲、 乙双方就计划的投资事宜，达成以下协议：
					</div>
				</div>
			</div>
			<div>
				<div style="padding:20px 0px 10px 0px;">
					<div style="float:left;width:4%;">一、</div>
					<div style="float:left;width:94%;text-align: justify;text-justify:inter-ideograph;">计划的基本情况</div>
					<div class="clearfix">&nbsp;</div>
					<div style="padding-left:37px;">
						关于本计划的基本情况，详见“政金网”平台关于本计划“相关资料”中的《 说明书》（以下简称“计划投资说明书”）。甲、乙双方签署本协议，视作同意按照计划投资说明书各相关条款执行。
					</div>
				</div>
				<div style="padding:20px 0px 10px 0px;">
					<div style="float:left;width:4%;">二、</div>
					<div style="float:left;width:94%;text-align: justify;text-justify:inter-ideograph;">交易数量和价格</div>
					<div class="clearfix">&nbsp;</div>
					<div style="padding-left:37px;">
						乙方同意基于计划投资说明书中交易额度和价格的相关条款投资本计划，投资金额人民币 （小写 元），投资计划简称“ ”。
					</div>
				</div>
			</div>
		</div>	
</div>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('/tcpdf/examples/example_001.pdf', 'I');//F

//============================================================+
// END OF FILE
//============================================================+
