<?php
//namespace cuonic\PHPAuth2;

class Config
{

    //public $licenceID = 0; ///????

    private $base_url = 'localhost/work/authexample';
    private $salt_1 = 'us_1dUDN4N-53/dkf7Sd?vbc_due1d?df!feg';
    private $salt_2 = 'Yu23ds09*d?u8SDv6sd?usi$_YSdsa24fd+83';
    private $salt_3 = '63fds.dfhsAdyISs_?&jdUsydbv92bf54ggvc';
    private $cookie_domain;
    private $cookie_path = '/';
    private $cookie_auth = 'auth_session';
    private $sitekey = '1'; //dk;l189654è(tyhj§!dfgdfàzgq_f4fá.
    private $table_attempts = 'attempts';
    private $table_log = 'log';
    private $table_sessions = 'sessions';
    private $table_users = 'Users';
    

    /****************************/
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}

/******** Key variables for a logged-in user ********/
class UserKeys
{
    public $Username = "";
    public $UserGrpName ="";

    public $UserID = 0;
    public $HospID = 0;
    public $UnitID = 0; 
    public $HUMin = 0;
    public $HUMax = 0;

    public $LicNumOfUsers = 0;
    public $AppName = "";
}

class Auth
{

    public $UsrKeys;
    // public $Username = "";
    // public $UserGrpName ="";
    // public $UserID = 0;
    // public $HospID = 0;
    // public $LicNumOfUsers = 0;
    // public $AppName = "";
    /*************/

    private $config;
    const SESSION_LENGTH = 1800; // 30 minutes in seconds

    /*
    * Initiates database connection
    */

    //public function __construct(\PDO $dbh)
    public function __construct($connect)
    {
        $this->UsrKeys = new UserKeys();

        $this->config = new Config();
        $cookie_domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        $this->config->cookie_domain = $cookie_domain;
        
        //include 'db.php';    
        //include './config.php';
        //$connect = odbc_connect('DRIVER={4D v12 ODBC Driver};SSL=false;SERVER='.$host.';PORT='.$port.';UID='.$user.';PWD='.$pass.'',"","");
        
        //echo var_dump($connect);

        $this->conn = $connect;

        //include('/../../config.php');        
        //$this->conn = odbc_connect('DRIVER={4D v12 ODBC Driver};SSL=false;SERVER='.$host.';PORT='.$port.';UID='.$user.';PWD='.$pass.'',"","");
    }


    /*
    * Fills the key user variables.
    * Ret: True (Success) / False
    */
    public function fillUserKeys($hash)
    {

        $query = "SELECT uid FROM ".$this->config->table_sessions." WHERE hash = '$hash'";
        $update = odbc_exec($this->conn, $query);
        $row = odbc_fetch_array($update);
        if (!$row) {
            return false;
        } else {
            //$query = "SELECT UserID, UserName, Hospital_Number FROM ".$this->config->table_users." WHERE ID = ".$row['UID']."";
            $query = 
                "SELECT UserID, UserName, GroupName
                ,Hospital_Number, Unit_Number
                ,NumberOfUsers
                ,prf_ApplicationName
                FROM Users,UserGroups,LicenseControl,Preferences
                WHERE Users.Hospital_Number=LicenseControl.HospitalNumber
                AND Users.GrpID=UserGroups.ID
                AND Users.Hospital_Number=Preferences.prf_Hospital_ID
                AND Users.ID=".$row['UID']."";

            $update = odbc_exec($this->conn, $query);
            $row = odbc_fetch_array($update);
            if (!$row) {
                return false;
            } 
            else 
            {
                $this->UsrKeys->Username = $row['USERNAME'];
                $this->UsrKeys->UserGrpName = $row['GROUPNAME'];
                $this->UsrKeys->UserID = $row['USERID'];
                $this->UsrKeys->HospID = $row['HOSPITAL_NUMBER'];
                $this->UsrKeys->UnitID = $row['UNIT_NUMBER'];
                $this->UsrKeys->LicNumOfUsers= $row['NUMBEROFUSERS'];

                $this->UsrKeys->HUMin = (($this->UsrKeys->HospID)*10+($this->UsrKeys->UnitID))*100000;
                $this->UsrKeys->HUMax = $this->UsrKeys->HUMin + 99999;

                switch ($row['PRF_APPLICATIONNAME']) {    // Based on former Mela_SQL->getAppName
                    case "MedICUs Outreach":
                        $this->UsrKeys->AppName = "Outreach";
                    break;
                
                    case "Pain Management Acute":
                        $this->UsrKeys->AppName = "AcutePain";
                    break;
                
                    case "Acute Pain Services":
                        $this->UsrKeys->AppName = "AcutePain";
                    break;
                
                    default:
                        $this->UsrKeys->AppName = "AcutePain";
                    break;    
                }            
            }
        }
    }


