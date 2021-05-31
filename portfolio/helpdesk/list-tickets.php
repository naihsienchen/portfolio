<?php
session_start();

//show header.php
include 'views/header.php';
include 'views/nav.php';

//GETTING INFO FROM DOM
$doc = new DOMDocument();

//ensure nice formatting
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$path = "xml/tickets.xml";
//if (file_exists($path)) { }
$doc->load($path);

//select "ticket" elements
//$tickets is a DOMNodeList
$tickets = $doc->getElementsByTagName("ticket");

?>
        <div class="m-1">
            <p class="h1 text-center">Ticket Management System</p>
            <table class="table table-bordered tbl">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date Opened</th>
                        <th scope="col">Status</th>
                        <th scope="col">Client ID</th>
                        <th scope="col">View Ticket</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if ($_SESSION['role']=="staff") {
                    foreach ($tickets as $ticket) { 
                        $ticketid = $ticket->getElementsByTagName("ticketid")->item(0)->nodeValue;
                        $issuedatetime = $ticket->getElementsByTagName("issuedatetime")->item(0)->nodeValue;
                        $status = $ticket->getElementsByTagName("status")->item(0)->nodeValue;
                        $userid = $ticket->getElementsByTagName("userid")->item(0)->nodeValue;
                ?>
                    <tr>
                        <th><?= $ticketid; ?></th>
                        <td><?= $issuedatetime; ?></td>
                        <td><?= $status; ?></td>
                        <td><?= $userid; ?></td>
                        <td>
                            <form action="./view-tickets.php" method="post">
                                <input type="hidden" name="id" value="<?= $ticketid; ?>"/>
                                <input type="submit" class="button btn btn-primary" name="viewTicket" value="view ticket"/>
                            </form>
                        </td>
                    </tr>
                <?php 
                    } 
                } elseif ($_SESSION['role']=="client") {
                    foreach ($tickets as $ticket) { 
                        $ticketid = $ticket->getElementsByTagName("ticketid")->item(0)->nodeValue;
                        $issuedatetime = $ticket->getElementsByTagName("issuedatetime")->item(0)->nodeValue;
                        $status = $ticket->getElementsByTagName("status")->item(0)->nodeValue;
                        $userid = $ticket->getElementsByTagName("userid")->item(0)->nodeValue;
                        if ($_SESSION['userid']==$ticket->getElementsByTagName("userid")->item(0)->nodeValue) {
                ?>
                    <tr>
                        <th><?= $ticketid; ?></th>
                        <td><?= $issuedatetime; ?></td>
                        <td><?= $status; ?></td>
                        <td><?= $userid; ?></td>
                        <td>
                            <form action="./view-tickets.php" method="post">
                                <input type="hidden" name="id" value="<?= $ticketid; ?>"/>
                                <input type="submit" class="button btn btn-primary" name="viewTicket" value="view ticket"/>
                            </form>
                        </td>
                    </tr>                    
                <?php   }
                    }
                } 
                ?>
                </tbody>
            </table>
        </div>

<?php
    include 'views/footer.php';
?>