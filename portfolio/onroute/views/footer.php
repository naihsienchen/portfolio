<!--Footer-->
<?php
$footerMenu = [
    'Home' => 'index.php',
    'Flights' => 'flights.php',
    'Accommodations' => 'accommodations.php',
    'Vehicle Rental' => 'vehicles.php',
    'Customer Service' => 'services.php',
];
?>

        <footer>          
            <?php echo displayNavigation($footerMenu); ?>
            <p> &#169; 2021. All Rights Reserved - This is a fake webpage created for HTTP 5202. </p>
        </footer>
    </div>
    </body> 
</html>