    /*
    * Logs a user in
    * @param string $username
    * @param string $password
    * @return array $return
    */
    public function login($usname, $password)
    {

        $return = array();

        $ip = $this->getIp();

        if ($this->isBlocked($ip)) {
            $return['code'] = 0;
            return $return;
        } else {
            if (strlen($usname) == 0) {
                $return['code'] = 1;
                //$this->addAttempt($ip);
                return $return;
            } elseif (strlen($password) == 0) {
                $return['code'] = 1;
                //$this->addAttempt($ip);
                return $return;
            } else {
                $plainpass = $password;
                //$password = $this->getHash($password);

                if ($userdata = $this->getUserData($usname)) {
                    if ($password === $userdata['PASSWORD']) {
                            /* Login success so far - username/password are correct
                             * and accounts are active. Now check how many users
                             * can be logged in simultaneously based on the licence limits. */

                            $sql = "SELECT COUNT(*) AS LOGGEDNUM FROM sessions WHERE HospID=".$userdata['HOSPITAL_NUMBER'];
                            $res = odbc_exec($this->conn, $sql);
                            $ses = odbc_fetch_array($res);
                            if ($ses) {
                                if ($ses['LOGGEDNUM'] == "")
                                    $ses['LOGGEDNUM'] = "0";
                            }
                            else {   // 'Sys' error
                                $return['code'] = 901;
                                return $return;                               
                            }
                            if ($ses['LOGGEDNUM'] < $userdata['NUMBEROFUSERS'])  // will be ok, as else rets err above
                            {
                                // Check if the current user already has an active session
                                $existingSession = $this->checkSessionExists($userdata['uid']);
                                if ($existingSession == FALSE) {
                                    //--------------------------------------------------
                                    // SUCCESS - fill key vars ///
                                    //--------------------------------------------------
                                    $sessiondata = $this->addNewSession ($userdata['uid'], $userdata['HOSPITAL_NUMBER']);                        
                                    $return['code'] = 4;
                                    $return['session_hash'] = $sessiondata['hash'];
                                    setcookie(
                                        $this->config->cookie_auth,
                                        $sessiondata['hash'],
                                        time() + (10 * 365 * 24 * 60 * 60),
                                        $this->config->cookie_path,
                                        $this->config->cookie_domain,
                                        false,
                                        true
                                    );
                                    return $return;
                                    //--------------------------------------------------
                                }
                                else {
                                    // Another sess for this user exists
                                    $return['code'] = 7;
                                    return $return;
                                }
                            }
                            else {
                                // Too many active users for licence                            
                                $return['code'] = 5;                                
                                return $return;
                            }
                    } else {
                        // Password incorrect
                        $return['code'] = 2;
                        return $return;
                    }
                } else {
                    // Username doesn't exist in DB
                    $return['code'] = 6;
                    return $return;
                }
            }
        }

    }

    /*
    * Logs out the session, identified by hash
    * @param string $hash
    * @return boolean
    */

