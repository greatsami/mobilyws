<?php
namespace Greatsami\Mobilyws;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Mobilyws
{

    protected static $userAccount;
    protected static $passAccount;
    protected static $apiKey;
    protected static $sender;
    protected static $MsgID;
    protected static $timeSend;
    protected static $dateSend;
    protected static $deleteKey;
    protected static $resultType;
    protected static $viewResult;

    public static function run()
    {
        static::$userAccount        = config('mobilyws.mobile');
        static::$passAccount        = config('mobilyws.password');
        static::$apiKey             = config('mobilyws.apiKey');
        static::$sender             = config('mobilyws.sender');
        static::$MsgID              = config('mobilyws.MsgID');
        static::$timeSend           = config('mobilyws.timeSend');
        static::$dateSend           = config('mobilyws.dateSend');
        static::$deleteKey          = config('mobilyws.deleteKey');
        static::$resultType         = config('mobilyws.resultType');
        static::$viewResult         = null;
    }

    public static function SendRequest($url, $stringToPost = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        if (!empty($stringToPost)){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $stringToPost);
        }
        $result = curl_exec($ch);
        return $result;
    }

    /*
     * SMS Balance
     */
    public static function balanceSMS()
    {
        static::run();
        $url = "http://www.mobily.ws/api/balance.php";
        $stringToPost = (!empty(static::$apiKey)) ? "apiKey=".static::$apiKey : "mobile=".static::$userAccount."&password=".static::$passAccount;

        //dd(static::$MsgID, $stringToPost);
        $result = static::SendRequest($url, $stringToPost);
        if (static::$resultType == 1) {
            $ex = explode("/", trim($result));
            $result = trans('mobilyws::mobilyws.arrayBalance3', ['balance' => $ex[0], 'sms_total' => $ex[1]]);
        }
        return $result;
    }

    /*
     * Send SMS
     */
    public static function sendSMS($numbers, $msg, $timeSend=0, $dateSend=0, $deleteKey=0)
    {
        static::run();
        $url = "http://www.mobily.ws/api/msgSend.php";
        $applicationType = "68";
        $sender = urlencode(static::$sender);
        $domainName = $_SERVER['SERVER_NAME'];
        $numbers = self::format_numbers($numbers);

        if (!empty(static::$apiKey)) {
            $stringToPost = "apiKey=".static::$apiKey."&numbers=".$numbers."&sender=".$sender."&msg=".$msg."&timeSend=".$timeSend."&dateSend=".$dateSend."&applicationType=".$applicationType."&domainName=".$domainName."&msgId=".static::$MsgID."&deleteKey=".$deleteKey."&lang=3";
        } else {
            $stringToPost = "mobile=" . static::$userAccount . "&password=" . static::$passAccount . "&numbers=" . $numbers . "&sender=" . $sender . "&msg=" . $msg . "&timeSend=" . $timeSend . "&dateSend=" . $dateSend . "&applicationType=" . $applicationType . "&domainName=" . $domainName . "&msgId=" . static::$MsgID . "&deleteKey=" . $deleteKey . "&lang=3";
        }

        $result = static::SendRequest($url, $stringToPost);

        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arraySendMsg'.$result);
        }
        return $result;
    }

    /*
     * check Status
     */
    public static function sendStatus()
    {
        static::run();
        $url = "http://www.mobily.ws/api/sendStatus.php";
        $result = static::SendRequest($url);

        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arraySendStatus'.$result);
        }
        return $result;
    }

    /*
     * Change Password
     */
    public static function changePassword($newPassAccount)
    {
        static::run();
        $url = "http://www.mobily.ws/api/changePassword.php";
        if(!empty(static::$apiKey)) {
            $stringToPost = "apiKey=".static::$apiKey."&newPassword=".$newPassAccount;
        } else {
            $stringToPost = "mobile=".static::$userAccount."&password=".static::$passAccount."&newPassword=".$newPassAccount;
        }
        $result = static::SendRequest($url, $stringToPost);

        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arrayChangePassword'.$result);
        }
        return $result;
    }

    /*
     * Forget Password
     */
    public static function forgetPassword($sendType)
    {
        static::run();
        $url = "http://www.mobily.ws/api/forgetPassword.php";
        if(!empty(static::$apiKey)) {
            $stringToPost = "apiKey=".static::$apiKey."&type=".$sendType;
        } else {
            $stringToPost = "mobile=".static::$userAccount."&type=".$sendType;
        }
        $result = static::SendRequest($url, $stringToPost);
        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arrayForgetPassword'.$result);
        }
        return $result;
    }


    /*
    * Send SMS with unique template
    */
    public static function sendSMSWK($numbers, $msg, $msgKey, $timeSend=0, $dateSend=0, $deleteKey=0)
    {
        static::run();
        $url = "http://www.mobily.ws/api/msgSendWK.php";
        $applicationType = "68";
        $sender = urlencode(static::$sender);
        $domainName = $_SERVER['SERVER_NAME'];
        $numbers = self::format_numbers($numbers);

        if(!empty(static::$apiKey)) {
            $stringToPost = "apiKey=".static::$apiKey."&numbers=".$numbers."&sender=".$sender."&msg=".$msg."&msgKey=".$msgKey."&timeSend=".$timeSend."&dateSend=".$dateSend."&applicationType=".$applicationType."&domainName=".$domainName."&msgId=".static::$MsgID."&deleteKey=".$deleteKey."&lang=3";
        } else {
            $stringToPost = "mobile=".static::$userAccount."&password=".static::$passAccount."&numbers=".$numbers."&sender=".$sender."&msg=".$msg."&msgKey=".$msgKey."&timeSend=".$timeSend."&dateSend=".$dateSend."&applicationType=".$applicationType."&domainName=".$domainName."&msgId=".static::$MsgID."&deleteKey=".$deleteKey."&lang=3";
        }
        $result = static::SendRequest($url, $stringToPost);
        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arraySendMsgWK'.$result);
        }
        return $result;
    }

    /*
     * Delete scheduled SMS
     */
    public static function deleteSMS()
    {
        static::run();
        $url = "http://www.mobily.ws/api/deleteMsg.php";
        if(!empty(static::$apiKey)) {
            $stringToPost = "apiKey=".static::$apiKey."&deleteKey=".static::$deleteKey;
        } else {
            $stringToPost = "mobile=".static::$userAccount."&password=".static::$passAccount."&deleteKey=".static::$deleteKey;
        }
        $result = static::SendRequest($url, $stringToPost);

        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arrayDeleteSMS'.$result);
        }
        return $result;
    }

    /*
     * Request sender name
     */
    public static function addSender($sender)
    {
        static::run();
        $url = "http://www.mobily.ws/api/addSender.php";
        if(!empty(static::$apiKey)) {
            $stringToPost = "apiKey=".static::$apiKey."&sender=".$sender;
        } else {
            $stringToPost = "mobile=".static::$userAccount."&password=".static::$passAccount."&sender=".$sender;
        }
        $result = static::SendRequest($url, $stringToPost);
        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arrayAddSender'.$result);
        }
        return $result;
    }

    /*
     * Activate Sender name
     */
    public static function activeSender($senderId, $activeKey)
    {
        static::run();
        $url = "http://www.mobily.ws/api/activeSender.php";
        if(!empty(static::$apiKey)) {
            $stringToPost = "apiKey=".static::$apiKey."&senderId=".$senderId."&activeKey=".$activeKey;
        } else {
            $stringToPost = "mobile=".static::$userAccount."&password=".static::$passAccount."&senderId=".$senderId."&activeKey=".$activeKey;
        }
        $result = static::SendRequest($url, $stringToPost);
        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arrayActiveSender'.$result);
        }
        return $result;
    }

    /*
     * Check Sender name status
     */
    public static function checkSender($senderId)
    {
        static::run();
        $url = "http://www.mobily.ws/api/checkSender.php";
        if(!empty(static::$apiKey)) {
            $stringToPost = "apiKey=".static::$apiKey."&senderId=".$senderId;
        } else {
            $stringToPost = "mobile=".static::$userAccount."&password=".static::$passAccount."&senderId=".$senderId;
        }
        $result = static::SendRequest($url, $stringToPost);
        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arrayCheckSender'.$result);
        }
        return $result;
    }

    /*
     * Request Sender name alpha
     */
    public static function addAlphaSender($sender)
    {
        static::run();
        $url = "http://www.mobily.ws/api/addAlphaSender.php";
        if(!empty(static::$apiKey)) {
            $stringToPost = "apiKey=".static::$apiKey."&sender=".$sender;
        } else {
            $stringToPost = "mobile=".static::$userAccount."&password=".static::$passAccount."&sender=".$sender;
        }
        $result = static::SendRequest($url, $stringToPost);
        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arrayAddAlphaSender'.$result);
        }
        return $result;
    }

    /*
     * Check Sender name requested alpha
     */
    public static function checkAlphasSender($sender)
    {
        static::run();
        $url = "http://www.mobily.ws/api/checkAlphasSender.php";
        if(!empty(static::$apiKey)) {
            $stringToPost = "apiKey=".static::$apiKey."&sender=".$sender;
        } else {
            $stringToPost = "mobile=".static::$userAccount."&password=".static::$passAccount."&sender=".$sender;
        }
        $result = static::SendRequest($url, $stringToPost);
        if (static::$resultType == 1) {
            $result = trans('mobilyws::mobilyws.arrayCheckAlphasSender'.$result);
        }
        return $result;
    }

    public static function format_numbers($numbers)
    {
        if (!is_array($numbers)) {
            return self::format_number($numbers);
        } else {
            $numbers_array = [];
            foreach ($numbers as $number) {
                $n = self::format_number($number);
                Arr::add($numbers_array, $n);
            }
            return implode(',', $numbers_array);
        }
    }

    public static function format_number($number)
    {
        if (strlen($number) == 10 && Str::startsWith($number, '05')) {
            return preg_replace('/^0/', '966', $number);
        } elseif (Str::startsWith($number, '00')) {
            return preg_replace('/^00/', '', $number);
        } elseif (Str::startsWith($number, '+')){
            return preg_replace('/^+/', '', $number);
        }
        return $number;
    }

    public static function count_messages($text)
    {
        $length = mb_strlen($text);
        if ($length <= 70) {
            return 1;
        } else {
            return ceil($length / 67);
        }
    }



}
