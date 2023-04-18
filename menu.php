<?php
// DB credentials.
//include '../config.php';

include_once 'util.php';
class Menu
{
    protected $text;
    protected $sessionId;


    function __construct()
    {
    }



    public function mainMenuRegistered($phoneNumber)
    {
        //shows initial user menu for registered users
        include 'dbconnect.php';            
            $user = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber' ";
            $result2 = $conn->query($user);
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_assoc();
                    $language = $row2['language'];

                 if ($language == 1){
        $response = "Welcome to WireMe Reply with\n";
        $response .= "1. Send Money\n";
        $response .= "2. Check Balance\n";
        $response .= "3. Setting\n";
        return $response;
            }else if($language == 2){
                $response = "Barka da zuwa WireMe \n";
        $response .= "1. Tura Kudi\n";
        $response .= "2. Duba Asusu\n";
        $response .= "3. Saita";
        return $response;
            }else if($language == 3){
                $response = "Ekaabo WireMe \n";
        $response .= "1. Fi Owo Ranse\n";
        $response .= "2. Ṣayẹwo iwọntunwọnsi\n";
        $response .= "3. Eto";
        return $response;
            }else if($language == 4){
                $response = "Nnọọ WireMe \n";
        $response .= "1. Zipu ego\n";
        $response .= "2. Lelee nguzozi\n";
        $response .= "3. Ịtọ ntọala";
        return $response;
            }
            } else {
                 echo "CON hello".mainMenuUnRegistered($phoneNumber);
            }
           
    }




    public function mainMenuUnRegistered($phoneNumber)
    {
        //shows initial user menu for unregistered users
        $response = "CON Welcome to WireMe. Reply with\n";
        $response .= "1. Register\n";
        echo $response;
    }





    public function registerMenu($textArray, $phoneNumber)
    {
        //building menu for user registration 
        $level = count($textArray);
        if ($level == 1) {
             include 'dbconnect.php';
                $query = "SELECT * FROM WireME_users WHERE nin ='$phoneNumber' ";
                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                $count = mysqli_num_rows($result);
                if ($count == 1) {
                echo "END This number has already been registered";
                } else {
            echo "CON Please enter your NIN:";
                }
        } else if ($level == 2) {
            echo "CON Please enter set you PIN:";
        } else if ($level == 3) {
            echo "CON Please re-enter your PIN: \n";
        } else if ($level == 4) {
            $response .="CON Please select language: \n";
            $response .="1. English language \n";
            $response .="2. Hausa language \n";
             $response .="3. Yoruba language \n";
              $response .="4. Igbo language \n";
            echo $response;
        } else if ($level == 5) {
            $nin = $textArray[1];
            $pin = $textArray[2];
            $confirmPin = $textArray[3];
            $lang = $textArray[4];
            if ($pin != $confirmPin) {
                echo "END Your pins do not match. Please try again";
            } else {
                // save to database
                $hashPin = md5($pin);
                include 'dbconnect.php';
                $cash = 0;
                $getCash = $conn->query("SELECT * FROM WireME_transaction WHERE reciever='" .$phoneNumber."' ");
                while( $tr = mysqli_fetch_assoc($getCash)){
                  
                  $cash += $tr['amount'];
                
                }
                
                $insert = $conn->query("INSERT INTO WireME_users (nin,mobile,language,balance,pin) VALUES ('" . $nin . "','" . $phoneNumber . "','" . $lang . "','". $cash. "','" .$hashPin. "')");
                if ($insert === TRUE) {
                    //include 'sms.php';
                    
                   // $message = "Welcome to WireMe ...";
                    
                  //  sendSms( , $phoneNumber);
                    
                    echo "END You have been registered";
                } else {
                    echo "END Network problem, please try again later";
                }
            }
        }
    }
    
    
    
    
    
    
    

    public function sendMoneyMenu($textArray, $phoneNumber)
    {
        include 'dbconnect.php';            
            $user = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber' ";
            $result2 = $conn->query($user);
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    // $Name = $row2["AccName"];
                    $language = $row2['language'];
                }
        //building menu for user registration 
        $level = count($textArray);
        $receiverName = "";
        $receiverMobileWithCountryCode = "";
        $response = "";
        if ($level == 1 AND $language == 1) {
                include 'dbconnect.php';
                $query1 = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber'";
                $result1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
                $count1 = mysqli_num_rows($result1);
                if ($count1 == 0) {
                echo "END This number has not been registered";
                } else
            echo "CON Enter the recipient's mobile number:";
        } else if ($level == 1 AND $language == 2) {
            echo "CON Saka Lambar Wayar Mai Karba:";
        }else if ($level == 1 AND $language == 3) {
            echo "CON Tẹ nọmba olugba sii:";
        }else if ($level == 1 AND $language == 4) {
            echo "CON Tinye nọmba ekwentị mkpanaaka nke nnata:";
        }else if ($level == 2 AND $language == 1) {
            echo "CON Enter amount:";
        }else if ($level == 2 AND $language == 2) {
            echo "CON Nawa Zaha Tura:";
        }else if ($level == 2 AND $language == 3) {
            echo "CON Tẹ iye sii:";
        }else if ($level == 2 AND $language == 4) {
            echo "CON Tinye ego:";
        }else if ($level == 3 AND $language == 1) {
            $response .="CON Select Bank:\n";
            $response .="1. WireMe\n";
            $response .="2. First Bank\n";
            $response .="3. Access Bank\n";
            $response .="4. UBA Bank\n";
            $response .="5. Zenith Bank \n";
            echo $response;
        }else if ($level == 3 AND $language == 2) {
            $response .="CON Zabi banki:\n";
            $response .="1. WireMe\n";
            $response .="2. First Bank\n";
            $response .="3. Access Bank\n";
            $response .="4. UBA Bank\n";
            $response .="5. Zenith Bank \n";
            echo $response;
        }else if ($level == 3 AND $language == 3) {
            $response .="CON Yan Bank:\n";
            $response .="1. WireMe\n";
            $response .="2. First Bank\n";
            $response .="3. Access Bank\n";
            $response .="4. UBA Bank\n";
            $response .="5. Zenith Bank \n";
            echo $response;
        }else if ($level == 3 AND $language == 4) {
            $response .="CON Họrọ ụlọ akụ:\n";
            $response .="1. WireMe\n";
            $response .="2. First Bank\n";
            $response .="3. Access Bank\n";
            $response .="4. UBA Bank\n";
            $response .="5. Zenith Bank \n";
            echo $response;
        } else if ($level == 4 && $textArray[3] == 1 AND $language == 1 ) {
            echo "CON Enter your PIN:";
        } else if ($level == 4 && $textArray[3] == 1 AND $language == 2 ) {
            echo "CON Saka Mukulin Sirrin Ka:";
        } else if ($level == 4 && $textArray[3] == 1 AND $language == 3 ) {
            echo "CON Te pinni re :";
        } else if ($level == 4 && $textArray[3] == 1 AND $language == 4 ) {
            echo "CON Tinye ntụtụ gị :";
        } else if ($level == 4 && $textArray[3] != 1 AND $language == 1) {
            echo "END Inter Bank transfer is yet to be implimented:";
        } else if ($level == 4 && $textArray[3] != 1 AND $language == 2) {
            echo "END Muna Aiki Akan Wannan Tsarin:";
        } else if ($level == 4 && $textArray[3] != 1 AND $language == 3) {
            echo "END A n ṣiṣẹ lori rẹ:";
        } else if ($level == 4 && $textArray[3] != 1 AND $language == 4) {
            echo "END Anyị na-arụ ọrụ na ya:";
        } else if ($level == 5) {
            $receiverMobile = $textArray[1];
            $receiverMobileWithCountryCode = $this->addCountryCodeToPhoneNumber($receiverMobile);
            
            include 'dbconnect.php';            
            $user = "SELECT * FROM WireME_users WHERE mobile='$receiverMobileWithCountryCode' ";
            $result2 = $conn->query($user);
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    $balance = $row2["balance"];
                    
                }
           if  ($language == 1){
            $response .= "You are about to send " . $textArray[2] . " to " . $receiverMobileWithCountryCode. "\n";
            $response .= "1. Confirm\n";
            $response .= "2. Cancel\n";
            $response .= Util::$GO_BACK . " Back\n";
            $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
            echo "CON " . $response;
           } else if ($language == 2){
              $response .= "Zaha Tura " . $textArray[2] . " Zuwa " . $recieverName . "\n";
            $response .= "1. Tabbatar\n";
            $response .= "2. Soke\n";
            $response .= Util::$GO_BACK . " Back\n";
            $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
            echo "CON " . $response; 
           } else if ($language == 3){
              $response .= "O ti fẹ fi " . $textArray[2] . " ranṣẹ si " . $recieverName . "\n";
            $response .= "1. Jẹrisi\n";
            $response .= "2. fagilee\n";
            $response .= Util::$GO_BACK . " Back\n";
            $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
            echo "CON " . $response; 
           } else if ($language == 4){
              $response .= "Ị na-achọ iziga " . $textArray[2] . " Iji " . $recieverName . "\n";
            $response .= "1. Gosi\n";
            $response .= "2. Kagbuo\n";
            $response .= Util::$GO_BACK . " Back\n";
            $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
            echo "CON " . $response; 
           }
            }else{
                if  ($language == 1){
            $response .= "The Reciever's phone Number ".$receiverMobileWithCountryCode." is not Registered \n Do you want to continue \n";
            $response .= "1. Confirm\n";
            $response .= "2. Cancel\n";
            $response .= Util::$GO_BACK . " Back\n";
            $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
            echo "CON " . $response;
           } else if ($language == 2){
              $response .= "Wannan Lambar wayar ba tada yi rejista \n  Kana so ka ci gaba a haka \n";
            $response .= "1. Tabbatar\n";
            $response .= "2. Soke\n";
            $response .= Util::$GO_BACK . " Back\n";
            $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
            echo "CON " . $response; 
           } else if ($language == 3){
              $response .= "O ti fẹ fi " . $textArray[2] . " ranṣẹ si " . $recieverName . "\n";
            $response .= "1. Jẹrisi\n";
            $response .= "2. fagilee\n";
            $response .= Util::$GO_BACK . " Back\n";
            $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
            echo "CON " . $response; 
           } else if ($language == 4){
              $response .= "Ị na-achọ iziga " . $textArray[2] . " Iji " . $recieverName . "\n";
            $response .= "1. Gosi\n";
            $response .= "2. Kagbuo\n";
            $response .= Util::$GO_BACK . " Back\n";
            $response .= Util::$GO_TO_MAIN_MENU .  " Main menu\n";
            echo "CON " . $response; 
           }
            }
            
        } else if ($level == 6 && $textArray[5] == 1) {
            //a confirm
            //send the money plus
            //check if PIN correct
            //If you have enough funds including charges etc..
            $pin = md5($textArray[4]);
            $amount = $textArray[2];
            // echo "END proceed";
            //connect to DB
            include 'dbconnect.php';
            $sender = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber' AND pin='$pin' ";
            $result2 = $conn->query($sender);
            if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $MyBalance = $row2["balance"];

            }else{
                $amount = 0;
                echo "END incorrect pin ";
            }
                if($amount > $MyBalance AND $language == 1 ){
                    echo "END Insufficient Fund";
                }else if($amount > $MyBalance AND $language == 2 ){
                    echo "END Kudin Ka Basu Kai Ba";
                }else if($amount > $MyBalance AND $language == 3 ){
                    echo "END ko si owo to";
                }else if($amount > $MyBalance AND $language == 4 ){
                    echo "END ego ezughi oke";
                }else{
                    $receiverMobile = $textArray[1];
                    $receiverMobileWithCountryCode = $this->addCountryCodeToPhoneNumber($receiverMobile);
            
            include 'dbconnect.php';            
            $user = "SELECT * FROM WireME_users WHERE mobile='$receiverMobileWithCountryCode' ";
            $result2 = $conn->query($user);
            if ($result2->num_rows < 1) {   
                
                $newSenderBalance = $MyBalance - $amount;
                $update = $conn->query("UPDATE WireME_users SET balance='$newSenderBalance' WHERE mobile='$phoneNumber' ");
                $save = $conn->query("INSERT INTO WireME_transaction (sender,reciever,amount) VALUES ('" . $phoneNumber . "','" . $receiverMobileWithCountryCode . "','" . $amount . "')");
                
                if ($update === TRUE && $save === TRUE && $language == 1) {

$curl = curl_init();
$message = urlencode("
Dear valued customer,

We are pleased to inform you that you have received NGN ".$amount." through WireMe wallet. To redeem your funds, please dial *384*72336#.

Thank you for choosing WireMe as your online wallet. We hope you have a pleasant experience using our service.

Best regards,
WireMe Wallet
");
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://smsexperience.com/api/sms/sendsms?username=&password=&sender=WireMe&recipient='.$receiverMobileWithCountryCode.'&message='.$message,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: laravel_session=eyJpdiI6InYyaHF1TktDNWE2S2hcL1I4ODRcL3lHUT09IiwidmFsdWUiOiJXd0Y4WnFqRTA0OTJwdmIzODBNN21BK09wMWFDMzJ2eXo3Q1RZM0NVcEtqNUhTSExQXC9NVEFJeHZuaUdzYmJNRnBEcGozbk1XRkRudkN3Qk9HeEhMXC9BPT0iLCJtYWMiOiJjMmQzZjUxMTgxZWEzYTU3MmRmN2EwM2RhM2YwMmE2MzQwODhlMjRjMTYwNjgyMmFhM2RjMjgyZTA5MzcxYmVkIn0%3D'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
                
                    echo "END ".money_format("You have successfully Send NGN %i", $amount).", to ".$receiverMobileWithCountryCode;
                }else if ($update === TRUE && $save === TRUE && $language == 2) {
                    echo "END ".money_format("Ka Tura NGN %i", $amount).", Zuwa ".$receiverMobileWithCountryCode;
                }else if ($update === TRUE && $save === TRUE && $language == 3) {
                    echo "END ".money_format("O ti fi NGN %i", $amount).", ranṣẹ si ".$receiverMobileWithCountryCode;
                }else if ($update === TRUE && $save === TRUE && $language == 4) {
                    echo "END ".money_format("Ị ezipụla NGN %i", $amount).", ka ".$receiverMobileWithCountryCode;
                } else {
                    echo "END Network problem, please try again \n later Error 504";
                }
                
            }else{
            
                    $row2 = $result2->fetch_assoc();
                    $balance = $row2["balance"];
                    $newSenderBalance = $MyBalance - $amount;
                    $newRecieverBalance = $balance + $amount;
                    $Reciever = $_SESSIO['RecieverNumber'];
                    
                $update = $conn->query("UPDATE WireME_users SET balance='$newSenderBalance' WHERE mobile='$phoneNumber' ");
                $update2 = $conn->query("UPDATE WireME_users SET balance='$newRecieverBalance' WHERE mobile='$receiverMobileWithCountryCode' ");
                $save = $conn->query("INSERT INTO WireME_transaction (sender,reciever,amount) VALUES ('" . $phoneNumber . "','" . $receiverMobileWithCountryCode . "','" . $amount . "')");
                
                
                
                if ($update === TRUE AND $update2 === TRUE && $save === TRUE AND $language == 1) {
                    echo "END ".money_format("You have successfully Send NGN %i", $amount).", to ".$receiverMobileWithCountryCode;
                }else if ($update === TRUE AND $update2 === TRUE && $save === TRUE AND $language == 2) {
                    echo "END ".money_format("Ka Tura NGN %i", $amount).", Zuwa ".$receiverMobileWithCountryCode;
                }else if ($update === TRUE AND $update2 === TRUE && $save === TRUE AND $language == 3) {
                    echo "END ".money_format("O ti fi NGN %i", $amount).", ranṣẹ si ".$receiverMobileWithCountryCode;
                }else if ($update === TRUE AND $update2 === TRUE && $save === TRUE AND $language == 4) {
                    echo "END ".money_format("Ị ezipụla NGN %i", $amount).", ka ".$receiverMobileWithCountryCode;
                } else {
                    echo "END Network problem, please try again \n later Error 504";
                }
                
            }
            
                }}
            
        }else if ($level == 6 && $textArray[5] == 2) {
            //Cancel
            echo "END Canceled. Thank you for using our service";
        } else if ($level == 6 && $textArray[5] == Util::$GO_BACK) {
            echo "END You have requested to back to one step - re-enter PIN";
        } else if ($level == 6 && $textArray[5] == Util::$GO_TO_MAIN_MENU) {
            echo "END You have requested to back to main menu - to start all over again";
        } else if ($language == 1) {
            echo "END Invalid entry";
        }else if ($language == 2) {
            echo "END Baka Saka Dai Dai Ba";
        }else if ($language == 3) {
            echo "END Akọsilẹ ti ko tọ";
        }else if ($language == 4) {
            echo "END Ntinye na ezighi ezi";
        }else{
        echo "END Invalid language";
    }
        
    }
    
      












    
    
    





 public function checkBalanceMenu($textArray, $phoneNumber)
    {
        include 'dbconnect.php';            
            $user = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber' ";
            $result2 = $conn->query($user);
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    $Name = $row2["AccName"];
                    $language = $row2['language'];
                }
        $level = count($textArray);
        $response = "";
                include 'dbconnect.php';
                $query1 = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber'";
                $result1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
                $count1 = mysqli_num_rows($result1);
                if ($count1 == 0) {
                echo "END This number has not been registered";
                } else if( $level == 1 AND $language == 1){
                echo "CON Enter your pin:";
                }else if ($level == 1 AND $language == 2){
                echo "CON Saka Mukulin Sirin Ka:";
                }else if ($level == 1 AND $language == 3){
                echo "CON tẹ pinni rẹ sii:";
                }else if ($level == 1 AND $language == 4){
                echo "CON Tinye ntụtụ gị:";
                
                } else if ($level == 2 ) {
                    // else if ($level == 2 AND $language == 1
            $pin = md5($textArray[1]);
            
        include 'dbconnect.php';
            $bal = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber' AND pin='$pin'";
            $result = $conn->query($bal);
            if ($result->num_rows > 0) {
               $row = $result->fetch_assoc();
                  $balance = $row["balance"];
                $formatter = new NumberFormatter('en_GB',  NumberFormatter::CURRENCY);
                 if ($language == 1){
                    echo "END your balance is: ",$formatter->formatCurrency($balance, 'NGN'), PHP_EOL;
                }else if ($language == 2){
                    echo "END Kudin Asusun Ka Shine: ",$formatter->formatCurrency($balance, 'NGN'), PHP_EOL;
                }else  if ($language == 3){
                    echo "END Iwontunwonsi àkọọlẹ rẹ ni: ",$formatter->formatCurrency($balance, 'NGN'), PHP_EOL;
                }else  if ($language == 4){
                     echo "END Ọnụ ego akaụntụ gị bụ: ",$formatter->formatCurrency($balance, 'NGN'), PHP_EOL;
                }
                
    }else{
        
         if ($language == 1){
                    
                echo "END Incorrect Pin";
                
                }else if ($language == 2){
                    
                echo "END Mukulin Sirri Ba Dai Dai Ba";
                
                }else  if ($language == 3){
                    
                    echo "END pinni ti ko tọ";
                    
                }else  if ($language == 4){
                    
                      echo "END pin ezighi ezi";
                      
                }else{
                    
        echo"END Invalid language";
        
                }
        
    }
                
  
    
        
    }
            }
    }
    
    
    