    public function logout($hash)
    {
        /*if (strlen($hash) != 40) {
            return false;
        }*/

        $return = $this->deleteSession($hash);

        if ($return) {
            setcookie(
                $this->config->cookie_auth,
                $hash,
                time() - 3600,
                $this->config->cookie_path,
                $this->config->cookie_domain,
                false,
                true
            );
        }

        return $return;
    }

    /*
    * Hashes string using md5
    * @param string $string
    * @return string $enc
    */

    public function getHash($string)
    {        
        $enc = md5($string);
        return $enc;
    }

    
    // $$$ Use $Username now
    /*
    * Returns username based on session hash
    * @param string $hash
    * @return string $username
    */
    //public function getUsername($hash)
    //{
    //    /*$query = $this->dbh->prepare("SELECT uid FROM ".$this->config->table_sessions." WHERE hash = ?");
    //    $query->execute(array($hash));
    //    $row = $query->fetch(\PDO::FETCH_ASSOC);*/
    //    $query = "SELECT uid FROM ".$this->config->table_sessions." WHERE hash = '$hash'";
    //    $update = odbc_exec($this->conn, $query);
    //    $row = odbc_fetch_array($update);

    //    if (!$row) {
    //        return false;
    //    } else {
    //        /*$query = $this->dbh->prepare("SELECT username FROM ".$this->config->table_users." WHERE id = ?");
    //        $query->execute(array($row['uid']));
    //        $row = $query->fetch(\PDO::FETCH_ASSOC);*/
    //        $query = "SELECT UserID FROM ".$this->config->table_users." WHERE ID = ".$row['UID']."";
    //        $update = odbc_exec($this->conn, $query);
    //        $row = odbc_fetch_array($update);

    //        if (!$row) {
    //            return false;
    //        } else {
    //            return $row['USERID'];
    //        }
    //    }
    //}

    //--------------------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------


    /*
    * Gets user data (and related) for a given username and returns an array
    * @param string $usname
    * @return array $data
    */
     function getUserData($usname)
    {
        $data = array();
     
        $query = "SELECT Users.ID, Users.UserID, Users.Password, Users.Hospital_Number, NumberOfUsers
            FROM Users,LicenseControl
            WHERE Users.Hospital_Number=LicenseControl.HospitalNumber
            AND UserName = '$usname'";
        /* --- OLD --- "SELECT ID, UserID, Password, Hospital_Number FROM ".$this->config->table_users." WHERE UserName = '$usname'";*/
        $update = odbc_exec($this->conn, $query);
        $data = odbc_fetch_array($update);
        if (!$data) {
            return false;
        } else {
			$data['uid'] = $data['ID'];			
            return $data;
        }
    }

    /*
    * Creates a session for a specified user id
    * @param int $uid
    * @return array $data
    */

    private function addNewSession($uid, $HospID)
    {
        /*$query = $this->dbh->prepare("SELECT salt, lang FROM ".$this->config->table_users." WHERE id = ?");
        $query->execute(array($uid));
        $data = $query->fetch(\PDO::FETCH_ASSOC);*/
        $query = "SELECT ID FROM ".$this->config->table_users." WHERE UserID = $uid";
        $update = odbc_exec($this->conn, $query);
        $data = odbc_fetch_array($update);
        
        $data['hash'] = sha1($data['ID'] . microtime());

        $agent = $_SERVER['HTTP_USER_AGENT'];

        $this->deleteExistingSessions($uid);

        $ip = $this->getIp();

        //$data['expire'] = date("Y-m-d H:i:s", strtotime(self::SESSION_LENGTH));
        $data['expire'] = "2033-05-05 05:05:05";
        $data['cookie_crc'] = sha1($data['hash'] . $this->config->sitekey);

        //$licenceID = 1; //$$$ hardcoded for now, will be used to limit sessions per licence ??????????????????????????????????
        
        /*$query = $this->dbh->prepare(
            "INSERT INTO ".$this->config->table_sessions." (uid, hash, expiredate, ip, agent, cookie_crc, lang, licence) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $query->execute(array($uid, $data['hash'], $data['expire'], $ip, $agent, $data['cookie_crc'], $data['lang'], $licenceID));*/
        
        $query = 
            "INSERT INTO ".$this->config->table_sessions." 
            (uid, HospID, hash, expiredate, ip, agent, cookie_crc) VALUES 
            ($uid, $HospID, '".$data['hash']."', '".$data['expire']."', '$ip', '$agent', '".$data['cookie_crc']."')";
        $update = odbc_exec($this->conn, $query);

        return $data;
    }

