<?php

if(!defined('IN_GAME')) {
	exit('Access Denied');
}

function init_icon_states(&$pa,$pd,$ismeet=0)
{
	global $sexinfo,$typeinfo,$fog;
	# 「天眼」技能判定
	if(!check_skill_unlock('c6_godeyes',$pd)) $ismeet = 1;
	//雾天显示？？？
	if($fog && !$ismeet)
	{
		$pa['typeinfo'] = '？？？';
		$pa['sNoinfo'] = '';
		$pa['iconImg'] = 'question.gif';
		$pa['iconImgB'] = '';
		return;
	}
	//更新编号情报
	$pa['sNoinfo'] = "(".$sexinfo[$pa['gd']].$pa['sNo']."号)";
	$pa['typeinfo'] = $typeinfo[$pa['type']];
	//更新头像情报
	$itype = $pa['type'] > 0 ? 'n' : $pa['gd'];
	$iname = $itype.'_'.$pa['icon']; 
	if(file_exists('img/'.$iname.'a.gif'))
	{
		$pa['iconImgB']= $iname.'a.gif';
	}
	else 
	{
		$pa['iconImg'] = $iname.'.gif';
		unset($pa['iconImgB']);
	}
}

function init_hp_states(&$pa,$pd,$ismeet=0)
{
	global $fog,$hpinfo,$spinfo,$rageinfo;
	# 「天眼」技能判定
	if(!check_skill_unlock('c6_godeyes',$pd))
	{
		$pa['hpstate'] = $pa['hp'].' / '.$pa['mhp'];
		$pa['spstate'] = $pa['sp'].' / '.$pa['msp'];
		$pa['ragestate'] = $pa['rage'];
		return;
	}
	if($fog && !$ismeet)
	{
		$pa['hpstate'] = '？？？';
		$pa['spstate'] = '？？？';
		$pa['ragestate'] = '？？？';
		return;
	}
	if($pa['hp'] <= 0)
	{
		$pa['hpstate'] = "<span class=\"red\">$hpinfo[3]</span>";
		$pa['spstate'] = "<span class=\"red\">$spinfo[3]</span>";
		$pa['ragestate'] = "<span class=\"red\">$rageinfo[3]</span>";
	}
	else
	{
		if($pa['hp'] < $pa['mhp']*0.2) 
		{
			$pa['hpstate'] = "<span class=\"red\">$hpinfo[2]</span>";
		} 
		elseif($pa['hp'] < $pa['mhp']*0.5) 
		{
			$pa['hpstate'] = "<span class=\"yellow\">$hpinfo[1]</span>";
		} 
		else 
		{
			$pa['hpstate'] = "<span class=\"clan\">$hpinfo[0]</span>";
		}

		if($pa['sp'] < $pa['msp']*0.2) 
		{
			$pa['spstate'] = $spinfo[2];
		} 
		elseif($pa['sp'] < $pa['msp']*0.5) 
		{
			$pa['spstate'] = $spinfo[1];
		} 
		else 
		{
			$pa['spstate'] = $spinfo[0];
		}

		if($pa['rage'] >= 100) 
		{
			$pa['ragestate'] = "<span class=\"red\">$rageinfo[2]</span>";
		} 
		elseif($pa['rage'] >= 30) 
		{
			$pa['ragestate'] = "<span class=\"yellow\">$rageinfo[1]</span>";
		} 
		else 
		{
			$pa['ragestate'] = $rageinfo[0];
		}
	}
}

function init_wep_states(&$pa,$pd,$ismeet=0)
{
	global $wepeinfo,$fog;
	# 「天眼」技能判定
	if(!check_skill_unlock('c6_godeyes',$pd))
	{
		$pa['wepestate'] = $pa['wepe'];
		$pa['wep_words'] = parse_info_desc($pa['wep'],'m');
		$pa['wepk_words'] =parse_info_desc($pa['wepk'],'k');
		return;
	}
	if($fog && !$ismeet)
	{
		$pa['wepestate'] = '？？？';
		$pa['wep_words'] = '？？？';
		$pa['wepk_words'] = '？？？';
		return;
	}
	if($pa['wepe'] >= 400)
	{
		$pa['wepestate'] = $wepeinfo[3];
	}
	elseif($pa['wepe'] >= 200)
	{
		$pa['wepestate'] = $wepeinfo[2];
	}
	elseif($pa['wepe'] >= 60)
	{
		$pa['wepestate'] = $wepeinfo[1];
	}
	else 
	{
		$pa['wepestate'] = $wepeinfo[0];
	}

	//更新武器名、武器类别情报
	$pa['wep_words'] = parse_info_desc($pa['wep'],'m');
	$pa['wepk_words'] = parse_info_desc($pa['wepk'],'k');
}

function init_inf_states(&$pa,$pd,$ismeet=0)
{
	global $infinfo,$poseinfo,$tacinfo,$fog;
	# 「天眼」技能判定
	if(!check_skill_unlock('c6_godeyes',$pd)) $ismeet = 1;
	if($fog && !$ismeet)
	{
		$pa['nameinfo'] = '？？？';
		$pa['lvlinfo'] = '？？？';
		$pa['poseinfo'] = '？？？';
		$pa['tacinfo'] = '？？？';
		$pa['infdata'] = '？？？';
		return;
	}
	$pa['nameinfo'] = $pa['name'];
	$pa['lvlinfo'] = 'Lv. '.$pa['lvl'];
	$pa['poseinfo'] = $poseinfo[$pa['pose']];
	$pa['tacinfo'] = $tacinfo[$pa['tactic']];
	//更新受伤状态
	if($pa['inf']) 
	{
		$pa['infdata'] = '';
		foreach ($infinfo as $inf_ky => $inf_nm) 
		{
			if(strpos($pa['inf'],$inf_ky) !== false) $pa['infdata'] .= $inf_nm;	
		}
	}
	else 
	{
		$pa['infdata'] = '无';
	}
}


?>
