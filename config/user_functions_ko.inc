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
      echo("<font size=-1>(태그사용 <font color=navy>가능</font>)</font>");
   } else {
      echo("<font size=-1>(태그사용 <font color=navy>불가</font>)</font>");
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
  popup_msg("$mesg (을)를 입력하지 않으셨습니다. \\n\\n확인하시고 다시 입력하세요.");
  exit;
}

function error($errcode) {
   switch ($errcode) {

      case ("ACCESS_DENIED") :   
         popup_msg("사용자 레벨이 등급 이하이군요. \\n\\n해당 레벨의 사용자만 접근 가능합니다.");
         break;
                           
      case ("ALREADY_DIRECTORY") :   
         popup_msg("이미 디렉토리가 존재합니다. \\n\\n다른 디렉토리를 입력하세요.");
         break;

      case ("ALREADY_EXISTS") :   
         popup_msg("이미 선택하신 상품이군요. \\n\\n아래 장바구니에서 상세 정보란을 클릭하셔서 수정하세요.");
		 break;

      case ("EMAIL_EXISTS") :
         popup_msg("입력하신 이메일은 이미 사용중입니다. \\n\\n확인하시고 다시 입력하여 주십시오.");
         break;
                           
      case ("FILE_DELETE_FAILURE") :   
         popup_msg("파일이 삭제되지 않았습니다. \\n\\n관리자에게 문의하여 주십시오.");
         break;         

      case ("ID_EXISTS") :
         popup_msg("입력하신 아이디는 이미 사용중입니다. \\n\\n확인하시고 다시 입력하여 주십시오.");
         break;

      case ("ID_NOT_EXISTS") :
         popup_msg("입력하신 아이디는 해당 데이터베이스에 존재하지 않습니다. \\n\\n확인하시고 다시 입력하여 주십시오.");
         break;
         
      case ("ID_NOT_PERMITTED") :
         popup_msg("입력하신 아이디는 허용하지 않는 아이디입니다. \\n\\n다른 아이디로 다시 입력하여 주십시오.");
         break;

      case ("JOIN_NOT_AGREE") :
         popup_msg("약관에 동의하셔야 회원가입이 가능합니다.");
         break;

      case ("INVALID_BIRTHDAY") :
         popup_msg("생년월일을 잘못 선택하셨습니다.\\n\\n올바로 선택하여 주십시오.");
         break;

      case ("INVALID_COMMENT") :
         popup_msg("본문을 입력하지 않으셨습니다. \\n\\n다시입력하여 주십시오.");   
         break;

      case ("INVALID_EMAIL") :
         popup_msg("입력하신 주소는 올바른 전자우편주소가 아닙니다. \\n\\n다시 입력하여 주십시오.");
         break;        

      case ("INVALID_ENTRY") :
         popup_msg("올바른 회원 가입 인증을 거치지 않았습니다. \\n\\n정확한 이메일로 다시 가입하여 주십시오.");
         break;        


      case ("INVALID_FILE") :
         popup_msg("등록할 파일을 선택하지 않으셨습니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("INVALID_HOMEPAGE") :
         popup_msg("입력하신 주소는 올바른 홈페이지주소가 아닙니다. \\n\\n다시 입력하여 주십시오.");
         break;                 

      case ("INVALID_ID") :
         popup_msg("아이디는 4~12자 사이의 숫자와 영문자의 조합이어야 합니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("INVALID_NAME1") :
         popup_msg("성을 입력하셔야 합니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("INVALID_NAME2") :
         popup_msg("영문 이름을 반드시 입력하셔야 합니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("INVALID_NAME_ORD") :
         popup_msg("이름을 입력하셔야 합니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("INVALID_JUMIN") :
         popup_msg("주민등록번호를 입력하셔야 합니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("INVALID_ZIP") :
         popup_msg("우편번호를 입력하셔야 합니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("INVALID_ADDR1") :
         popup_msg("주소를 입력하셔야 합니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("INVALID_ADDR2") :
         popup_msg("나머지 주소를 입력하셔야 합니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("INVALID_COUNTRY") :
         popup_msg("국가를 선택하셔야 합니다.\\n\\n확인하시고 다시 선택하여 주십시오.");   
         break;

      case ("INVALID_INFO") :
         popup_msg("정보를 빠뜨리셨거나 잘못 입력하셨습니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("INVALID_NAME") :
         popup_msg("입력하신 이름은 허용되지 않는 문자열입니다.\\n\\n올바른 이름을 입력하여 주십시오.");
		 break;

      case ("INVALID_ORDER_NUM") :
         popup_msg("주문 수량은 정수입니다. \\n\\n확인하시고 입력해 주세요.");
         break;

      case ("INVALID_PASSWD") :
         popup_msg("암호는 최소 4자이상의 영문자 또는 숫자여야 합니다. \\n\\n다시입력하여 주십시오.");
         break;
         
      case ("INVALID_SUBJECT") :
         popup_msg("입력하신 제목은 허용되지 않는 문자열입니다. \\n\\n올바른 제목을 입력하여 주십시오.");
         break;
      
      case ("LOGIN_INVALID_PW") :
         popup_msg("아이디는 제대로 입력하셨는데 비밀 번호가 틀렸습니다.\\n\\n확인하시고 다시 입력하여 주십시오.");
         break;

      case ("LOGIN_INVALID_PW_PP") :
         popup_msg("여권번호는 존재하지만 본사에서 할당한 신청번호가 틀렸습니다.\\n\\n확인하시고 다시 입력하여 주십시오.");
         break;

      case ("LOGIN_INVALID_PW_ORD") :
         popup_msg("입력하신 이름은 존재하지만 주문(예약)번호가 틀렸습니다.\\n\\n확인하시고 다시 입력하여 주십시오.");
         break;

      case ("LOGIN_NOT_FOUND") :
         popup_msg("회원이 아니거나 잘못 로그인하셨군요.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("LOGIN_NOT_FOUND_PP") :
         popup_msg("입력하신 여권번호와 일치하는 정보가 없습니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("LOGIN_NOT_FOUND_ORD") :
         popup_msg("입력하신 이름과 주문(예약)번호와 일치하는 정보가 없습니다.\\n\\n확인하시고 다시 입력하여 주십시오.");   
         break;

      case ("NO_ACCESS_DELETE") :   
         popup_msg("입력하신 암호와 일치하지 않으므로 삭제할 수 없습니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("NO_ACCESS_DELETE_ID") :   
         popup_msg("이 게시물은 글을 쓴 회원 본인만이 삭제할 수 있습니다.");
         break;

      case ("NO_ACCESS_DELETE_THREAD") :   
         popup_msg("답변이 있는 글은 삭제하실 수 없습니다. \\n\\n답변글을 모두 삭제하신 후 삭제하십시오.");
         break;

      case ("NO_ACCESS_MODIFY") :
         popup_msg("입력하신 암호와 일치하지 않으므로 수정할 수 없습니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("NO_ACCESS_MODIFY_ID") :   
         popup_msg("이 게시물은 글을 쓴 회원 본인만이 수정할 수 있습니다.");
         break;

      case ("NO_ACCESS_UPLOAD") :   
         popup_msg("해당파일은 자료실 운영지침에 따라 업로드가 허용되지 않는 파일입니다.");
         break;         

      case ("NOT_CHOOSE_FILE") :   
         popup_msg("파일을 선택하지 않으셨군요. \\n\\n확인하시고 다시 선택해 주세요.");
         break;

      case ("NOT_PRODUCT") :   
         popup_msg("상품을 선택하지 않으셨군요. \\n\\n확인하시고 다시 선택해 주세요.");
         break;

      case ("SAME_FILE_EXIST") :   
         popup_msg("동일한 이름의 파일이 이미 등록되어 있습니다. \\n\\n다른 이름으로 업로드하여 주십시오.");
         break;                           

      case ("SAME_HOME_EXIST") :   
         popup_msg("한국어 디렉토리에 동일한 홈페이지가 이미 등록되어 있습니다. \\n\\n관리자에게 문의하십시오.");
         break;                           


      case ("UPLOAD_COPY_FAILURE") :   
         popup_msg("파일을 올리는데 실패했습니다. \\n\\n확인하시고 다시 선택해 주세요.");
         break;

      case ("UPLOAD_DELETE_FAILURE") :   
         popup_msg("업로드 과정중 오류가 발생하였습니다. \\n\\n관리자에게 문의하여 주십시오.");
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
