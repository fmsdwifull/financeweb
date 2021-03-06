<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,compare.js')); ?>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=mPMUzPfrPBzAfGp8jG1bzYRmmG6Y9Ev8"></script>
</head>
<body style="font-family: Helvetica, Tahoma, Arial, 'Microsoft YaHei', '微软雅黑', SimSun, '宋体', Heiti, '黑体', sans-serif;background-color: #ecedee;font-size: 14px;">
<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php echo $this->fetch('library/right_link.lbi'); ?>


<div style="background:url(themes/ecmoban_jumei/images/beian.jpg) center 0 no-repeat; position:relative;height:370px;width:100%"></div>
<div class="block" style="color:#000;width:1200px;margin:0 auto;">
	<div style="font-size:130%;border-bottom:3px red solid;width:1200px;margin-top:3%;">
		<img src="themes/ecmoban_jumei/images/beian_icon.png"/>
	</div>
	<div style="margin-top:3%;width:1200px;height:800px;center 0 no-repeat">
		<div style="float:left;width:30%;">
			<div onclick="show_partner_brief(1)" style="width:70%;border:1px solid black;margin-left:0%;">
				<img src="themes/ecmoban_jumei/images/12.png" style="width:57%;margin:0 auto;display:block;border:0px;"/>
			</div>
			<div onclick="show_partner_brief(2)" style="width:70%;border:1px solid black;margin-left:0%;margin-top:10%;">
				<img src="themes/ecmoban_jumei/images/02.png" style="width:57%;margin:0 auto;display:block;border:0px;"/>
			</div>
			<div onclick="show_partner_brief(3)" style="width:70%;border:1px solid black;margin-left:0%;margin-top:10%;">
				<img src="themes/ecmoban_jumei/images/10.png" style="width:57%;margin:0 auto;display:block;border:0px;"/>
			</div>
		</div>
		<div style="float:left;width:70%;">
			<div id="partner_brief" style="text-indent:2em;width:100%;"></div>
		</div>
	</div>
</div>




<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>

