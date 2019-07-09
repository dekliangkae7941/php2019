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
    $uri = "https://script.google.com/macros/s/AKfycbzw_YL6MhrETxrBEgIu9cMqTZ8DrlUXVwCYhvHZeaXtUE50L_cB/exec";
    $response = Unirest\Request::get("$uri");
    $json = json_decode($response->raw_body, true);
    $results = array_filter($json['user'], function($user) use ($command) {
    return $user['id'] == $command;
    }
  );

$i=0;
$bb = array();
foreach($results as $resultsz){
$bb[$i] = $resultsz;
$i++;
}

$site01 .= $bb['0']['name'];
$site02 .= $bb['1']['name'];
$site03 .= $bb['2']['name'];
$site04 .= $bb['3']['name'];
$site05 .= $bb['4']['name'];
$site06 .= $bb['5']['name'];

if(empty($site01)) {
  $site01 .= 'ไม่มีเพิ่มเติม';
}
if(empty($site02)) {
  $site02 .= 'ไม่มีเพิ่มเติม';
}
if(empty($site03)) {
  $site03 .= 'ไม่มีเพิ่มเติม';
}
if(empty($site04)) {
  $site04 .= 'ไม่มีเพิ่มเติม';
}
if(empty($site05)) {
  $site05 .= 'ไม่มีเพิ่มเติม';
}
if(empty($site06)) {
  $site06 .= 'ไม่มีเพิ่มเติม';
}

$textz .= "กรุณาระบุ Name ที่ต้องการค้นหา";

if(empty($results)) {
   #   $mreply = array(
   #     'replyToken' => $replyToken,
   #     'messages' => array( 
   #       array(
   #             'type' => 'text',
    #            'text' => 'ไม่พบข้อมูล'
#)
    #    )
    #  );
    }
else {

    $mreply = array(
        'replyToken' => $replyToken,
        'messages' => array( 
          array(
                'type' => 'text',
                'text' => $textz,
                'quickReply' => array(
                'items' => array(
                                   array(
                'type' => 'action',
                'action' => array(
                'type' => 'message',
                'label' => $site01,
                'text' => $site01
                                 )
              ),array(
                'type' => 'action',
                'action' => array(
                'type' => 'message',
                'label' => $site02,
                'text' => $site02
                                 )
              ),array(
                'type' => 'action',
                'action' => array(
                'type' => 'message',
                'label' => $site03,
                'text' => $site03
                                 )
              ),array(
                'type' => 'action',
                'action' => array(
                'type' => 'message',
                'label' => $site04,
                'text' => $site04
                                 )
              )
              ,array(
                'type' => 'action',
                'action' => array(
                'type' => 'message',
                'label' => $site05,
                'text' => $site05
                                 )
              )
              ,array(
                'type' => 'action',
                'action' => array(
                'type' => 'message',
                'label' => $site06,
                'text' => $site06
                                 )
              )
                                )
                                     )
     )
     )
     );

$enbb = json_encode($bb);
    file_put_contents('./user/' . $userId . 'data.json', $enbb);
    file_put_contents('./user/' . $userId . 'mode.json', 'keyword');
    }
}

elseif ($modex == 'keyword') {
    $urikey = file_get_contents('./user/' . $userId . 'data.json');
    $deckey = json_decode($urikey, true);

    $results = array_filter($deckey, function($user) use ($command) {
    return $user['name'] == $command;
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
$text .= 'ID : ' . $zaza[0]['id'];
$text .= "\n";
$text .= 'NAME : ' . $zaza[0]['name'];
$text .= "\n";
$text .= 'NUM : ' . $zaza[0]['num'];
$text .= "\n";
$text .= 'OTHER : ' . $zaza[0]['other'];
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
                    $url = "https://bots.dialogflow.com/line/246b595f-bd54-4a8f-9776-1ea50cc9b947/webhook";
                    $headers = getallheaders();
                    file_put_contents('headers.txt',json_encode($headers, JSON_PRETTY_PRINT));          
                    file_put_contents('body.txt',file_get_contents('php://input'));
                    $headers['Host'] = "bots.dialogflow.com";
                    $json_headers = array();
                    foreach($headers as $k=>$v){
                        $json_headers[]=$k.":".$v;
                    }
                    $inputJSON = file_get_contents('php://input');
                    $ch = curl_init();
                    curl_setopt( $ch, CURLOPT_URL, $url);
                    curl_setopt( $ch, CURLOPT_POST, 1);
                    curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true);
                    curl_setopt( $ch, CURLOPT_POSTFIELDS, $inputJSON);
                    curl_setopt( $ch, CURLOPT_HTTPHEADER, $json_headers);
                    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2);
                    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1); 
                    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec( $ch );
                    curl_close( $ch );
        }






if (isset($mreply)) {
    $result = json_encode($mreply);
    $client->replyMessage($mreply);
}  

?>
