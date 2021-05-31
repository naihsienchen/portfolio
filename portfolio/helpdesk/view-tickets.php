<?php
session_start();
include 'views/header.php';
include 'views/nav.php';

//value from list-ticket.php button
$ticketid = $_POST['id'];  
//set time zone
date_default_timezone_set("America/Toronto");

$doc = new DOMDocument();

//ensure nice formatting
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$path = "xml/tickets.xml";
//if (file_exists($path)) { }
$doc->load($path);

//posting new message
//get the current ticket element

if(isset($_POST['msgbox__button'])){
    //get msg from post
    $msgtext = $_POST['msgbox'];
    //$newTicketId = $_POST['ticketid'];
    $ticketid = $_POST['id'];
    

    $xpath = new DOMXPath($doc);
    $query = './/ticket[ticketid="t00002"]/messages';
    $query_test = './/ticket[ticketid="'. $ticketid . '"]/messages';//path selecting the ticket with the current ticketid
    $nodes = $xpath->query($query)->item(0);
    $nodes_test = $xpath->query($query_test)->item(0);
    

    //create things that we want to append
    
    $newMsg = $doc->createElement("message");
    $newUser = $doc->createElement("userid", $_SESSION['userid']);                
    $newTime = $doc->createElement("msgDateTime", date("Y-m-d h:i:sa"));
    $newMsgtext = $doc->createElement("msgtext", $msgtext);

    //append them
    $newMsg->appendChild($newUser);
    $newMsg->appendChild($newTime);
    $newMsg->appendChild($newMsgtext);
    $nodes->appendChild($newMsg);
    $nodes_test->appendChild($newMsg);
    //$doc->documentElement->appendChild($nodes);

    //save xml doc
    $doc->save("xml/tickets.xml");
    //echo "<meta http-equiv='refresh' content='0'>";
    //header('Location: view-tickets.php?id='. $_POST['$ticketid']);
    //header('Location: view-tickets.php');
    }        

//looping through pool to generate ticket
//select "ticket" elements
//$tickets is a DOMNodeList
$tickets = $doc->getElementsByTagName("ticket");

?>
    <div class="m-1">
        <p class="h1 text-center">Ticket Details</p>
        <span class="back"><a href="list-tickets.php">< Back to tickets</a></span>
        <div>
            <?php foreach ($tickets as $ticket) { 
                if ($ticketid == $ticket->getElementsByTagName("ticketid")->item(0)->nodeValue){
                    $issuedatetime = $ticket->getElementsByTagName("issuedatetime")->item(0)->nodeValue;
                    $status = $ticket->getElementsByTagName("status")->item(0)->nodeValue;
                    $userid = $ticket->getElementsByTagName("userid")->item(0)->nodeValue;
                    $msgDateTime= $ticket->getElementsByTagName("msgDateTime")->item(0)->nodeValue;
                    $msgs = $ticket->getElementsByTagName("messages")->item(0)->nodeValue;
            ?>
            <table class="table table-bordered tbl">
                <tr>
                    <th scope="col">ticket id</th>
                    <td><?= $ticketid; ?></td>
                </tr>
                <tr>
                    <th scope="col">Date Opened</th>    
                    <td><?= $issuedatetime; ?></td>
                </tr>
                <tr>
                    <th scope="col">Status</th>
                    <td><?= $status; ?></td>
                </tr>
                <tr>
                    <th scope="col">Client id</th>
                    <td><?= $userid; ?></td>
                </tr>
                <tr>
                    <th scope="col">Message Date</th>
                    <td><?= $msgDateTime; ?></td>
                </tr>
                <tr>
                    <th scope="col">Messages</th>
                    <td><?= $msgs; ?></td>
                </tr>
            </table>  
            <?php 
                }
            } 
            ?>
        </div>
        
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">            
            <input type="hidden" name="id" value="<?= date("Y-m-d h:i:sa"); ?>"/>  
            <input type="hidden" name="id" value="userid <?= $_SESSION['userid']; ?>"/>  
            <input type="hidden" name="id" value="<?= $ticketid; ?>"/>  
            <label for="msgbox">add a new message:</label>
            </br>
            <textarea id="msgbox" name="msgbox" rows="4" cols="50"></textarea>
            </br>
            <input type="submit" name="msgbox__button" value="Submit">
        </form>
        </div>
<?php
    include 'views/footer.php';
?>
