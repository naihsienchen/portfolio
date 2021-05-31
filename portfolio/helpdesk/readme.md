## Requirement
- To do this you will need to have (minimum):
  - [ ] a login page/form:  Users need to log in before viewing his or her tickets.
  - [ ] a ticket listing page:  Admin/support staff should see all tickets while users can only see tickets he or she owns.  You should be able to click to open a ticket details page.
  - [ ] a ticket details page:  There should be a form to allow a user to submit a message for the ticket (you only need a message box and a submit button). 
 
- You should implement the above pages and display the appropriate page(s) for clients and support staff. 
- There is a small mark component for design. The design does not need to be fancy, but it should be presentable.
- When a support staff member submits a status change or a message, the XML file should be modified accordingly and the ticket is refreshed.  

## Weekly

### Week 8:
- [ ] Have the pages roughed out (don't worry about how it all stitches together yet).
- [ ] For the ticket details page, you can hard-code it to read one of the tickets for now based on ID just to make sure the code works properly. 
- [ ] For the ticket listing page, just display all tickets to make sure your reading code works properly.
### Week 9:
- [ ] Work out the login page.
- [ ] Test that you can select the appropriate user upon submitting the form.
- [ ] Once it works properly, then make it redirect to the ticket listing page.
- [ ] Start to refine the ticket listing page.
- [ ] How would you create links to the ticket details page (you only need one details page)? (Hint: Think GET or POST variables.)
- [ ] How would you modify the display so that an admin user would see all tickets while clients only see their own submitted tickets?
- [ ] Refine the ticket details page.
- [ ] Make the details page only show the ticket for the passed-in ID value (e.g. from a GET/POST variable).
- [ ] Work on the message form to submit a message then insert that message into the tickets XML file.

### Week 10:
- [ ] Complete any incomplete functionality.
- [ ] Complete the design/layout.
- [ ] Submit.

### pseudo code
//login: how do I log in and assign different roles?
//ticket details: how do I display info according to different userid? (get/post from log in form)

- save the userId for that user as a session variable
- And then you can use an xpath or loop through the XML file to look for tickets with that userId
- ::xpath("XPath string")
  - Search for the children matching the given XPath.
  - $xml = simplexml_load_file("people.xml");
  - $res = $xml->xpath('/people/person');
  - print_r($res); //see what's returned

### ongoing questions 
#### view-tickets.php
- [ ] line 8: passing id from list-tickets.php doesn't work after adding new message and refresh the page
- [ ] line 68: child are not appended to the element/node which is gotten from loop
