<?
function print_title_image($code) {
   $img_title = $code . ".gif";
   echo("<img src=\"$img_title\" border=0><p>");
}

function print_title_room($room) {
   $img_room = $room . ".gif";
   echo("<img src=\"$img_room\" border=0><p>");
}

function print_htmltag_yesno($allow_html) {
   if($allow_html) {
      echo("(HTML Tag <font color=navy>Allowed</font>)");
   } else {
      echo("(<font color=navy>No</font> HTML Tag)");
   }
}   

function popup_msg($msg) {
   echo("<script language=\"javascript\"> 
   <!--
   alert('$msg');
   history.back();
   //-->   
   </script>");
}

function write($mesg) {
  popup_msg("You did not enter $mesg. \\n\\nCheck and re-enter.");
  exit;
}

function error($errcode) {
   switch ($errcode) {

      case ("ACCESS_DENIED") :   
         popup_msg("The user level is below grade. \\n\\nThe users who have relevant level can only approach.");
         break;

      case ("ALREADY_DIRECTORY") :   
         popup_msg("The directory you chose is already in use. \\n\\nPlease check and re-enter.");
         break;

      case ("ALREADY_EXISTS") :   
         popup_msg("You have already selected this product. \\n\\nMake a change by clicking detail information from shopping cart.");
         break;

      case ("EMAIL_EXISTS") :
         popup_msg("The Email address you entered is already in use. \\n\\nPlease check and re-enter.");
         break;

      case ("FILE_DELETE_FAILURE") :
         popup_msg("You can not delete this file. \\n\\nPlease contact the webmaster.");
         break;
                           
      case ("ID_EXISTS") :
         popup_msg("The ID you chose is already in use. \\n\\nPlease check and re-enter.");
         break;

      case ("ID_NOT_EXISTS") :
         popup_msg("The ID you chose is not in the Database. \\n\\nPlease check and re-enter.");
         break;

      case ("ID_NOT_PERMITTED") :
         popup_msg("The ID you chode is not permitted. \\n\\nPlease select another and re-enter.");
         break;

     case ("JOIN_NOT_AGREE") :
         popup_msg("You can register as a member after you agree to the terms of use.");
         break;

      case ("INVALID_BIRTHDAY") :
         popup_msg("You selected a invalid birthday.\\n\\nPlease select the right birthday.");
         break;

      case ("INVALID_COMMENT") :
         popup_msg("You did not write any comments. \\n\\nPlease re-enter the coments.");   
         break;
      
      case ("INVALID_EMAIL") :
         popup_msg("The email address you entered is invalid. \\n\\nPlease re-enter your email address.");
         break;        

      case ("INVALID_ENTRY") :
         popup_msg("Your sigin is not valid. \\n\\nPlease sign in the membership again.");
         break;   

      case ("INVALID_FILE") :
         popup_msg("The file you want to upload is invalid. \\n\\nPlease contact the webmaster.");
         break;        

      case ("INVALID_HOMEPAGE") :
         popup_msg("The homepage address you entered is invalid. \\n\\nPlease re-enter the right homepage address.");
         break;                 

      case ("INVALID_ID") :
         popup_msg("The ID must be a combination of numbers and letters with 4~12 characters long.\\n\\nPlease check and re-enter.");   
         break;

      case ("INVALID_NAME1") :
         popup_msg("Please enter your family name.");   
         break;

      case ("INVALID_NAME2") :
         popup_msg("Please enter your first name.");   
         break;

      case ("INVALID_NAME_ORD") :
         popup_msg("Please enter your name.");   
         break;

      case ("INVALID_JUMIN") :
         popup_msg("Please enter your ID card number.");   
         break;

      case ("INVALID_ZIP") :
         popup_msg("Please enter your postal or zip code.");   
         break;

      case ("INVALID_ADDR1") :
         popup_msg("Please enter your address.");   
         break;

      case ("INVALID_ADDR2") :
         popup_msg("Please enter your street address.");   
         break;

      case ("INVALID_COUNTRY") :
         popup_msg("Please select your country.");   
         break;
         


      case ("INVALID_INFO") :
         popup_msg("You left out information or entered invald information.\\n\\nPlease check and re-enter.");   
         break;

      case ("INVALID_NAME") :
         popup_msg("The name you entered is not allowed.\\n\\nPease enter the right name.");
         break;

      case ("INVALID_ORDER_NUM") :
         popup_msg("The quantity of your order must be a fixed number. \\n\\nPlease check and re-enter.");
         break;

      case ("INVALID_PASSWD") :
         popup_msg("The password must be at least 4 characters long, may contain lowercase letters (a-z) or numbers.");
         break;
         
      case ("INVALID_SUBJECT") :
         popup_msg("The subject you entered is not allowed. \\n\\nPlease enter the right subject.");
         break;
         
      case ("LOGIN_INVALID_PW") :
         popup_msg("You entered the correct ID but invalid password.\\n\\nPlease check and re-enter.");
         break;

      case ("LOGIN_INVALID_PW_PP") :
         popup_msg("You entered the correct Passport Number but invalid Registration Number.\\n\\nPlease check and re-enter.");
         break;

      case ("LOGIN_INVALID_PW_ORD") :
         popup_msg("You entered the correct Name but invalid Order Number.\\n\\nPlease check and re-enter.");
         break;

      case ("LOGIN_NOT_FOUND") :
         popup_msg("You are not a member or your login is invalid.\\n\\nPlease check and re-enter.");   
         break;

      case ("LOGIN_NOT_FOUND_PP") :
         popup_msg("Your login is invalid.\\n\\nPlease check and re-enter.");   
         break;
         
      case ("LOGIN_NOT_FOUND_ORD") :
         popup_msg("Your login is invalid.\\n\\nPlease check and re-enter.");   
         break;
         
      case ("NO_ACCESS_DELETE") :   
         popup_msg("You can not delete because it does not coincide with the password you entered. \\n\\nPlease re-enter your password.");
         break;

      case ("NO_ACCESS_DELETE_ID") :   
         popup_msg("The member who wrote this writing can only delete it.");
         break;

      case ("NO_ACCESS_DELETE_THREAD") :   
         popup_msg("You can not delete a writing that has an answer. \\n\\nDelete this writing after you delete all the answers first.");
         break;

      case ("NO_ACCESS_MODIFY") :
         popup_msg("You can not modify because it does not coincide with the password you entered. \\n\\nPlease re-enter your password.");
         break;

      case ("NO_ACCESS_MODIFY_ID") :   
         popup_msg("The member who wrote this writing can only modify it.");
         break;

      case ("NO_ACCESS_UPLOAD") :   
         popup_msg("You can not upload because it is not permitted. \\n\\nPlease contact the webmaster.");
         break;

      case ("NOT_CHOOSE_FILE") :   
         popup_msg("You did not choose a file. \\n\\nPlease check and choose again.");
         break;

      case ("NOT_PRODUCT") :   
         popup_msg("You did not select any products. \\n\\nPlease check and select again.");
         break;

      case ("SAME_FILE_EXIST") :   
         popup_msg("The same file exists already. \\n\\nPlease check and select again.");
         break;

      case ("SAME_HOME_EXIST") :   
         popup_msg("The same website url exists already in English Directory. \\n\\nPlease contact webmaster.");
         break;  

      case ("UPLOAD_COPY_FAILURE") :   
         popup_msg("Failure to upload a file. \\n\\nPlease check and select again.");
         break;

      case ("UPLOAD_DELETE_FAILURE") :   
         popup_msg("Failure to delete a file. \\n\\nPlease check and select again.");
         break;

      case ("DB_ERROR") :      
         $err_no = mysql_errno();
         $err_msg = mysql_error();         
         $error_msg = "ERROR CODE " . $err_no . " : $err_msg";                           
         echo("$error_msg");
         break;

      case ("QUERY_ERROR") :
         $err_no = mysql_errno();
         $err_msg = mysql_error();         
         $error_msg = "ERROR CODE " . $err_no . " : $err_msg";                           
         $error_msg = addslashes($error_msg);         
         popup_msg($error_msg);  
         break;

      default :
   }
}

?>
