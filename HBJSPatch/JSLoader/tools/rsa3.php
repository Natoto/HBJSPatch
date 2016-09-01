<?php
$private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDpoODVtnSztGyb//p+g/Ob36jb3jzWzS2qovOjpY/rrTjwlVcQ
pB2m1nZDQNpTFsG8ZBl7uPw3M81lr7NRRn6tY7Om8tbOOsRgY6u0xwbgdRStFFvw
PzZ1HehiQ6WB8za8cucCyvuqmBRp7HOjO4Aa9t0rIvZ/hoWMeSvjnAVbMwIDAQAB
AoGBAOEHsaiIDs6NKdP08r1rsXjhLI9i92zawnLKdCybKw4RknfBENSZj2oExnKv
A9vmXoNsU1NlcaJmRh/85ZaSdS4L+Zx8iz18uwXAjCPpfMd7nG4FD55713Lszhua
DQIxK06w2mI0ytwEf4cqQmct2/BWchBXZIlz9O0Q70CF2brpAkEA/3NtHrQNxbF0
KRvrrTw4c9Y76PyeESEmKuF8ZKQu6v1qSb/V3aZsiGPTH+vUf0oAmoJoGx1AtRuk
DAe9uQ5efQJBAOohcXTh7vgm5ujlyJEi85jGp2BnHxmNAHN6n1q44Hs1wbvICujH
SEaHhVt6hSf7/NXnGOtJXve0JIt5glvCX28CQCa1jASKDkg10r9j/ruak4diIGP2
29EGr+zxjFMH2iA71H5mdncHAA1O6zA8IVBEm4DOYA4zyZloHdzA04wWVFUCQQDY
9+cJVvq6smpYN+E3RrmRwb6IYuf6KKXbXi5gx2UYKQgA+e/KKis7WQlnbdIJ7MYw
f7mjCVpdmG4pZpA8cpM3AkAFRUXYKlxLusKBRDZSDCyCUzP/Y3ql/qWXOqcA5Brj
pj+cofEWd/jZqD3drFjDGvccFmTfEAVmXWxCnJAZU2cW
-----END RSA PRIVATE KEY-----';

$public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDpoODVtnSztGyb//p+g/Ob36jb
3jzWzS2qovOjpY/rrTjwlVcQpB2m1nZDQNpTFsG8ZBl7uPw3M81lr7NRRn6tY7Om
8tbOOsRgY6u0xwbgdRStFFvwPzZ1HehiQ6WB8za8cucCyvuqmBRp7HOjO4Aa9t0r
IvZ/hoWMeSvjnAVbMwIDAQAB
-----END PUBLIC KEY-----';

//echo $private_key;
$pi_key =  openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
$pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的
print_r($pi_key);echo "\n";
print_r($pu_key);echo "\n";


$data = "123";//原始数据
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


