<?php
#-------------------------[Include]-------------------------#
require_once('./include/line_class.php');
require_once('./unirest-php-master/src/Unirest.php');
#-------------------------[Token]-------------------------#
$channelAccessToken = 'oB+dxq4x/QW0LK5ChAdkW8lA/NB45OZBqL9esFEklV4HE+s0s/uYj87W/pFC8TVux4iE28au22uaTj7by26TAeG+yYwl4bgAvV4xam3djBZRhaC2iYxroQNVYYqyfv84hAsnHS8/Di9m6w7OP8LElQdB04t89/1O/w1cDnyilFU='; 
$channelSecret = '53166c3cef8967db426b9328f1066bac';
#-------------------------[Events]-------------------------#
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$userId     = $client->parseEvents()[0]['source']['userId'];
$groupId    = $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp  = $client->parseEvents()[0]['timestamp'];
$type       = $client->parseEvents()[0]['type'];
$message    = $client->parseEvents()[0]['message'];
$profile    = $client->profil($userId);
$repro = json_encode($profile);
$messageid  = $client->parseEvents()[0]['message']['id'];
$msg_type      = $client->parseEvents()[0]['message']['type'];
$msg_message   = $client->parseEvents()[0]['message']['text'];
$msg_title     = $client->parseEvents()[0]['message']['title'];
$msg_address   = $client->parseEvents()[0]['message']['address'];
$msg_latitude  = $client->parseEvents()[0]['message']['latitude'];
$msg_longitude = $client->parseEvents()[0]['message']['longitude'];


#----command option----#
$usertext = explode(" ", $message['text']);
$command = $usertext[0];
$options = $usertext[1];
if (count($usertext) > 2) {
    for ($i = 2; $i < count($usertext); $i++) {
        $options .= '+';
        $options .= $explode[$i];
    }
}

#------------------------------------------


$modex = file_get_contents('./user/' . $userId . 'mode.json');


if ($modex == 'Normal') {
    #$uri = "https://script.google.com/macros/s/AKfycbzw_YL6MhrETxrBEgIu9cMqTZ8DrlUXVwCYhvHZeaXtUE50L_cB/exec";
    $uri = "https://script.google.com/macros/s/AKfycbyldjsu6mMDl-V-0VH2wtXNbfBMS14I4SbAaF44aRfCL7S6TiQ/exec";
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $results = array_filter($json['user'], function($user) use ($command) {
    return $user['SITE'] == $command;
    }
  );

$i=0;
$bb = array();
foreach($results as $resultsz){
$bb[$i] = $resultsz;
$i++;
}


$textz .= "กรุณาระบุ SITE DONOR JOB ที่ต้องการค้นหา";
$textz .= "\n";
$textz .= $bb['0']['SITE'];
$textz .= "\n";
$textz .= $bb['1']['SITE'];
$textz .= "\n";
$textz .= $bb['2']['SITE'];
$textz .= "\n";
$textz .= $bb['3']['SITE'];
$textz .= "\n";
$textz .= $bb['4']['SITE'];
$textz .= "\n";
$textz .= $bb['5']['SITE'];
    $mreply = array(
        'replyToken' => $replyToken,
        'messages' => array( 
          array(
                'type' => 'text',
                'text' => $textz
     )
     )
     );

$enbb = json_encode($bb);
    file_put_contents('./user/' . $userId . 'data.json', $enbb);
    file_put_contents('./user/' . $userId . 'mode.json', 'keyword');
}

elseif ($modex == 'keyword') {
    $urikey = file_get_contents('./user/' . $userId . 'data.json');
    $deckey = json_decode($urikey, true);

    $results = array_filter($deckey, function($user) use ($command) {
    return $user['SITE DONOR JOB'] == $command;
    }
  );


$i=0;
$zaza = array();
foreach($results as $resultsz){
$zaza[$i] = $resultsz;
$i++;
}

$enzz = json_encode($zaza);
    file_put_contents('./user/' . $userId . 'data.json', $enzz);

$text .= "result";
$text .= "\n";
$text .= $zaza[0]['SITE'];
$text .= "\n";
    $mreply = array(
        'replyToken' => $replyToken,
        'messages' => array( 
          array(
                'type' => 'text',
                'text' => $text
     )
     )
     );

    file_put_contents('./user/' . $userId . 'mode.json', 'Normal');
}
else {
  file_put_contents('./user/' . $userId . 'mode.json', 'Normal');
}





if (isset($mreply)) {
    $result = json_encode($mreply);
    $client->replyMessage($mreply);
}  

?>
