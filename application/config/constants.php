<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');



/*
 * User define
 *
 */
define('SYS_NM', 'Redmine for GM');
define('REDMINE_URL', 'http://redmine.bit-vietnam.com/');


define('ATTENDANCE_PRJ_IDENTIFIER', 'amp');
define('ATTENDANCE_HOLIDAYS', serialize(
                array(
                    "0" => array("2014-04-09", "2014-04-30", "2014-05-01", "2014-09-02"), //0:default
                    "45" => array("2014-04-29","2014-05-03","2014-05-04","2014-05-05","2014-05-06","2014-07-21","2014-09-15","2014-09-23","2014-10-13","2014-11-03","2014-11-23","2014-11-24","2014-12-23") //group id=>holidays array
                )
        )); 
define('ATTENDANCE_WEEKDAY_WORKTIME', '8'); //Work time a day. If over this value, it will be counted as overtime.
define('ATTENDANCE_PAID_HOLIDAY_TRACKER_ID', '5'); //Check trackers table in database.


/* End of file constants.php */
/* Location: ./application/config/constants.php */