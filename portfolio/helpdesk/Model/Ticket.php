<?php 

class Ticket 
{
    public function getAllTickets(){
        $doc = new DOMDocument();
        //ensure nice formatting
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $path = "./xml/tickets.xml";
        //if (file_exists($path)) { }
        $doc->load($path);

        //select "person" elements
        //$ppl is a DOMNodeList
        $tickets = $doc->getElementsByTagName("ticket");
        
        return $tickets;
    }

    public function getTicketById(){
        $doc = new DOMDocument();
        //ensure nice formatting
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $path = "./xml/tickets.xml";
        //if (file_exists($path)) { }
        $doc->load($path);
        
        $ticketid = $doc->getElementsByTagName("ticketid");

        return $ticketid;
    }

    public function viewTicket(){
        //dynamically creating view-tickets-$ticketid.php
        $file = '';
        foreach ($tickets as $ticket){
            $ticketid = $ticket->getElementsByTagName("ticketid")->item(0)->nodeValue;
            $file = 'view-tickets-' . $ticketid . '.php';
            $file_pointer = fopen( $file, 'w' );

            $string = '
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <title></title>
                    <meta name="description" content="">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="">
                </head>
                <body>
                
                    <script src="" async defer></script>
                </body>
            </html>
            ';
            
            fwrite($file_pointer, $string);
            fclose($file_pointer);
            
            include($file);
        }
    }
}




?>