    /*
    * Removes all existing sessions for a given UID
    * @param int $uid
    * @return boolean
    */

    private function deleteExistingSessions($uid)
    {
        /*$query = $this->dbh->prepare("DELETE FROM ".$this->config->table_sessions." WHERE uid = ?");
        $return = $query->execute(array($uid));*/
        
        $query = "DELETE FROM ".$this->config->table_sessions." WHERE uid = $uid";
        $return = odbc_exec($this->conn, $query);

        return $return;
    }

    /*
    * Removes a session based on hash
    * @param string $hash
    * @return boolean
    */

    private function deleteSession($hash)
    {
        /*$query = $this->dbh->prepare("DELETE FROM ".$this->config->table_sessions." WHERE hash = ?");
        $return = $query->execute(array($hash));*/
        $query = "DELETE FROM ".$this->config->table_sessions." WHERE hash = '$hash'";
        $return = odbc_exec($this->conn, $query);

        return $return;
    }


    /*
     * Function to check if session has expired, delete if so
     * @param string $hash
     * @return boolean
     */
    
    public function checkSessionExpired($hash) {
        $query = "SELECT id, uid, expiredate, ip, agent, cookie_crc FROM ".$this->config->table_sessions." WHERE hash = '$hash'";
        $update = odbc_exec($this->conn, $query);
        $row = odbc_fetch_array($update);
        
        $now = strtotime('now');
        
        if ($now > $row['EXPIREDATE']) {
            // Session has expired, delete it and return true
            $this->deleteSession($hash);
            return true;
        }
        else {
            return false;
        }
    }
    
    /*
    * Function to check if a session is valid
    * @param string $hash
    * @return boolean
    */