public function setting($textArray, $phoneNumber)
    {
        $level = count($textArray);
        $response = "";
        include 'dbconnect.php';            
            $user = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber' ";
            $result2 = $conn->query($user);
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    // $Name = $row2["AccName"];
                    $language = $row2['language'];
                }
        if ($level == 1 AND $language == 1){
        $response .= "CON Select Option\n";
        $response .= "1. Change Pin\n";
        $response .= "2. Change language\n";
        echo "$response";
        }else if ($level == 1 AND $language == 2){
        $response .= "CON Zaɓi Zaɓi\n";
        $response .= "1. Canja Mukullin Sirri\n";
        $response .= "2. Canja Harshe\n";
        echo "$response";
        }else if ($level == 1 AND $language == 3){
        $response .= "CON Yan Aṣayan\n";
        $response .= "1. Parro Pinni re\n";
        $response .= "2. Yi ede pada\n";
        echo "$response";
        }else if ($level == 1 AND $language == 4){
        $response .= "CON Họrọ Nhọrọ\n";
        $response .= "1. Gbanwee pin\n";
        $response .= "2. Gbanwee Asụsụ\n";
        echo "$response";
        }else if ($level == 2 && $textArray[1] == 1 AND $language == 1 ) {
            echo "CON Enter current pin:";
        }else if ($level == 2 && $textArray[1] == 1 AND $language == 2 ) {
            echo "CON Shigar da mukullin sirri na yanzu:";
        }else if ($level == 2 && $textArray[1] == 1 AND $language == 3 ) {
            echo "CON Tẹ pinni ti isiyi sii:";
        }else if ($level == 2 && $textArray[1] == 1 AND $language == 4 ) {
            echo "CON Tinye ntụtụ ugbu a:";
        }else if ($level == 2 && $textArray[1] == 2 AND $language == 1 ) {
        $response .= "CON Select language\n";
        $response .= "1. English language\n";
        $response .= "2. Hausa language\n";
        $response .= "3. Yoruba language\n";
        $response .= "4. Igbo language\n";
        echo "$response";
        }else if ($level == 2 && $textArray[1] == 2 AND $language == 2 ) {
        $response .= "CON Zaɓi Harshe\n";
        $response .= "1. English language\n";
        $response .= "2. Hausa language\n";
        $response .= "3. Yoruba language\n";
        $response .= "4. Igbo language\n";
        echo "$response";
        }else if ($level == 2 && $textArray[1] == 2 AND $language == 3 ) {
        $response .= "CON Yan Ede\n";
        $response .= "1. English language\n";
        $response .= "2. Hausa language\n";
        $response .= "3. Yoruba language\n";
        $response .= "4. Igbo language\n";
        echo "$response";
        }else if ($level == 2 && $textArray[1] == 2 AND $language == 4 ) {
        $response .= "CON Họrọ Asụsụ\n";
        $response .= "1. English language\n";
        $response .= "2. Hausa language\n";
        $response .= "3. Yoruba language\n";
        $response .= "4. Igbo language\n";
        echo "$response";
        }else if ($level == 3 && $textArray[1] == 1 AND $language == 1 ) {
            echo "CON Enter your new pin:";
        }else if ($level == 3 && $textArray[1] == 1 AND $language == 2 ) {
            echo "CON Shigar da sabon mukullin sirri:";
        }else if ($level == 3 && $textArray[1] == 1 AND $language == 3 ) {
            echo "CON Tẹ pinni titun sii:";
        }else if ($level == 3 && $textArray[1] == 1 AND $language == 4 ) {
            echo "CON Tinye ntụtụ ọhụrụ:";
        }else if ($level == 3 && $textArray[1] == 2 AND $language == 1 ) {
            $langs = $textArray[2];
            $update = $conn->query("UPDATE WireME_users SET language='$langs' WHERE mobile='$phoneNumber'");
            if ($update === TRUE AND $language == 1) {
                    echo "END You have successfully changed your language";
                } else {
                 echo "END Network Problem, Try Again Later";   
                }
        }else if ($level == 3 && $textArray[1] == 2 AND $language == 2 ) {
            $langs = $textArray[2];
            $update = $conn->query("UPDATE WireME_users SET language='$langs' WHERE mobile='$phoneNumber'");
            if ($update === TRUE AND $language == 2) {
                    echo "END Kun yi nasarar canza yaren ku";
                } else {
                 echo "END Network Problem, Try Again Later";   
                }
        }else if ($level == 3 && $textArray[1] == 2 AND $language == 3 ) {
            $langs = $textArray[2];
            $update = $conn->query("UPDATE WireME_users SET language='$langs' WHERE mobile='$phoneNumber'");
            if ($update === TRUE AND $language == 3) {
                    echo "END O ti yi ede rẹ pada ni aṣeyọri";
                } else {
                 echo "END Network Problem, Try Again Later";   
                }
        }else if ($level == 3 && $textArray[1] == 2 AND $language == 4 ) {
            $langs = $textArray[2];
            $update = $conn->query("UPDATE WireME_users SET language='$langs' WHERE mobile='$phoneNumber'");
            if ($update === TRUE AND $language == 4) {
                    echo "END Ịgbanwela asụsụ gị nke ọma";
                } else {
                 echo "END Network Problem, Try Again Later";   
                }
        }else if ($level == 4 && $textArray[1] == 1 AND $language == 1 ) {
            echo "CON Confirm your new pin:";
        }else if ($level == 4 && $textArray[1] == 1 AND $language == 2 ) {
            echo "CON Sake shigar da sabon mukullin sirrin:";
        }else if ($level == 4 && $textArray[1] == 1 AND $language == 3 ) {
            echo "CON Tun tẹ pinni tuntun rẹ sii:";
        }else if ($level == 4 && $textArray[1] == 1 AND $language == 4 ) {
            echo "CON tinyekwa ntụtụ ọhụrụ gị:";
        }else if ($level == 5 && $textArray[1] == 1 AND $language == 1 ) {
            $oldpin = md5($textArray[2]);
            $pin = $textArray[3];
            $confirmPin = $textArray[4];
            if ($pin != $confirmPin AND $language == 1) {
                echo "END Your pins do not match. Please try again";  
    } else {
    include 'dbconnect.php';
    
    // check if old pin is correct

    $checkpin = $conn->query("SELECT * from WireME_users WHERE mobile='$phoneNumber' AND AccPin='$oldpin' ");
    if ($checkpin->num_rows > 0) {
    $hashPin = md5($pin);
    $update = $conn->query("UPDATE WireME_users SET AccPin='$hashPin' WHERE mobile='$phoneNumber'");
            if ($update === TRUE AND $language == 1) {
                    echo "END You have successfully changed your pin";
                }
    } else{
                echo "END Old pin is incorrect ";
            }
        }
    }else if ($level == 5 && $textArray[1] == 1 AND $language == 2 ) {
            $oldpin = md5($textArray[2]);
            $pin = $textArray[3];
            $confirmPin = $textArray[4];
            if ($pin != $confirmPin AND $language == 2) {
                echo "END Mukullan sirrin ku ba su dace ba. Da fatan za a sake gwadawa";  
    } else {
    include 'dbconnect.php';
    
    // check if old pin is correct

    $checkpin = $conn->query("SELECT * from WireME_users WHERE mobile='$phoneNumber' AND AccPin='$oldpin' ");
    if ($checkpin->num_rows > 0) {
    $hashPin = md5($pin);
    $update = $conn->query("UPDATE WireME_users SET AccPin='$hashPin' WHERE mobile='$phoneNumber'");
            if ($update === TRUE AND $language == 2) {
                    echo "END Kun yi nasarar canza mukullin sirrin ku";
                }
    } else{
                echo "END Tsohon mukullin sirrin ba daidai ba ne ";
            }
        }
    }else if ($level == 5 && $textArray[1] == 1 AND $language == 3 ) {
            $oldpin = md5($textArray[2]);
            $pin = $textArray[3];
            $confirmPin = $textArray[4];
            if ($pin != $confirmPin AND $language == 3) {
                echo "END Awọn pinni rẹ ko baramu. Jọwọ gbiyanju lẹẹkansi";  
    } else {
    include 'dbconnect.php';
    
    // check if old pin is correct

    $checkpin = $conn->query("SELECT * from WireME_users WHERE mobile='$phoneNumber' AND AccPin='$oldpin' ");
    if ($checkpin->num_rows > 0) {
    $hashPin = md5($pin);
    $update = $conn->query("UPDATE WireME_users SET AccPin='$hashPin' WHERE mobile='$phoneNumber'");
            if ($update === TRUE AND $language == 3) {
                    echo "END O ti yi pinni rẹ pada ni aṣeyọri";
                }
    } else{
                echo "END Pinni atijọ ko tọ ";
            }
        }
    }else if ($level == 5 && $textArray[1] == 1 AND $language == 4 ) {
            $oldpin = md5($textArray[2]);
            $pin = $textArray[3];
            $confirmPin = $textArray[4];
            if ($pin != $confirmPin AND $language == 4) {
                echo "END Ntụtụ gị adabaghị, Biko nwaa ọzọ";  
    } else {
    include 'dbconnect.php';
    
    // check if old pin is correct

    $checkpin = $conn->query("SELECT * from WireME_users WHERE mobile='$phoneNumber' AND AccPin='$oldpin' ");
    if ($checkpin->num_rows > 0) {
    $hashPin = md5($pin);
    $update = $conn->query("UPDATE WireME_users SET AccPin='$hashPin' WHERE mobile='$phoneNumber'");
            if ($update === TRUE AND $language == 4) {
                    echo "END Ịgbanwela pin gị nke ọma";
                }
    } else{
                echo "END Ntụtụ ochie ezighi ezi ";
            }
        }
    }
}
}
/*    
public function changepinMenu($textArray, $phoneNumber)
    {
        include 'dbconnect.php';            
            $user = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber' ";
            $result2 = $conn->query($user);
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) {
                    $Name = $row2["AccName"];
                    $language = $row2['language'];
                }
        $level = count($textArray);
        $response = "";
        if ($level == 1 AND $language == 1) {
            include 'dbconnect.php';
                $query1 = "SELECT * FROM WireME_users WHERE mobile='$phoneNumber'";
                $result1 = mysqli_query($conn, $query1) or die(mysqli_error($conn));
                $count1 = mysqli_num_rows($result1);
                if ($count1 == 0) {
                echo "END This number has not been registered";
                } else
            echo "CON Enter Your Old Pin";
    } else if ($level == 1 AND $language == 2){
        echo "CON Saka Tsohon Mukulin Sirri";
    } else if ($level == 1 AND $language == 3){
        echo "CON Tẹ rẹ atijọ pinni";
    } else if ($level == 1 AND $language == 4){
        echo "CON Tinye ntụtụ ochie gị";
    }else if ($level == 2 AND $language == 1){
        echo "CON Enter Your New Pin";
    }else if ($level == 2 AND $language == 2){
        echo "CON Saka Sabon Mukulin Sirri";
    }else if ($level == 2 AND $language == 3){
        echo "CON Tẹ pinni titun";
    }else if ($level == 2 AND $language == 4){
        echo "CON Tinye ntụtụ ọhụrụ";
    }else if ($level == 3 AND $language == 1){
        echo "CON Comfirm Your New Pin";
    }else if ($level == 3 AND $language == 2){
        echo "CON Tabatar Da Sabon Mukulin Sirri";
    }else if ($level == 3 AND $language == 3){
        echo "CON Tun-tẹ pinni titun";
    }else if ($level == 3 AND $language == 4){
        echo "CON Kwenye ntụtụ ọhụrụ";
    }else if ($level == 4){
      $oldpin = md5($textArray[1]);
      $pin = $textArray[2];
      $confirmPin = $textArray[3];
            if ($pin != $confirmPin AND $language == 1) {
                echo "END Your pins do not match. Please try again";  
    } else if ($pin != $confirmPin AND $language == 2) {
                echo "END Sababin Mukulin Sirri Ba Dai Dai Bane";  
    } else if ($pin != $confirmPin AND $language == 3) {
                echo "END Awọn pinni titun rẹ ko baramu";  
    }else if ($pin != $confirmPin AND $language == 4) {
                echo "END Ntụtụ gị adabaghị";  
    } else {
    include 'dbconnect.php';
    
    // check if old pin is correct

    $checkpin = $conn->query("SELECT * from WireME_users WHERE mobile='$phoneNumber' AND AccPin='$oldpin' ");
    if ($checkpin->num_rows > 0) {
    $hashPin = md5($pin);
    $update = $conn->query("UPDATE WireME_users SET AccPin='$hashPin' WHERE mobile='$phoneNumber'");
            if ($update === TRUE AND $language == 1) {
                    echo "END You have successfully changed your pin";
                } else if ($update === TRUE AND $language == 2) {
                    echo "END Ka Chanza Mukulin Sirrin Ka";
                }else if ($update === TRUE AND $language == 3) {
                    echo "END O ti yi pinni rẹ pada ni aṣeyọri";
                }else if ($update === TRUE AND $language == 4) {
                    echo "END Ịgbanwela pin gị nke ọma";
                }else {
                    echo "END Network Problem, Try Again Later";
                }
        
    } else if ($language == 1){
                    echo "END Old pin is incorrect ";
                } else if ($language == 2){
                    echo "END Tsohon Mukulin Sirri Ba Dai Dai Bane";
                }else if ($language == 3){
                    echo "END Pinni atijọ ko tọ";
                }else{
                    echo "END Ntụtụ ochie ezighi ezi";
                }
    }
    }
} else{
    echo "END Invalid language ";
}
}*/
    
    
    
    
    public function addCountryCodeToPhoneNumber($phone)
    {
        return Util::$COUNTRY_CODE . substr($phone, 1);
    }}
