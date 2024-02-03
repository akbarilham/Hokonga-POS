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
  popup_msg("Anda Tidak Masuk $mesg. \\n\\nCek dan Masuk-Kembali.");
  exit;
}

function error($errcode) {
   switch ($errcode) {

      case ("ACCESS_DENIED") :   
         popup_msg("Level Pemakai dibawah Angka. \\n\\nHanya Pemakai yang Memiliki Level Sesuai yang Akan Dapat Pendekatan.");
         break;

      case ("ALREADY_EXISTS") :   
         popup_msg("Anda Telah Memilih Produk Ini. \\n\\nBuatlah Perubahan dengan Meng-Klik Informasi dari Kereta Belanja.");
         break;

      case ("EMAIL_EXISTS") :
         popup_msg("Email yang Anda Masuk Sudah Digunakan. \\n\\nHarap cek dan Masuk Kembali.");
         break;
                           
      case ("FILE_DELETE_FAILURE") :
         popup_msg("You can not delete this file. \\n\\nPlease contact the webmaster.");
         break;
                           
      case ("ID_EXISTS") :
         popup_msg("ID yang Anda Pilih Sudah Digunakan. \\n\\nHarap cek dan Masuk Kembali.");
         break;

      case ("ID_NOT_EXISTS") :
         popup_msg("입력하신 아이디는 해당 데이터베이스에 존재하지 않습니다. \\n\\n확인하시고 다시 입력하여 주십시오.");
         break;

      case ("ID_NOT_PERMITTED") :
         popup_msg("The ID you chode is not permitted. \\n\\nPlease select another and re-enter.");
         break;

     case ("JOIN_NOT_AGREE") :
         popup_msg("You can register as a member after you agree to the terms of use.");
         break;

      case ("INVALID_BIRTHDAY") :
         popup_msg("Anda Telah Memilih Tanggal Lahir yang Tidak Valid.\\n\\nHarap Pilih Tanggal Lahir yang Tepat.");
         break;

      case ("INVALID_COMMENT") :
         popup_msg("Anda Tidak Menuliskan Komentar Apapun. \\n\\nHarap Masukkan Komentar Kembali.");   
         break;

      case ("INVALID_EMAIL") :
         popup_msg("Alamat Email yang Anda Masukkan Tidak Valid. \\n\\nHarap Masukkan Kembali Alamat Email Anda.");
         break;        

      case ("INVALID_ENTRY") :
         popup_msg("Your sigin is not valid. \\n\\nPlease sign in the membership again.");
         break;   

      case ("INVALID_FILE") :
         popup_msg("The file you want to upload is invalid. \\n\\nPlease contact the webmaster.");
         break;        
         
      case ("INVALID_HOMEPAGE") :
         popup_msg("Alamat Homepage yang Anda Masukkan Tidak Valid. \\n\\nHarap Masukkan Kembali Alamat Homepage yang Tepat.");
         break;                 

      case ("INVALID_ID") :
         popup_msg("ID Setidaknya Harus Merupakan Kombinasi dari Angka dan Huruf dengan Panjang 4~12 Karakter.\\n\\nHarap Cek dan Masukkan Kembali.");   
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
         popup_msg("Anda Meninggalkan Informasi atau Memasukkan Informasi yang Tidak Valid.\\n\\nHarap Cek dan Masukkan Kembali.");   
         break;

      case ("INVALID_NAME") :
         popup_msg("Nama yang Anda Masukkan Tidak Diperkenankan.\\n\\nHarap Masukkan Nama yang Tepat.");
         break;

      case ("INVALID_ORDER_NUM") :
         popup_msg("Kuantitas Pesanan Anda Harus Dalam Jumlah yang Tetap. \\n\\nHarap Cek dan Masukkan Kembali.");
         break;
         
      case ("INVALID_PASSWD") :
         popup_msg("Kata Kunci Setidaknya Harus 4 Karakter, Dapat Tediri Dari Huruf Kecil (a-z) Atau Angka. \\n\\nHarap Masukkan Kembali Kata Kunci Anda.");
         break;

      case ("INVALID_SUBJECT") :
         popup_msg("Subjek yang Anda Masukkan Tidak Diperkenankan. \\n\\nHarap Pilih Subjek yang Tepat.");
         break;

      case ("LOGIN_INVALID_PW") :
         popup_msg("Anda Memasukkan ID yang Tepat Namun dengan Kata Kunci yang Tidak Valid.\\n\\nHarap Cek dan Masukkan Kembali.");
         break;

      case ("LOGIN_INVALID_PW_PP") :
         popup_msg("Anda Memasukkan Nomor Passport yang Tepat Namun dengan Kata Registration yang Tidak Valid.\\n\\nHarap Cek dan Masukkan Kembali.");
         break;

      case ("LOGIN_NOT_FOUND") :
         popup_msg("Anda Bukan Anggota atau Login Anda Tidak Valid.\\n\\nHarap Cek dan Masukkan Kembali.");   
         break;

      case ("LOGIN_NOT_FOUND_PP") :
         popup_msg("Login Anda Tidak Valid.\\n\\nHarap Cek dan Masukkan Kembali.");   
         break;

      case ("LOGIN_INVALID_PW_ORD") :
         popup_msg("Login Anda Tidak Valid.\\n\\nHarap Cek dan Masukkan Kembali."); 
         break;

      case ("LOGIN_NOT_FOUND_ORD") :
         popup_msg("Login Anda Tidak Valid.\\n\\nHarap Cek dan Masukkan Kembali.");   
         break;

      case ("NO_ACCESS_DELETE") :   
         popup_msg("Anda tidak Dapat Menghapus Karena Kata Kunci yang Anda Masukkan tidak Tepat. \\n\\nHarap Masukkan Kembali Kata Kunci Anda.");
         break;

      case ("NO_ACCESS_DELETE_ID") :   
         popup_msg("Hanya Anggota yang Melakukan Penulisan Ini yang Dapat Melakukan Penghapusan.");
         break;

      case ("NO_ACCESS_DELETE_THREAD") :   
         popup_msg("Anda Tidak Dapat Menghapus Penulisan yang Telah Mempunyai Jawaban. \\n\\nHapus Penulisan Ini Setelah Anda Menghapus Semua Jawaban Terlebih Dahulu.");
         break;

      case ("NO_ACCESS_MODIFY") :
         popup_msg("Anda tidak Dapat Melakukan Modifikasi Karena Kata Kunci yang Anda Masukkan tidak Tepat. \\n\\nHarap Masukkan Kembali Kata Kunci Anda.");
         break;
      
      case ("NO_ACCESS_MODIFY_ID") :   
         popup_msg("Hanya Anggota yang Melakukan Penulisan Ini yang Dapat Melakukan Modifikasi.");
         break;

      case ("NO_ACCESS_UPLOAD") :   
         popup_msg("You can not upload because it is not permitted. \\n\\nPlease contact the webmaster.");
         break;

      case ("NOT_CHOOSE_FILE") :   
         popup_msg("Anda tidak Memilih File. \\n\\nHarap Cek dan Pilih Kembali.");
         break;

      case ("NOT_PRODUCT") :   
         popup_msg("Anda tidak Memilih Produk Apapun. \\n\\nHarap Cek dan Pilih Kembali.");
         break;

      case ("SAME_FILE_EXIST") :   
         popup_msg("The same file exists already. \\n\\nPlease check and select again.");
         break;

      case ("SAME_HOME_EXIST") :   
         popup_msg("The same website url exists already in English Directory. \\n\\nPlease contact webmaster.");
         break;  

      case ("UPLOAD_COPY_FAILURE") :   
         popup_msg("Gagal Dalam Melakukan upload File. \\n\\nHarap Cek dan Pilih Kembali.");
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