    public function checkSession($hash)
    {
        $ip = $this->getIp();

        if ($this->isBlocked($ip)) {
            return false;
        } else {
            if (strlen($hash) != 40) {
                setcookie(
                    $this->config->cookie_auth,
                    $hash,
                    time() - 3600,
                    $this->config->cookie_path,
                    $this->config->cookie_domain,
                    false,
                    true
                );
                return false;
            }

            /*$query = $this->dbh->prepare(
                "SELECT id, uid, expiredate, ip, agent, cookie_crc FROM ".$this->config->table_sessions." WHERE hash = ?"
            );
            $query->execute(array($hash));
            $row = $query->fetch(\PDO::FETCH_ASSOC);*/
            $query = "SELECT id, uid, expiredate, ip, agent, cookie_crc FROM ".$this->config->table_sessions." WHERE hash = '$hash'";
            $update = odbc_exec($this->conn, $query);
            $row = odbc_fetch_array($update);

            if (!$row) {
                setcookie(
                    $this->config->cookie_auth,
                    $hash,
                    time() - 3600,
                    $this->config->cookie_path,
                    $this->config->cookie_domain,
                    false,
                    true
                );

                /*$this->addNewLog(
                    $row['uid'],
                    "CHECKSESSION_FAIL_NOEXIST",
                    "Hash ({$hash}) doesn't exist in DB -> Cookie deleted"
                );*/

                return false;
            } else {
                $sid = $row['ID'];
                $uid = $row['UID'];
                $expiredate = $row['EXPIREDATE'];
                $db_ip = $row['IP'];
                $db_agent = $row['AGENT'];
                $db_cookie = $row['COOKIE_CRC'];

                if ($ip != $db_ip) {
                    if ($_SERVER['HTTP_USER_AGENT'] != $db_agent) {
                        $this->deleteExistingSessions($uid);

                        setcookie(
                            $this->config->cookie_auth,
                            $hash,
                            time() - 3600,
                            $this->config->cookie_path,
                            $this->config->cookie_domain,
                            false,
                            true
                        );

                        /*$this->addNewLog(
                            $uid,
                            "CHECKSESSION_FAIL_DIFF",
                            "IP and User Agent Different ( DB : {$db_ip} / Current : " . $ip . " ) -> UID sessions deleted, cookie deleted"
                        );*/

                        return false;
                    } else {
                        $expiredate = strtotime($expiredate);
                        $currentdate = strtotime(date("Y-m-d H:i:s"));

                        if ($currentdate > $expiredate) {
                            $this->deleteExistingSessions($uid);

                            setcookie(
                                $this->config->cookie_auth,
                                $hash,
                                time() - 3600,
                                $this->config->cookie_path,
                                $this->config->cookie_domain,
                                false,
                                true
                            );

                            /*$this->addNewLog(
                                $uid,
                                "CHECKSESSION_FAIL_EXPIRE",
                                "Session expired ( Expire date : {$row['expiredate']} ) -> UID sessions deleted, cookie deleted"
                            );*/

                            return false;
                        } else {
                            return $this->updateSessionIp($sid, $ip);
                        }
                    }
                } else {
                    $expiredate = strtotime($expiredate);
                    $currentdate = strtotime(date("Y-m-d H:i:s"));

                    if ($currentdate > $expiredate) {
                        $this->deleteExistingSessions($uid);

                        setcookie(
                            $this->config->cookie_auth,
                            $hash,
                            time() - 3600,
                            $this->config->cookie_path,
                            $this->config->cookie_domain,
                            false,
                            true
                        );

                        /*$this->addNewLog(
                            $uid,
                            "AUTH_CHECKSESSION_FAIL_EXPIRE",
                            "Session expired ( Expire date : {$row['expiredate']} ) -> UID sessions deleted, cookie deleted"
                        );*/

                        return false;
                    } else {
                        $cookie_crc = sha1($hash . $this->config->sitekey);

                        if ($db_cookie == $cookie_crc) {
                            return true;
                        } else {
                            //$this->addNewLog($uid, "AUTH_COOKIE_FAIL_BADCRC", "Cookie Integrity failed");

                            return false;
                        }
                    }
                }
            }
        }
    }

    /*
    * Updates the IP of a session (used if IP has changed, but agent has remained unchanged)
    * @param int $sid
    * @param string $ip
    * @return boolean
    */

    private function updateSessionIp($sid, $ip)
    {
        /*$query = $this->dbh->prepare("UPDATE ".$this->config->table_sessions." SET ip = ? WHERE id = ?");
        $return = $query->execute(array($ip, $sid));*/
        $query = "UPDATE ".$this->config->table_sessions." SET ip = '$ip' WHERE id = $sid";
        $return = odbc_exec($this->conn, $query);

        return $return;
    }

    /*
    * Gets UID from Session hash
    * @param string $hash
    * @return int $uid
    */

    public function sessionUID($hash)
    {
        if (strlen($hash) != 40) {
            return false;
        } else {
            /*$query = $this->dbh->prepare("SELECT uid FROM ".$this->config->table_sessions." WHERE hash = ?");
            $query->execute(array($hash));
            $row = $query->fetch(\PDO::FETCH_ASSOC);*/
            $query = "SELECT uid FROM ".$this->config->table_sessions." WHERE hash = '$hash'";
            $update = odbc_exec($this->conn, $query);
            $row = odbc_fetch_array($update);

            if (!$row) {
                return false;
            } else {
                return $row['UID'];
            }
        }
    }

    /*
    * Informs if a user is locked out
    * @param string $ip
    * @return boolean
    */

