<?php  
$private_key = '-----BEGIN RSA PRIVATE KEY-----  
    MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAMXhVi5RNJh/RKEG
    jDYSHvI9R2r+5X7bNKtHfxYGVhnoP/sYi5favF0ZEwU+oyYFGcUP9XuDDJoI7hnG
    wAGK1DyaFhsCBgzZCtC0dAPr+wBj9W7+m5cbfIoIhT4vXj1frmdunNPvrGc3xCaV
    0kw5YXQMzlMuw8Es3SEE4n/g8jRFAgMBAAECgYA4CI0c5IXeQPuwFWiSzyLQOaYF
    mFRoTa5magKEvBqZj3i+o76zq473Veha7dfJJlybvt8msH9bBvhVeEBar3NVjU8B
    loj8fkAadDUD3HDiUW5vfxEzfNFX2NvmBuALpQn4SwndeGsDRGUUOB3J31bkAVdi
    TRx9WC5JcrszWoMAwQJBAP/sMqbJ+p77dI9giNxEYmY26g0kEKIxiZ2Gdy8n2e/3
    JErreClbvk/m8grdF7UA2xxLy1V5XNxJtbICdF30HDkCQQDF8KXRTvSiVsBC/Xau
    pPMZdgCMs5tbyecWmnp8QJ3pFgNBrhiQQt6aOS3ZiB4gcFURIPPhlYLKoq5hBPxX
    c7BtAkBi9fTIJgYxf86cuplxg0gBem6a0j1UWo96SErCA0j0z75K8i6u33kB8K3b
    oY7PQRt5H53q2VkdHauSv/w7cG+RAkA/p8hrq4yYuHVUFdcZCwry4TQEC66msiOS
    7VL+qnkeAGpDsQ1NN3QG/OR11IR7wiRZQdOsdDx/lhmmMchFB3txAkA5HkArr1Xy
    x9pw9xU7ztLwD9VQqH0JUIeyiqxlRV6yGVT+2Vdp2w5fD8Tb3z84gfsTQv1qW/0w
    y1jJVJQCXSUe
-----END RSA PRIVATE KEY-----';  
  
$public_key = '-----BEGIN PUBLIC KEY-----  
    MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDF4VYuUTSYf0ShBow2Eh7yPUdq
    /uV+2zSrR38WBlYZ6D/7GIuX2rxdGRMFPqMmBRnFD/V7gwyaCO4ZxsABitQ8mhYb
    AgYM2QrQtHQD6/sAY/Vu/puXG3yKCIU+L149X65nbpzT76xnN8QmldJMOWF0DM5T
    LsPBLN0hBOJ/4PI0RQIDAQAB
-----END PUBLIC KEY-----';  
  
//echo $private_key;  
$pi_key =  openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id  
$pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的  
print_r($pi_key);echo "\n";  
print_r($pu_key);echo "\n";  
  
  
$data = "hello,huanjubao";//原始数据
$encrypted = "";   
$decrypted = "";   
  
echo "source data:",$data,"\n";  
  
echo "private key encrypt:\n";  
  
openssl_private_encrypt($data,$encrypted,$pi_key);//私钥加密  
$encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的  
echo $encrypted,"\n";  
  
echo "public key decrypt:\n";  
  
openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//私钥加密的内容通过公钥可用解密出来  
echo $decrypted,"\n";  
  
echo "---------------------------------------\n";  
echo "public key encrypt:\n";  
  
openssl_public_encrypt($data,$encrypted,$pu_key);//公钥加密  
$encrypted = base64_encode($encrypted);  
echo $encrypted,"\n";  
  
echo "private key decrypt:\n";  
openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密  
echo $decrypted,"\n";  