<script>
	function show_partner_brief(num){
		if(num==1){
			var brief="<div style='font-size:200%;width:100%;text-align:center;padding:20px 0 30px 0;'><p>海南股权交易中心</p></div>";	
			brief+="<p>海南股权交易中心有限责任公司（以下简称“本中心”）已于2014年9月23日取得营业执照，并于2014年12月28日正式揭牌运营。公司注册资本5000万元人民币，由国有大型省属企业海南省发展控股有限公司和互联网金融旗舰企业宜信公司共同组建。</p>";
			brief+="<p>成立宗旨</p>";
			brief+="<p>2014 年《国务院关于进一步促进资本市场健康发展的若干意见》（国发〔2014〕17号）明确提出加快多层次资本市场建设,并将区域性股权市场纳入多层次资本市场体系。而区域性股权交易市场是为特定区域内的企业提供股权、债券的转让和融资服务的私募市场，是我国多层次资本市场的重要组成部分，亦是中国多层次资本市场建设中必不可少的部分。对于促进企业特别是中小微企业股权交易和融资，鼓励科技创新和激活民间资本，加强对实体经济薄弱环节的支持，具有积极作用。股交中心的成立，是海南省贯彻落实国务院发展和完善多层次资本市场的重大举措，旨在解决中小企业融资难题、提升企业核心竞争力、推动我省经济结构调整，带动地经济发展、助力国际旅游岛建设。</p>";
			brief+="<p>股东背景</p>";
			brief+="<p>股东海南省发展控股有限公司（以下简称“海南控股”），成立于2005年2月，由海南省国资委履行出资人职责，是海南省最大的综合性投资控股公司。经过十年的发展积淀，海南控股规模实力大幅提升，初步形成了基础设施、金融、区域综合开发、新兴产业(新能源、水务环保、医疗旅游、海洋等)四大业务板块，海南控股下辖全资子公司7家，主要控股公司5家，参股公司16家，投资2只基金。截至2015年底，公司资产总额485.08亿元，净资产306.08亿元。</p>";
			brief+="<p>股东宜信公司创建于2006年，总部位于北京。成立十年以来，宜信坚持以理念创新、模式创新和技术创新服务中国高成长性人群、大众富裕阶层和高净值人士。目前已在244个城市（含香港）和93个农村地区建立起强大的全国协同服务网络，通过大数据金融云、物联网和其他金融创新科技，为客户提供全方位、个性化的普惠金融、财富管理和互联网金融服务。</p>";
			brief+="<p>业务领域</p>";
			brief+="<p>本中心立足海南，可为企业提供股权、债权和其他权益类资产的登记、托管、挂牌、转让和融资服务，对挂牌企业进行培育、辅导和规范，并通过金融创新，为挂牌企业提供财务咨询和多样化的金融服务。</p>";
			brief+="<p>传统业务：本中心针对中小企业实际情况设定了交易板和展示板，制定了挂牌门槛，符合条件的企业即可申请挂牌。本中心根据挂牌企业的融资需求和运营情况，整合券商、投资公司、银行、担保公司和保险公司等机构资源，为企业提供股权交易、股权质押融资和信用融资等机会。</p>";
			brief+="<p>创新业务：本中心运用互联网技术手段，将“开放、平等、协作、分享”的互联网精神融入发展建设过程，为市场参与各方搭建便捷、高效、低成本的综合金融服务平台。本中心将通过发行中小企业私募债、高成长企业债、收益权转让产品等多种融资模式为挂牌企业提供多元化融资服务。同时，本中心积极探索资产证券化产品的发行和交易，以及股权众筹业务的设计和推行，并支持小额、多次、快速的私募融资,对接各类财富管理机构，通过一系列现代金融的手段切实解决中小企业、高成长企业融资难的问题。</p>";
			brief+="<p>增值业务：本中心为挂牌企业创造电视、网络和纸媒等多种渠道的宣传机会，以提高企业品牌影响力；同时，定期对挂牌企业进行培训，提供金融、法律、财务和管理等方面的免费咨询服务，以提升企业专业水平和管理水平；此外，通过路演、论坛、对接会等多种形式，帮助挂牌企业对接融资、产品和服务等供求信息，全方位辅助企业成长壮大。</p>";
			
			document.getElementById("partner_brief").innerHTML=brief;
		}else if(num==2){
			var brief="<div style='font-size:200%;width:100%;text-align:center;padding:20px 0 30px 0;'>广州金融资产交易中心</div>";	
			brief+="<p>广州金融资产交易中心注册资本6000万元，是贯彻落实国务院批准实施的《珠江三角洲地区改革发展规划纲要（2008-2020）》，遵循国务院关于交易场所建设和运营的有关规定，经广东省人民政府批准设立的金融资产交易市场，于2014年4月18日正式开业运营。</p>";
			brief+="<p>广州金融资产交易中心主要为各类基础金融资产，以及基于金融资产开发的金融证券化产品、金融衍生品提供登记、托管、信息发布、清算交收等服务，是我国金融市场不可或缺的组成部分，在金融资源配置中发挥着基础性作用。</p>";
			brief+="<p>广州金融资产交易中心的设立运营对完善我国金融市场体系，增强金融服务实体经济功能，推进广东省金融改革创新和广州区域金融中心建设，加快广东省产业转型升级和经济发展方式转变，建设幸福广东具有重要战略意义。</p>";
			brief+="<p>◆ 发展定位</p>";
			brief+="<p>高效、透明、低成本的金融资产交易平台</p>";
			brief+="<p>◆ 运营宗旨</p>";
			brief+="<p>会员多元化；</p>";
			brief+="<p>交易高效化；</p>";
			brief+="<p>成本低廉化；</p>";
			brief+="<p>服务标准化；</p>";
			brief+="<P>平台国际化。</p>";
			brief+="<p>◆ 经营理念</p>";
			brief+="<p>服务创造价值</p>";
			brief+="<p>创新成就飞跃</p>";
			brief+="<p>合作实现共赢</P>"+"<p>◆ 业务范围</P>"+"<p>组织和监督交易活动，发布金融资产交易信息；</P>"+"<P>代理金融资产买卖服务；</P>"+"<P>提供资金清算服务；</P>"+"<P>提供信用评级服务；</P>"+"<P>提供综合服务；</P>"+"<P>经监管部门核准的其他业务。</P>";
			
			document.getElementById("partner_brief").innerHTML=brief;
		}else {
			var brief="<div style='font-size:200%;width:100%;text-align:center;padding:20px 0 30px 0;'>东北亚创新金融资产交易中心</div>";	
			brief+="<p>吉林东北亚创新金融资产交易中心（以下简称“东金中心”）由吉林省人民政府于2014年11月7日批准设立。在省金融办大力推动下，来自于沪、浙、京5家专业发起人联合吉林本地政府平台公司共同设立，注册资本2亿元整。</p>";
			brief+="<p>东金中心本着立足吉林，面向东北，辐射全国的原则，致力成为金融产业创新引导者，金融风险管理实践者，金融资源配置服务商，打造东北地区透明度最高、公信力最强、影响力最大的专业化金融资产交易平台。</p>";
			brief+="<p>监督管理</p>";
			brief+="<p>批准单位：吉林省人民政府</p>";
			brief+="<p>监管机构：吉林省金融工作办公室</p>";
			brief+="<p>战略定位</p>";
			brief+="<p>金融产业创新引导者 金融风险管理实践者  金融资源配置服务商</p>";
			brief+="<p>主要功能 </p>";
			brief+="<p>汇聚金融信息资源    优化金融资源配置</p>";
			brief+="<P>规范金融资产交易    加速金融助力企业</p>";
			brief+="<P>业务涵盖范围：在符合金融监管部门监管要求下，开展债权类资产交易、小额贷款产品交易、信托受益权交易、非上市企业股权交易、企业产权交易等及配套服务，金融产品的研究  开发、组合设计、咨询服务，金融和经济咨询服务、市场调研及数据分析服务，提供金融相关托管、结算等服务，开展组合金融工具应用、综合金融创新业务，金融  类应用软件开发，电子商务。</p>";
			
			
			document.getElementById("partner_brief").innerHTML=brief;
		}
		
	}
	window.onload=function(){
		var brief="<div style='font-size:200%;width:100%;text-align:center;padding:20px 0 30px 0;'>海南股权交易中心</div>";	
		brief+="<p>海南股权交易中心有限责任公司（以下简称“本中心”）已于2014年9月23日取得营业执照，并于2014年12月28日正式揭牌运营。公司注册资本5000万元人民币，由国有大型省属企业海南省发展控股有限公司和互联网金融旗舰企业宜信公司共同组建。</p>";
		brief+="<p>成立宗旨</p>";
		brief+="<p>2014 年《国务院关于进一步促进资本市场健康发展的若干意见》（国发〔2014〕17号）明确提出加快多层次资本市场建设,并将区域性股权市场纳入多层次资本市场体系。而区域性股权交易市场是为特定区域内的企业提供股权、债券的转让和融资服务的私募市场，是我国多层次资本市场的重要组成部分，亦是中国多层次资本市场建设中必不可少的部分。对于促进企业特别是中小微企业股权交易和融资，鼓励科技创新和激活民间资本，加强对实体经济薄弱环节的支持，具有积极作用。股交中心的成立，是海南省贯彻落实国务院发展和完善多层次资本市场的重大举措，旨在解决中小企业融资难题、提升企业核心竞争力、推动我省经济结构调整，带动地经济发展、助力国际旅游岛建设。</p>";
		brief+="<p>股东背景</p>";
		brief+="<p>股东海南省发展控股有限公司（以下简称“海南控股”），成立于2005年2月，由海南省国资委履行出资人职责，是海南省最大的综合性投资控股公司。经过十年的发展积淀，海南控股规模实力大幅提升，初步形成了基础设施、金融、区域综合开发、新兴产业(新能源、水务环保、医疗旅游、海洋等)四大业务板块，海南控股下辖全资子公司7家，主要控股公司5家，参股公司16家，投资2只基金。截至2015年底，公司资产总额485.08亿元，净资产306.08亿元。</p>";
		brief+="<p>股东宜信公司创建于2006年，总部位于北京。成立十年以来，宜信坚持以理念创新、模式创新和技术创新服务中国高成长性人群、大众富裕阶层和高净值人士。目前已在244个城市（含香港）和93个农村地区建立起强大的全国协同服务网络，通过大数据金融云、物联网和其他金融创新科技，为客户提供全方位、个性化的普惠金融、财富管理和互联网金融服务。</p>";
		brief+="<p>业务领域</p>";
		brief+="<p>本中心立足海南，可为企业提供股权、债权和其他权益类资产的登记、托管、挂牌、转让和融资服务，对挂牌企业进行培育、辅导和规范，并通过金融创新，为挂牌企业提供财务咨询和多样化的金融服务。</p>";
		brief+="<p>传统业务：本中心针对中小企业实际情况设定了交易板和展示板，制定了挂牌门槛，符合条件的企业即可申请挂牌。本中心根据挂牌企业的融资需求和运营情况，整合券商、投资公司、银行、担保公司和保险公司等机构资源，为企业提供股权交易、股权质押融资和信用融资等机会。</p>";
		brief+="<p>创新业务：本中心运用互联网技术手段，将“开放、平等、协作、分享”的互联网精神融入发展建设过程，为市场参与各方搭建便捷、高效、低成本的综合金融服务平台。本中心将通过发行中小企业私募债、高成长企业债、收益权转让产品等多种融资模式为挂牌企业提供多元化融资服务。同时，本中心积极探索资产证券化产品的发行和交易，以及股权众筹业务的设计和推行，并支持小额、多次、快速的私募融资,对接各类财富管理机构，通过一系列现代金融的手段切实解决中小企业、高成长企业融资难的问题。</p>";
		brief+="<p>增值业务：本中心为挂牌企业创造电视、网络和纸媒等多种渠道的宣传机会，以提高企业品牌影响力；同时，定期对挂牌企业进行培训，提供金融、法律、财务和管理等方面的免费咨询服务，以提升企业专业水平和管理水平；此外，通过路演、论坛、对接会等多种形式，帮助挂牌企业对接融资、产品和服务等供求信息，全方位辅助企业成长壮大</p>";
		
		document.getElementById("partner_brief").innerHTML=brief;
		
		
		
	var oTop = document.getElementById("b_4");
	  var screenw = document.documentElement.clientWidth || document.body.clientWidth;
	  var screenh = document.documentElement.clientHeight || document.body.clientHeight;
	  oTop.style.left = screenw - oTop.offsetWidth +"px";
	  oTop.style.top = screenh - oTop.offsetHeight + "px";
	  window.onscroll = function(){
		var scrolltop = document.documentElement.scrollTop || document.body.scrollTop;
		oTop.style.top = screenh - oTop.offsetHeight + scrolltop +"px";
	  }
	  oTop.onclick = function(){
		document.documentElement.scrollTop = document.body.scrollTop =0;
	  }
	  
	  var oTop = document.getElementById("bt_4");
	  var screenw = document.documentElement.clientWidth || document.body.clientWidth;
	  var screenh = document.documentElement.clientHeight || document.body.clientHeight;
	  oTop.style.left = screenw - oTop.offsetWidth +"px";
	  oTop.style.top = screenh - oTop.offsetHeight + "px";
	  window.onscroll = function(){
		var scrolltop = document.documentElement.scrollTop || document.body.scrollTop;
		oTop.style.top = screenh - oTop.offsetHeight + scrolltop +"px";
	  }
	  oTop.onclick = function(){
		document.documentElement.scrollTop = document.body.scrollTop =0;
	  }
	  
	}
	
	
	
	function show_block(key){
		
		document.getElementById("b_1").style.display="none";
		document.getElementById("b_2").style.display="none";
		document.getElementById("b_3").style.display="none";
		document.getElementById("b_4").style.display="none";
		
		
		
		document.getElementById("bt_1").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_2").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_3").style.backgroundColor="#7a6e6e";
		document.getElementById("bt_4").style.backgroundColor="#7a6e6e";
		
		if(key==1){
			document.getElementById("b_1").style.display="";
			document.getElementById("bt_1").style.backgroundColor="red";
		}
		if(key==2){
			document.getElementById("b_2").style.display="";
			document.getElementById("bt_2").style.backgroundColor="red";
		}
		if(key==3){
			document.getElementById("b_3").style.display="";
			document.getElementById("bt_3").style.backgroundColor="red";
		}
		if(key==4){
			document.getElementById("b_4").style.display="";
			document.getElementById("bt_4").style.backgroundColor="red";
		}
		
	}
	
	
	
	
	
	
</script>


</html>
