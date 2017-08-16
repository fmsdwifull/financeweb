<?php

	define('IN_ECS', true);
	require(dirname(__FILE__) . '/includes/init.php');
	admin_priv('fuiou_list');
	
	if ($_REQUEST['act'] == 'fuiou_list'){
		
		$sql='select * from'.$GLOBALS['ecs']->table('fuiou_account_config');
		$list=$GLOBALS['db']->getAll($sql);
		$smarty->assign('action_link',  array("href"=>"fuiou_list.php?act=add","text"=>"添加新账号"));
		$smarty->assign('fuiou_list',$list);
		$ur_here ="富友账号列表";
		$smarty->assign('ur_here', $ur_here);
		$smarty->assign('full_page',    1);
		$smarty->display('fuiou_list.htm');
		
	}elseif($_REQUEST['act'] == 'edit' || $_REQUEST['act']=='add'){
		if($_REQUEST['act']=='edit'){

			$where='where account_id='.$_GET['id'];
			$sql='select * from'.$GLOBALS['ecs']->table('fuiou_account_config').$where;
			$list=$GLOBALS['db']->getRow($sql);
			$smarty->assign('fuiou_list',$list);
			$smarty->assign('act','edit');
		}else{
			$smarty->assign('act','add');
		}
		
		$smarty->display('fuiou_info.htm');
		
	}elseif($_REQUEST['act'] == 'edit_fuiou'){
		
		$id=$_POST['account_id'];
		$name=$_POST['account_name'];
		$mchnt_cd=$_POST['mchnt_cd'];
		$upload_file='../fuiou_key';
		if(!empty($_FILES['pbkey']['name'])){
			
			$ext=pathinfo($_FILES['pbkey']['name'])['extension'];
			if($ext=='pem' && ($_FILES["file"]["size"] < 20000) ){
				if ($_FILES['pbkey']["error"] > 0){
					sys_msg($_FILES["file"]["error"]);
				}
				else{
					if (file_exists("fuiou_key/" . $_FILES["file"]["name"])){
					  sys_msg($_FILES['pbkey']["name"] . " 已经存在. ");
					}else{
						$new_name='php_pbkey'.time().'.'.$ext;
					  if(move_uploaded_file($_FILES['pbkey']["tmp_name"],$upload_file."/" . $new_name)){
						$sql='update '.$GLOBALS['ecs']->table('fuiou_account_config').' set pbkey="'.$new_name.'" where account_id='.$id;
						$res=$GLOBALS['db']->query($sql);
						if(!$res){
							sys_msg('上传失败');
						}
					  }else{
						  sys_msg('上传失败');
					  }
					}
				}			
			}else{
				sys_msg('文件后缀需要是.pem,文件大小需要小于20M');
			}				
		}

		if(!empty($_FILES['prkey']['name'])){
			$ext=pathinfo($_FILES['prkey']['name'])['extension'];
			if($ext=='pem' && ($_FILES["file"]["size"] < 20000) ){
				if ($_FILES['prkey']["error"] > 0){
					sys_msg($_FILES['prkey']["error"]);
				}
				else{
					if (file_exists("fuiou_key/" . $_FILES["file"]["name"])){ 
					  sys_msg($_FILES['prkey']["name"] . " 已经存在. ");
					}else{
						$new_name1='php_pbkey'.time().'.'.$ext;
						 if(move_uploaded_file($_FILES['prkey']["tmp_name"],$upload_file."/" . $new_name1)){
							 $sql='update '.$GLOBALS['ecs']->table('fuiou_account_config').' set prkey="'.$new_name1.'" where account_id='.$id;
							 $res=$GLOBALS['db']->query($sql);
								if(!$res){
									sys_msg('上传失败');
								}
						  }else{
							 sys_msg('上传失败');
						  }
					}
				}			
			}else{
				sys_msg('文件后缀需要是.pem,文件大小需要小于20M');
			}		
						
		}

		$sql='update '.$GLOBALS['ecs']->table('fuiou_account_config').' set account_name="'.$name.'",mchnt_cd="'.$mchnt_cd.'" where account_id='.$id;
		$res=$GLOBALS['db']->query($sql);
		if($res){
			sys_msg('修改成功');
		}else{
			sys_msg('修改失败');
		}
		
			
	}elseif($_REQUEST['act']=='add_fuiou'){
		
		$name=$_POST['account_name'];
		$mchnt_cd=$_POST['mchnt_cd'];
		$upload_file='../fuiou_key';
		if(!empty($_FILES['pbkey']['name'])){
			
			$ext=pathinfo($_FILES['pbkey']['name'])['extension'];
			if($ext=='pem' && ($_FILES["file"]["size"] < 20000) ){
				if ($_FILES['pbkey']["error"] > 0){
					sys_msg($_FILES["file"]["error"]);
				}
				else{
					if (file_exists("fuiou_key/" . $_FILES["file"]["name"])){
					  sys_msg($_FILES['pbkey']["name"] . " 已经存在. ");
					}else{
						$new_name='php_pbkey'.time().'.'.$ext;
					  if(move_uploaded_file($_FILES['pbkey']["tmp_name"],$upload_file."/" . $new_name)){
						  $new_name=',"'.$new_name.'"';
						  $pbkey=',pbkey';
					  }else{
						  sys_msg('上传失败');
					  }
					}
				}			
			}else{
				sys_msg('文件后缀需要是.pem,文件大小需要小于20M');
			}				
		}else{
			$pbkey='';
			$new_name='';
		}

		if(!empty($_FILES['prkey']['name'])){
			$ext=pathinfo($_FILES['prkey']['name'])['extension'];
			if($ext=='pem' && ($_FILES["file"]["size"] < 20000) ){
				if ($_FILES['prkey']["error"] > 0){
					sys_msg($_FILES['prkey']["error"]);
				}
				else{
					if (file_exists("fuiou_key/" . $_FILES["file"]["name"])){ 
					  sys_msg($_FILES['prkey']["name"] . " 已经存在. ");
					}else{
						$new_name1='php_pbkey'.time().'.'.$ext;
						 if(move_uploaded_file($_FILES['prkey']["tmp_name"],$upload_file."/" . $new_name1)){
							 $new_name1=',"'.$new_name1.'"';
							 $prkey=',prkey';
						  }else{
							 sys_msg('上传失败');
						  }
					}
				}			
			}else{
				sys_msg('文件后缀需要是.pem,文件大小需要小于20M');
			}		
						
		}else{
			$prkey='';
			$new_name1='';
		}
		
		$where='account_name,mchnt_cd'.$pbkey.$prkey;
		$data='"'.$name.'","'.$mchnt_cd.'"'. $new_name . $new_name1;
		$sql='insert into '.$GLOBALS['ecs']->table('fuiou_account_config').' ('.$where.') values ('.$data.')';
		$res=$GLOBALS['db']->query($sql);

		if($res){
			sys_msg('添加成功');
		}else{
			sys_msg('添加失败');
		}
		
	}elseif($_REQUEST['act']=='del'){
		
		$sql='delete from '.$GLOBALS['ecs']->table('fuiou_account_config').' where account_id='.$_GET['id'];
		$res=$GLOBALS['db']->query($sql);
		if($res){
			sys_msg('删除成功');
		}else{
			sys_msg('删除失败');
		}
		
	}
		


?>