    public function isBlocked($ip)
    {
        /*$query = $this->dbh->prepare("SELECT count, expiredate FROM ".$this->config->table_attempts." WHERE ip = ?");
        $query->execute(array($ip));
        $row = $query->fetch(\PDO::FETCH_ASSOC);*/
        $query = "SELECT attemptcount, expiredate FROM ".$this->config->table_attempts." WHERE ip = '$ip'";
        $update = odbc_exec($this->conn, $query);
        $row = odbc_fetch_array($update);

        if (!$row) {
            return false;
        } else {
            if ($row['ATTEMPTCOUNT'] == 5) {
                $expiredate = strtotime($row['EXPIREDATE']);
                $currentdate = strtotime(date("Y-m-d H:i:s"));

                if ($currentdate < $expiredate) {
                    return true;
                } else {
                    $this->deleteAttempts($ip);
                    return false;
                }
            } else {
                $expiredate = strtotime($row['EXPIREDATE']);
                $currentdate = strtotime(date("Y-m-d H:i:s"));

                if ($currentdate < $expiredate) {
                    return false;
                } else {
                    $this->deleteAttempts($ip);
                    return false;
                }

                return false;
            }
        }
    }

    /*
    * Deletes all attempts for a given IP from database
    * @param string $ip
    * @return boolean
    */

    private function deleteAttempts($ip)
    {
        /*$query = $this->dbh->prepare("DELETE FROM ".$this->config->table_attempts." WHERE ip = ?");
        $return = $query->execute(array($ip));*/
        $query = "DELETE FROM ".$this->config->table_attempts." WHERE ip = '$ip'";
        $return = odbc_exec($this->conn, $query);

        return $return;
    }

    /*
    * Adds an attempt to database for given IP
    * @param string $ip
    * @return boolean
    */

    private function addAttempt($ip)
    {
        /*$query = $this->dbh->prepare("SELECT count FROM ".$this->config->table_attempts." WHERE ip = ?");
        $query->execute(array($ip));
        $row = $query->fetch(\PDO::FETCH_ASSOC);*/
        $query = "SELECT attemptcount FROM ".$this->config->table_attempts." WHERE ip = '$ip'";
        $update = odbc_exec($this->conn, $query);
        $row = odbc_fetch_array($update);
						
        if (!$row) {
            $attempt_expiredate = date("Y-m-d H:i:s", strtotime("+30 minutes"));
            $attempt_count = 1;

            /*$query = $this->dbh->prepare("INSERT INTO ".$this->config->table_attempts." (ip, count, expiredate) VALUES (?, ?, ?)");
            $return = $query->execute(array($ip, $attempt_count, $attempt_expiredate));*/
            $query = "INSERT INTO ".$this->config->table_attempts." (ip, attemptcount, expiredate) VALUES ('$ip', $attempt_count, '$attempt_expiredate')";
            $update = odbc_exec($this->conn, $query);
            $return = odbc_fetch_array($update);
			
            return $return;
        } else {
            $attempt_expiredate = date("Y-m-d H:i:s", strtotime("+30 minutes"));
            $attempt_count = $row['ATTEMPTCOUNT'] + 1;

            /*$query = $this->dbh->prepare("UPDATE ".$this->config->table_attempts." SET count=?, expiredate=? WHERE ip=?");
            $return = $query->execute(array($attempt_count, $attempt_expiredate, $ip));*/
            $query = "UPDATE ".$this->config->table_attempts." SET attemptcount=$attempt_count, expiredate='$attempt_expiredate' WHERE ip='$ip'";
            $return = odbc_exec($this->conn, $query);
			
            return $return;
        }
    }

    /*
    * Returns a random string, length can be modified
    * @param int $length
    * @return string $key
    */

    public function getRandomKey($length = 20)
    {
        $chars = "_" . "A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6" . "_" . "a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6" . "_";
        $key = "";

        for ($i = 0; $i < $length; $i++) {
            $key .= $chars{mt_rand(0, strlen($chars) - 1)};
        }

        return $key;
    }

