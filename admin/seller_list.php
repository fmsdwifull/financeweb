<?php

	
	define('IN_ECS', true);
	require(dirname(__FILE__) . '/includes/init.php');
	admin_priv('seller_list');
	
	if($_REQUEST['act']=='list'){
		
		$sql='select * from'.$GLOBALS['ecs']->table('seller');
		$list=$GLOBALS['db']->getAll($sql);
		
		foreach($list as $k=>$v){
			if($v['region_id']){
				
				if($v['store_id']){
					$sql='select store_name from '.$GLOBALS['ecs']->table('store').' where store_id='.$v['store_id'];
					$store_name=$GLOBALS['db']->getOne($sql);
					$list[$k]['job']=$store_name.'小职员';
				}else{
					if($v['store_manager']){
						$sql='select store_name from '.$GLOBALS['ecs']->table('store').' where store_id='.$v['store_manager'];
						$store_name=$GLOBALS['db']->getOne($sql);
						$list[$k]['job']=$store_name.'店长';
					}
				}				
			}else{
				
				if($v['region_manager']){
					$sql='select region_name from '.$GLOBALS['ecs']->table('seller_region').' where id='.$v['region_manager'];
					$region_name=$GLOBALS['db']->getOne($sql);
					$list[$k]['job']=$region_name.'省区长';
				}
			}
			
		}
		
		$smarty->assign('action_link',  array("href"=>"seller_list.php?act=add","text"=>"添加业务员"));
		$smarty->assign('seller_list',$list);
		$ur_here ="业务员账号列表";
		$smarty->assign('ur_here', $ur_here);
		$smarty->assign('full_page',    1);
		$smarty->display('seller_list.htm');
	}elseif($_REQUEST['act']=='add' || $_REQUEST['act']=='edit'){
		//print_r("123");
		$sql='select * from '.$GLOBALS['ecs']->table('seller_region');
		$region_list=$GLOBALS['db']->getAll($sql);
		$sql='select account_id,account_name from '.$GLOBALS['ecs']->table('fuiou_account_config');
		$fuiou_list=$GLOBALS['db']->getAll($sql);
		$sql='select admin_id from '.$GLOBALS['ecs']->table('seller').' where admin_id is not null ';
		$admin_id_list=$GLOBALS['db']->getAll($sql);
		$dou='';
		foreach($admin_id_list as $v){	
			$str.=$dou.$v['admin_id'];
			$dou=',';
		}
		
		$sql='select user_id,user_name from '.$GLOBALS['ecs']->table('admin_user').' where user_id not in('.$str.')';
		//$sql='select user_id,user_name from '.$GLOBALS['ecs']->table('admin_user').' where user_id  in(3,4,5)';
		$admin_list=$GLOBALS['db']->getAll($sql);
		
		if($_REQUEST['act']=='edit'){
			$sql='select * from '.$GLOBALS['ecs']->table('seller').' where  seller_id='.$_GET['id'];
			$seller_list=$GLOBALS['db']->getRow($sql);
			$smarty->assign('seller_list',$seller_list);
			$sql='select user_id,user_name from '.$GLOBALS['ecs']->table('admin_user').' where user_id='.$seller_list['admin_id'];
			$admin_one=$GLOBALS['db']->getRow($sql);
			$count=count($admin_list);
			$admin_list[$count]['user_id']=$admin_one['user_id'];
			$admin_list[$count]['user_name']=$admin_one['user_name'];
		}
		
		$smarty->assign('act',$_REQUEST['act']);
		$smarty->assign('region_list',$region_list);
		$smarty->assign('fuiou_list',$fuiou_list);
		$smarty->assign('admin_list',$admin_list);
		$smarty->display('seller_info.htm');
		
	}elseif($_REQUEST['act']=='add_seller'){
		//print_r("123");exit();
		$name=$_POST['seller_name'];
		$num=$_POST['seller_no'];
		$get_reserve=$_POST['get_reserve'];
		$fuiou_account_id=$_POST['fuiou_account_id'];
		$admin_id=$_POST['admin_id'];
		$seller_mac = $_POST['seller_mac'];
		
		//如果,存在 $seller_mac,添加到mac_list表里。
		$map=' admin_no,mac,fuiou_account_id ';
		if($seller_mac){
			$sql="insert into ".$GLOBALS['ecs']->table('mac_list')." (".$map.") values('$admin_id','$seller_mac',7)";
			$res=$GLOBALS['db']->query($sql);
		}
		
		$where=' admin_id,seller_name,seller_no,seller_mac,store_id,store_manager,region_id,region_manager,get_reserve,fuiou_account_id';
		
		if(!empty($_POST['region_id'])){
			
			if(!empty($_POST['region_manager'])){
				//区长
				$sql="insert into ".$GLOBALS['ecs']->table('seller')." (".$where.") values($admin_id,'$name','$num','$seller_mac',0,0,0,{$_POST['region_manager']},$get_reserve,$fuiou_account_id)";	
			}else{
				
				if(!empty($_POST['store_id'])){
					
						//店长或者小职员
						if($_POST['store_manager']>0){
							$sql="insert into ".$GLOBALS['ecs']->table('seller')." (".$where.") values($admin_id,'$name','$num','$seller_mac',0,{$_POST['store_manager']},{$_POST['region_id']},0,$get_reserve,$fuiou_account_id)";	
						}elseif($_POST['store_manager']==='0'){
							$sql="insert into ".$GLOBALS['ecs']->table('seller')." (".$where.") values($admin_id,'$name','$num','$seller_mac',{$_POST['store_id']},{$_POST['store_manager']},{$_POST['region_id']},0,$get_reserve,$fuiou_account_id)";		
						}			
				}else{
					sys_msg('缺少东西');
				}
			}	
		}else{
			
				sys_msg('缺少东西');
		}  
		$res=$GLOBALS['db']->query($sql);
		//print_r($res);
		if($res){
			
			$links[0]['text'] = '继续添加';
			$links[0]['href'] = 'seller_list.php?act=add';
			sys_msg('添加成功','0',$links);
		}else{
			sys_msg('添加失败');
		}
		
	}elseif($_REQUEST['act']=='showStore'){
		
		$id=$_GET['id'];
		$sql='select store_name,store_id from '.$GLOBALS['ecs']->table('store').' where region_id='.$id;
		$store_list['list']=$GLOBALS['db']->getAll($sql);
		die(json_encode($store_list));	
		//make_json_result('','',$store_list);	
	}elseif($_REQUEST['act']=='edit_seller'){
		//print_r("456");
		//print_r()
		//echo '<pre>';
		//var_dump($_POST);exit;
		$name=$_POST['seller_name'];
		$num=$_POST['seller_no'];
		$seller_mac = $_POST['seller_mac'];
		$get_reserve=$_POST['get_reserve'];
		$fuiou_account_id=$_POST['fuiou_account_id'];
		$admin_id=$_POST['admin_id'];
		
		//如果,存在 $seller_mac,添加到mac_list表里。
		if($seller_mac){
			//print_r("ok");
			
			$map='where admin_no='.$admin_id;
			$sql="update ".$GLOBALS['ecs']->table('mac_list')." set mac='$seller_mac' ".$map;
			$res=$GLOBALS['db']->query($sql);
		}
		
		
		$data=" set  admin_id='$admin_id' , seller_name='$name' , seller_no='$num' , seller_mac='$seller_mac' , get_reserve='$get_reserve' , fuiou_account_id='$fuiou_account_id' ";
		$where=' where seller_id='.$_POST['seller_id'];
		if(!empty($_POST['region_id'])){
			
			if(!empty($_POST['region_manager'])){
				//区长
				$sql="update ".$GLOBALS['ecs']->table('seller').$data. ", store_id=0 , store_manager=0 , region_id=0 , region_manager={$_POST['region_manager']}".$where;
			}else{
				
				if(!empty($_POST['store_id'])){
					
						//店长或者小职员
						if($_POST['store_manager']){
							$sql="update ".$GLOBALS['ecs']->table('seller').$data. ", store_id=0 , store_manager={$_POST['store_manager']} , region_id={$_POST['region_id']} , region_manager=0".$where;
						}elseif($_POST['store_manager']==='0'){
							$sql="update ".$GLOBALS['ecs']->table('seller').$data. ", store_id={$_POST['store_id']} , store_manager={$_POST['store_manager']} , region_id={$_POST['region_id']} , region_manager=0".$where;	
						}			
				}else{
					sys_msg('缺少东西1');
				}
			}	
		}else{
			
				sys_msg('缺少东西2');
		}  
		//var_dump($sql);exit;
		$res=$GLOBALS['db']->query($sql);
		if($res){
			$links[0]['text'] = '返回上一页';
			$links[0]['href'] = 'seller_list.php?act=list';
			sys_msg('修改成功','0',$links);
		}else{
			sys_msg('修改失败');
		}
	
		
	}elseif($_REQUEST['act']=='del'){
		$sql='delete from '.$GLOBALS['ecs']->table('seller').' where seller_id='.$_GET['id'];
		$res=$GLOBALS['db']->query($sql);
		if($res){
			sys_msg('删除成功');
		}else{
			sys_msg('删除失败');
		}
		
		
	}








































?>