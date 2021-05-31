# HTTP 5202 PHP Project: onRoute

## By: The < WebDevs >

---

<!-- ## Our Database Design -->

<!-- ![Database Design]()https://github.com/2021-Winter-HTTP-5202-A/OnRoute/blob/main/images/database_design/database_design.png -->

## Features

#### Nai-Hsien: accommodations.php, hotelDetails.php, hotelBooking.php, models/Hotel.php

##### Feature description (Project phase 1c)
- [X] 1. Accommodation Booking: Search</br>
   Search database for accommodations based off of **_location, check in/out dates, and number of guests_**.
- [X] 2. Accommodation Booking: Book after Search</br>
   Based on search results, users can select an accommodation and book it.
- [X] 3. Accommodation Booking: Confirmation/Details</br>
   After a booking is complete, the page will display accommodation details ~~**_and  confirmation will be sent to the user’s email_**~~
##### Improvement in progress:
  - [ ] Book a hotel with a user id (logged in)
  - [ ] Better CSS
  - [ ] Connecting to other features
  - [ ] composer, namespace, and class
##### Deployment URL
https://nhcto.ca/onRoute/accommodations.php
##### Test credentials
There are only limiting data in the database now. To test the functionality, please select a city from the following list, with only 2 or 4 guests.
###### List of cities in the database:
Beijing, Buenos Aires, Cairo, Calcutta, Chongqing, Delhi, Dhaka, Guangzhou, Istanbul, Karachi, Kinshasa, Lagos, Lahore, Los Angeles, Manila, Mexico City

---

#### Will Midgette: flightNumberSearch.php, flightInfo.php, mealSelection.php, seatSelection.php

- Flightnumbersearch.php and FlightInfo.php - allows a user to enter their flight number to check the details of their flight
- Validation on flightNumberSearch.php tells user if they have not entered a flight number, or if the database could not find a flight from the flight number they entered
- If the database can find a flight with the entered flight number, it stores it as a session variable and redirects the user to the flightInfo.php page where the flight details are displayed
- mealSelection.php - this can be accessed through the flights.php page when a user is logged in. After navigating to this page, the user will have the option to select a meal for their flight. If the user navigated to the page without a user_id set, or without having submitting a flightbookingId via post request, they are redirected back to the flights.php page
- Validation for the form checks that the user entered a selection. If they did not, the page gives them an error message. If the selection submission is successful, the user is directed to a confirmation page and the meal is updated on the corresponding flightbooking
- seatSelection.php - this can also be accessed through the flights.php page when a user is logged in. After navigating to this page, the user will have the option to select a meal for their flightIf the user navigated to the page without a user_id set, or without having submitting a flightbookingId via post request, they are redirected back to the flights.php page
- If the user had previously selected a seat, the seat is indicated in a user message, and the seat is highlighted in blue on the seating plan. Seats for the flight that have are unavailable are booked in red and cannot be selected. Seats that are available are light blue and can be selected. 
- Validation checks for a seat selection. If the user did not submit a seat upon form submission, they are informed of the error and asked to submit again. If the submission is successful, the user recieves a confirmation message, and their flight booking is updated with the newly selected seat. They are then prompted to return to the flights.php page.
---

#### Alexis Arevalo: vehicles.php, vehicleSelection.php, vehicleInfo.php, models/Vehicle.php

- All vehicles in the database are displayed, and the user can select a vehicle by clicking on it.
- The user will not be able to select or submit any vehicles without logging in first.
- When the user selects a vehicle, they are redirected to (vehicleSelection.php) a vehicle information page which is retrieved by the stored vehicle 'id'.
- All inputs made to the vehicle search form are validated against empty fields. - Working on Sanitizing input fields against malicious code injections.
- Users are able to search the database for vehicles based off of pick-up locations, pick-up dates, and return dates - What they will see once submitting the search, are all the vehicles that match pick up location.
- Pick up date and return date will be use to calcualte the total price from the the vehicle price/day.
- Vehicle that are already rented will not be available for selection.
- All searches selected are sent and retrieved in (vehicleSelection.php). If user selects a vehicle that is not searched then they will have to submit a pick up date and return date within (VehicleSelection.php)
- If a vehicle is already rented which matches the users date selections, then an error will appear stating that they must select a diffrent date.
- Upon approval, the vehicle selected is saved along with all it's information.
- Users can check their all their rentals and vehicle information by clicking the rental list button on the top right corner of (vehicles.php) which takes them to the (vehicleInfo.php) page. 

---

#### Daniel Guinto: index.php, flights.php, flightBooking.php, deleteFlightBooking.php myaccount.php

- Main search feature that allows users to search the flights table based off of airports, dates, airlines, etc.
- Validation checks if user left field empty, or if search input does not have any results
- Successful results will display a table with all the values matching the search result
- Flights that have passed will display a "Book Unavailable" notice
- Flights that are in the future will display a "Book" button. If the user clicks the button, the data from the flight they selected will be saved and they will be carried over to the flightBooking.php page. Their selected flight will appear on this page, and they will be prompted review their flight details before confirming. Once they click the button, a flightBooking row will be added to the flightBooking table in the dB. Meals and seat selections will be able to be added later.
- Only logged in users can go through the booking process. If they are not logged in, they will be redirected to the login page
- When user is logged in, they can view their account information as well as any trip details associated with their account on their MyAccount page. The can also cancel any bookings they have, as long as the date for the booking has not passed (deletes row from DB)

---

#### Mohamed Sakr: login.php, flightOptions.php and models/User.php

- Login and registration features
- Set up phpmailer
- 'Forgot your password?', password and email changing which rely on the phpmailer
- User model to handle all user related data
- Customer service page now works with phpmailer
