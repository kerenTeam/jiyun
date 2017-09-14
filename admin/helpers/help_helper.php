<?php

function subtree($arr,$a = '',$id=0,$lev=1) {
    $subs = array(); // 子孙数组
    foreach($arr as $k=>$v) {
        if(!empty($a)){
            if(in_array($v['cate_id'],$a)){
                 $v['true'] = '1';
            }else{
                $v['true'] = '0';
            }   
        }         
        if($v['pid'] == $id) {
            $v['lev'] = $lev;
            $subs[] = $v; // 举例说找到array('id'=>1,'name'=>'安徽','parent'=>0),
            $subs = array_merge($subs,subtree($arr,$a,$v['cate_id'],$lev+1));
        }
    }
    return $subs;
}

//获取腾讯云签名
function Qcloud_Hmac($time,$region){

    $secretKey = 'OchFiz32qUwBEkJhvxoT9kFYfmkcOyVr';
    $srcStr = 'GETcvm.api.qcloud.com/v2/index.php?Action=DescribeInstances&Nonce=11886&Region='.$region.'&SecretId=AKIDc6PZYWfM0Tr480mDY6VljeQ9j9NO70cZ&Timestamp='.$time.'&InstanceIds.0=ins-09dx96dg';
    $signStr = base64_encode(hash_hmac('sha1', $srcStr, $secretKey, true));
    return $signStr;
}


?>