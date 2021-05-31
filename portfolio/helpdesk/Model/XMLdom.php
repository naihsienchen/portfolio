<?php

$doc = new DOMDocument();

//ensure nice formatting
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$path = "../xml/tickets.xml";
//if (file_exists($path)) { }
$doc->load($path);

//select "person" elements
//$ppl is a DOMNodeList
$tickets = $doc->getElementsByTagName("ticket");

for ($i = 0; $i < $tickets->length; $i++) {
  //$ticket = $tickets->item($i);
  echo $tickets->item($i)->nodeValue . "\n";
} 

foreach($tickets as $ticket) {
    print '<p>' . $ticket->getElementsByTagName("ticketid")->item(0)->nodeValue . '</p>';
    print '<p>' . $ticket->getElementsByTagName("userid")->item(0)->nodeValue . '</p>';
    print '<p>' . $ticket->getElementsByTagName("issuedatetime")->item(0)->nodeValue . '</p>';
    print '<p>' . $ticket->getElementsByTagName("subject")->item(0)->nodeValue . '</p>';
    print '<p>' . $ticket->getElementsByTagName("messages")->item(0)->nodeValue . '</p>';
}

function getAllTickets(){


}