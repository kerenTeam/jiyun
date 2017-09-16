<?php 
//获取腾讯云签名
function Qcloud_Hmac($time,$region){

    $secretKey = SECRETKEY;
    $srcStr = 'GETcvm.api.qcloud.com/v2/index.php?Action=DescribeRegions&Nonce=11886&Region='.$region.'&SecretId=AKIDISWSCkLLL9k8sTG89ziGbkk9QUL0Ps9D&Timestamp='.$time.'&Version=2017-03-12';
    $signStr = base64_encode(hash_hmac('sha1', $srcStr, $secretKey, true));
    return $signStr;

}









 ?>