    /*
    * Returns ip address
    * @return string $ip
    */

    // Source : http://stackoverflow.com/questions/1634782/what-is-the-most-accurate-way-to-retrieve-a-users-correct-ip-address-in-php?rq=1

    private function getIp()
	{
		if (!empty($_SERVER['HTTP_X_FORWARDED']) && $this->validate_ip($_SERVER['HTTP_X_FORWARDED']))
			return $_SERVER['HTTP_X_FORWARDED'];
		if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && $this->validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
			return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && $this->validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
			return $_SERVER['HTTP_FORWARDED_FOR'];
		if (!empty($_SERVER['HTTP_FORWARDED']) && $this->validate_ip($_SERVER['HTTP_FORWARDED']))
			return $_SERVER['HTTP_FORWARDED'];

		return $_SERVER['REMOTE_ADDR'];
	}
	
    /*
    * Validates a given IP Address
    * @param string $ip
    * @return boolean
    */
	
    function validate_ip($ip) 
	{
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 |FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false)
		{
			return false;
		}
		
		 self::$ip = $ip;
		 
		 return true;
	}
    
    /*
     * Check if a session already exists for the specified user
     * @param string $uid User ID
     * @return bool True/false
     */
    public function checkSessionExists($uid) {
        $query = "SELECT expiredate, hash FROM ".$this->config->table_sessions." WHERE uid = $uid";
        $update = odbc_exec($this->conn, $query);
        $row = odbc_fetch_array($update);
        
        if (!$row) {
            return false;
        } else {
            // Check if expiredate is outdated. If so, delete session
            $now = strtotime('now');
            $format = date('Y-m-d H:i:s',$now);
            
            if ($format >= $row['EXPIREDATE']) {
                // Expiry date has run out so delete session
                $this->deleteSession($row['HASH']);
                // Delete cookie too if it exists
                if ($_COOKIE[$this->config->cookie_auth]) {
                    setcookie(
                            $this->config->cookie_auth,
                            $hash,
                            time() - 3600,
                            $this->config->cookie_path,
                            $this->config->cookie_domain,
                            false,
                            true
                    );
                }
                return false;
            }
            else return true;
        }
    }
    
    /*
     * Update the session expiry date
     * @param string $hash The hash of the session to update
     * @return boolean True if session updated successfully, false otherwise (most likely session did not exist/had expired)
     */
    
    public function updateSessionExpiry($hash) {
        $query = "SELECT expiredate FROM ".$this->config->table_sessions." WHERE hash = '$hash'";
        $update = odbc_exec($this->conn, $query);
        $row = odbc_fetch_array($update);
        $now = strtotime('now');
        
        if ($row && $row['EXPIREDATE'] < $now) {
            $newExpiryDate = date("Y-m-d H:i:s", strtotime(self::SESSION_LENGTH));
            $query = "UPDATE ".$this->config->table_sessions." SET expiredate='$newExpiryDate' WHERE hash = '$hash'";
            $update = odbc_exec($this->conn, $query);
            // Make sure to update cookie accordingly!
            /*setcookie(
                    $this->config->cookie_auth,
                    $hash,
                    time() + self:SESSION_LENGTH,
                    $this->config->cookie_path,
                    $this->config->cookie_domain,
                    false,
                    true
                    );*/
            return true;
        } else return false;
    }
    
    /*
     * Check if user is logged in
     * @param string $cookie $_COOKIE['auth_session']
     * @return bool True/False
     */
    public function isLoggedIn($cookie) {
        if(isset($cookie)) {
            
            if (empty($cookie)) {
                return false;   
            }            
            elseif(!$this->checkSession($cookie)) {
                return false;
            }
            /*elseif ($this->checkSessionExpired($cookie)) {
                return false;
            }*/
            else return true;
            
        }
        else {
            return false;
        }
    }
}
