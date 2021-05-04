<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.anapioficeandfire.com/api/books?name=A%20Game%20of%20Thrones',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: __cfduid=d5b3aa1e39f452696e8375845dcb205c11620148052; ARRAffinity=8c1c76a162cd70c14989494045692376887ae812afff5c54cba19b00b92562ed; ARRAffinitySameSite=8c1c76a162cd70c14989494045692376887ae812afff5c54cba19b00b92562ed'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;