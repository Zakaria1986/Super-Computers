<html>
<head>
<title>Form-to-mail Submission</title>
</head>
<body>

<?php

///////////////////////////////////////////
// CHECK THE FORM
// Developed by Mike Child
// Amended by Allan Blair February 2011
// Single quotes added around variables
// (PHP5 changes) Amended 21-2-2011 - Lots of errors with missing single quotes and variables...
// Tweaked on Saturday 29 September 2012
// Index warning problems fixed on 2-10-2012
// eMail problem worked on 6-11-2012 (Allan)
///////////////////////////////////////////


// check required fields have been completed, in each case appending an appropriate error
// message to the user if they have not, and setting the variable $badform to 1 if there
// are any bad fields.
$badform = 0;
$error = "";

// get rid of leading and trailing white-space on all the entered fields
// Note use of $_POST 
$firstname = trim( $_POST["firstname"]);
$familyname = trim( $_POST['familyname']);
$studentnumber = trim( $_POST['studentnumber']);
$telephone = trim( $_POST['telephone']);

$email = trim( $_POST['email']);
$course = trim( $_POST['course']);
$ftpt = trim( $_POST['ftpt']);
$year = trim( $_POST['year']);
//----------------------------------------------------------------
// Allan 2-10-2012
// Check if checkbox ticked or not 
// Produces a warning if not checked
// Originally I used:
// $checkbox = trim($_POST['checkbox']);
// but this produced an index warning if box not ticked.
// issed used to check if box ticked and value assigned if it is.
//-----------------------------------------------------------------
// See: http://notesofgenius.com/how-fix-php-notice-undefined-index/
//-----------------------------------------------------------------
if(isset($_POST['checkbox'])){ $checkbox = $_POST['checkbox']; }
//-----------------------------------------------------------------
$coursedirector = trim( $_POST['coursedirector']);
$query = trim( $_POST['query']);

if ( strlen( $firstname ) == 0) {
  $error .= "<p>You did not enter your first name.</p>\n";
  $badform = 1;
}

if ( strlen(  $familyname ) == 0) {
  $error .= "<p>You did not enter your family name.</p>\n";
  $badform = 1;
}  

// student number must be exactly 7 digits long
if ( strlen( $studentnumber ) != 7) {
  $error .= "<p>You did not enter your full 7 digit student number.</p>\n";
  $badform = 1;
}

// here we assume that a telephone number must be at least 8 digits long. This is a very crude verification,
// as "I'm not telling you" would be accepted. 
if ( strlen( $telephone ) < 8) {
  $error .= "<p>You did not enter a full telephone number.</p>\n";
  $badform = 1;
}

// here we assume that the shortest possible valid email address would be five characters; a@b.c for example
if ( strlen( $email ) < 5) {
  $error .= "<p>You did not a full e-mail address.</p>\n";
  $badform = 1;
}



// Note that there is no check for the checkbox having been ticked.
// the checkbox has the name 'checkbox' and the valued 'ticked' 
// if it was ticked there will be a variable called $checkbox with the value 'ticked'
// if it was not ticked the variable $checkbox WILL NOT EXIST
// Can you amend this so it works? 8-)


/////////////////////////////////
// ACCEPT OR REJECT THE FORM
/////////////////////////////////

// at this point all the fields have been checked appropriately, and $badform tells us whether to continue
// processing the form or ask the user to correct their input.

if ( $badform == 1) {
  echo "
  <center>
    <font size=\"+1\"><b>
    <font color=\"#ff0000\"> $error </font>
    <p>Please use the <a href='../contact/contact.html><i>Back</i></a> button on your browser and correct the problem<br>Thank you!</p> </b>
  </font>
  ";
} else {

 // get the values of the fields into a string variable called $formcontent
  $formcontent = "";
  $formcontent .= "First name: $firstname\n";
  $formcontent .= "Family name: $familyname\n";
  $formcontent .= "Student Number: $studentnumber\n\n";

  
  $formcontent .= "Telephone Number: $telephone\n";
  $formcontent .= "Email: $email\n\n";

  $formcontent .= "Course: $course  Year: $year  Mode: ".strToUpper( $ftpt)."\n";
  

  $formcontent .= "Query:\n$query\n\n";

  // test whether the variable $checkbox exists to see if the box was ticked or not.
  if ( isset( $checkbox)) {
    $formcontent .= "The checkbox was ticked.\n";
  } else {
    $formcontent .= "The checkbox was NOT ticked.\n";
  }

  // now mail the string $formcontent to whoever wants to get it
  // $toaddress is loaded from a file
  // Change line below you can put in your LSBU eMail address if that is where you want the eMail will go to.
  $toaddress = "zakaria_yahhia@hotmail.com";    // PLEASE don't leave noOne@NoWhere in this - it won't work...
  $subjectline = "Form completed by $firstname $familyname";
  // Changed 6-11-2012 (Allan)
  $headers = "from:bus.support@lsbu.ac.uk\n"; // This will work on Daydream
  // Commented out- remove // below to send eMail
  mail( $toaddress, $subjectline, $formcontent, $headers);

  echo "
  <b>Thank you, $firstname.<br>The following email has been sent to $toaddress:</b>
  <pre>$formcontent</pre>
  "; // end echo statement
  
  echo "<b> <a href='../contact/contact.html' target='_self'>Contact Us</a>";

} // end

?>
</p> 
</body>
</html>
