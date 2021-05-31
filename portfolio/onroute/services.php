<?php
require_once 'library/functions.php';
require_once 'models/Mailer.php';
//Add unqiue css files here
$css = array('styles/services.css');
require_once 'views/header.php';

if (isset($_POST['contact'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $subject = 'Thank you for contacting customer support';
    $body = 'Your enquiry was: '. $_POST['message'];
    send_email($email, $name, $subject, $body);
}

?>


<main>
    <h2>Customer Service</h2>
    <div class="columns">
        <div class="covid">
            <h3>Covid-19 Policies</h3>
            <ul>
                <li> Fully vaccinated travelers are less likely to get and spread COVID-19. </li>
                <li> People who are fully vaccinated with an FDA-authorized vaccine can travel safely within the United States: </li>
                <ul>
                    <li>Fully vaccinated travelers do not need to get tested before or after travel unless their destination requires it</li>
                    <li>Fully vaccinated travelers do not need to self-quarantine</li>
                </ul>
                <li>Fully vaccinated travelers should still follow CDC’s recommendations for traveling safely including:</li>
                <ul>
                    <li>Wear a mask over your nose and mouth</li>
                    <li>Stay 6 feet from others and avoid crowds</li>
                    <li>Wash your hands often or use hand sanitizer</li>
                </ul>
            </ul>
            <p class="source"><a target="_blank" href="https://www.cdc.gov/coronavirus/2019-ncov/travelers/travel-during-covid19.html">Source</a></p>
        </div>
        <div class="faq">
            <h3>FAQ</h3>
            <h4>Can people who have recently recovered from COVID-19 travel?</h4>
            <p> If you had COVID-19 in the past 3 months, follow all requirements and recommendations for fully vaccinated travelers except:</p>
            <ul>
                <li>You can show documentation of recovery from COVID-19 instead of a negative test result before boarding an international flight.</li>
                <li>You do NOT need to tested 3-5 days after traveling unless you have symptoms of COVID-19.</li>
            </ul>
            <p>We know that people can continue to test positive for up to 3 months after they had COVID-19 and not be infectious to others.</p>
            <p class="source"><a target="_blank" href="https://www.cdc.gov/coronavirus/2019-ncov/travelers/faqs.html">Source</a></p>
        </div>
    </div>
    <div class="contact columns">
        <h3>Contact Us</h3>
        <div class="info">
            <h4>Email</h4>
            <p><a class="infoLink" href="mailto:support@OnRoute.ca" target="blank">support@OnRoute.ca</a></p>
            <h4>Phone</h4>
            <p><a class="infoLink" href="tel:416-123-4567" target="blank">416-123-4567</a></p>
        </div>
        <div class="form">
              <h4>Send us a message.</h4>
              <form class="contactform" action="services.php" method="post" enctype="multipart/form-data">
                  <div class="contactform__nameemail">
                      <label id="name-label" for="name-input"></label>
                      <input type="text" id="name-input" name="name" placeholder="Name">
                      <label id="email-label" for="email-input"></label>
                      <input type="text" id="email-input" name="email" placeholder="Email">
                  </div>
                  <div class="contactform__messagebox">
                      <label id="message-label" for="message-input"></label>
                      <textarea id="message-input" name="message" placeholder="Message"></textarea>
                  </div>
                  <div class="contactform__submit">
                      <button id="submit-button" type="submit" name="contact">Send</button>
                  </div>
              </form>
          </div>
    </div>
</main>

<?php
require_once 'views/footer.php';
?>