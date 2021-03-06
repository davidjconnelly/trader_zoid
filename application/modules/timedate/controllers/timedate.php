<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Timedate extends MX_Controller
{

function __construct() {
    parent::__construct();
}

function get_seconds_from_opening_bell($unix_timestamp) {
    //NYSE opens at 9:30am |  This totally works!!!
    $opening_bell_time = $this->get_opening_bell_time_as_timestamp($unix_timestamp);
    $nice_time = $this->get_nice_date($opening_bell_time, 'full');
    $time_gap = $unix_timestamp-$opening_bell_time;

    if ($time_gap<0) {
        echo "The stock market has not opened yet.";
        die();
    } else {
        return $time_gap;
    }
}

function get_opening_bell_time_as_timestamp($unix_timestamp) {
    //get the start of the day as a unix_timestamp
    $in_daylight_savings_time = $this->in_daylight_savings_time($unix_timestamp);

    if ($in_daylight_savings_time==TRUE) {
        $hour = 14;
    } else {
        $hour = 15;
    }

    $minute=30;
    $second=0;
    $day = $this->getday($unix_timestamp);
    $month = $this->get_month_num($unix_timestamp);
    $year = $this->getyear($unix_timestamp);
    
    $opening_bell_time = $this->maketime($hour, $minute, $second, $month, $day, $year);
    $opening_bell_time = $opening_bell_time-3600; //this needs fixed!
    return $opening_bell_time;
}




function in_daylight_savings_time($unix_timestamp) {

    $in_daylight_savings_time = date('I', $unix_timestamp);

    if ($in_daylight_savings_time==1) {
        return TRUE; //British summertime
    } else {
        return FALSE; //British wintertime
    }
}

function get_week_name($week_num) {
    switch ($week_num) {
        case '1':
        $week_name = 'Monday';
        break;

        case '2':
        $week_name = 'Tuesday';
        break;

        case '3':
        $week_name = 'Wednesday';
        break;

        case '4':
        $week_name = 'Thursday';
        break;

        case '5':
        $week_name = 'Friday';
        break;

        case '6':
        $week_name = 'Saturday';
        break;

        case '7':
        $week_name = 'Sunday';
        break;

        default:
        $week_name = "Unknown";

    }
    return $week_name;
}

function get_nice_date($timestamp, $format) {
    switch ($format) {
        case 'full':
        //FULL // Friday 18th of February 2011 at 10:00:00 AM       
        $the_date = date('l jS \of F Y \a\t h:i:s A', $timestamp);
        break;  
        
        case 'month_and_day':
        $the_date = date('M j', $timestamp);
        break;

        case 'month_and_year':
        $the_date = date('F Y', $timestamp);
        break;
        
        case 'cool':
        //FULL // Friday 18th of February 2011          
        $the_date = date('l jS \of F Y', $timestamp);
        break;                  
        case 'shorter':
        //SHORTER // 18th of February 2011          
        $the_date = date('jS \of F Y', $timestamp);
        break;          
        case 'mini':
        //MINI  // 18th Feb 2011
        $the_date = date('jS M Y', $timestamp);
        break;          
        case 'oldschool':
        //OLDSCHOOL  // 18/2/11         
        $the_date = date('j\/n\/y', $timestamp);
        break;

        case 'xlfriendly':
        //MINI  // Thursday, September 4, 2014
        $the_date = date('l, F j, Y', $timestamp);
        break; 

        case 'datepicker':
        //OLDSCHOOL  // 18/2/11         
        $the_date = date('d\-m\-Y', $timestamp); 
        break;  

        case 'hourmin':
        $the_date = date('H:i:s', $timestamp);
        break;
    }
    return $the_date;
}




function get_start_of_day_as_timestamp($unix_timestamp) {
    //get the start of the day as a unix_timestamp

    $hour=8;
    $minute=0;
    $second=0;
    
    $day = $this->getday($unix_timestamp);
    $month = $this->get_month_num($unix_timestamp);
    $year = $this->getyear($unix_timestamp);
    
    $unix_timestamp = $this->maketime($hour, $minute, $second, $month, $day, $year);
    return $unix_timestamp;

}



//establish what today is...
function getday($unix_timestamp) {
    $day=date("j", $unix_timestamp);
    return $day;
}


function get_month_num($unix_timestamp) {
    $monthnum=date("n", $unix_timestamp);
    return $monthnum;
}



//establish year from timestamp...
function getyear($timestamp) {
    $year=date("Y", $timestamp);
    return $year;
}


function make_timestamp_from_datepicker($datepicker) {
    $hour=7;
    $minute=0;
    $second=0;
    
    $day = substr($datepicker, 0, 2);
    $month = substr($datepicker, 3,2);
    $year = substr($datepicker, 6,4);
    
    $timestamp = $this->maketime($hour, $minute, $second, $month, $day, $year);
    return $timestamp;
}

function get_daydesc($day) {
   //get the proper day name from a short, three character ref
   switch ($day) {
    case 'mon':
    $daydesc="Monday";
    break;
    
    case 'tue':
    $daydesc="Tuesday";
    break;
    
    case 'wed':
    $daydesc="Wednesday";
    break;
    
    case 'thu':
    $daydesc="Thursday";
    break;
    
    case 'fri':
    $daydesc="Friday";
    break;
    
    case 'sat':
    $daydesc="Saturday";
    break;
    
    case 'sun':
    $daydesc="Sunday";
    break;
    
   }

   if (!isset($daydesc)) {
    $daydesc="";
   }
   
   return $daydesc;
}
	
function get_month_name($month_num) {

    switch ($month_num) {
        case '1':
            $monthname = "January";
            break;
        case '2':
            $monthname = "February";
            break;
        case '3':
            $monthname = "March";
            break;
        case '4':
            $monthname = "April";
            break;
        case '5':
            $monthname = "May";
            break;
        case '6':
            $monthname = "June";
            break;
        case '7':
            $monthname = "July";
            break;
        case '8':
            $monthname = "August";
            break;
        case '9':
            $monthname = "September";
            break;
        case '10':
            $monthname = "October";
            break;
        case '11':
            $monthname = "November";
            break;
        case '12':
            $monthname = "December";
            break;
        default:
            $monthname = "Unknown";
    }
    return $monthname;
}

function get_month_num_from_string($month_name) {

    switch ($month_name) {
        case 'January':
            $month_num = "1";
            break;
        case 'February':
            $month_num = "2";
            break;
        case 'March':
            $month_num = "3";
            break;
        case 'April':
            $month_num = "4";
            break;
        case 'May':
            $month_num = "5";
            break;
        case 'June':
            $month_num = "6";
            break;
        case 'July':
            $month_num = "7";
            break;
        case 'August':
            $month_num = "8";
            break;
        case 'September':
            $month_num = "9";
            break;
        case 'October':
            $month_num = "10";
            break;
        case 'November':
            $month_num = "11";
            break;
        case 'December':
            $month_num = "12";
            break;
        default:
            $month_num = "Unknown";
    }

    return $month_num;
}

function calc_time_difference($time1, $time2) {
//calculate the difference in minutes between two times
//NOTE: submitted times should be of the format 8:00, 14:30 etc
    $start_hour = substr($time1, 0, 2);
    $start_minute = substr($time1, -2, 2);
  
    $end_hour = substr($time2, 0, 2); 
    $end_minute = substr($time2, -2, 2);
    
    $total_start_minutes = (60*$start_hour)+$start_minute;
    $total_end_minutes = (60*$end_hour)+$end_minute;

    $interval = $total_end_minutes-$total_start_minutes;    
    return $interval;
}

function getfifteenth($timestamp) {
//returns the 15th of the month at 3PM as a timestamp.
	$hour=15;
	$minute=0;
	$second=0;
	$day=15;
	$month=$this->getmonthnum($timestamp);
	$year=$this->getyear($timestamp);
	
	$fifteenth=$this->maketime($hour, $minute, $second, $month, $day, $year);
	return $fifteenth;
}
	
function maketime($hour, $minute, $second, $month, $day, $year) {
//returns a timestamp when a selection of variables are provided	
	$timestamp=mktime($hour, $minute, $second, $month, $day, $year);
    return $timestamp;
}
		
function getmonthnum($timestamp) {
	$monthnum=date("n", $timestamp);
    return $monthnum;
}
	
function unixtosql($timestamp) {
    //convert a timestamp to mysql datetime...
    $newtime=gmdate("Y-m-d H:i:s", $timestamp);
    return $newtime;
}
    
function is_today($timestamp) {
    //find out if this timestamp is today
    $nowtime=time();
	//get day month and year
	$nowday=$this->getday($nowtime);
	$nowmonth=$this->getmonthnum($nowtime);
	$nowyear=$this->getyear($nowtime);
	
	$time_one=$nowday.$nowmonth.$nowyear;
	
	$thisday=$this->getday($timestamp);
	$thismonth=$this->getmonthnum($timestamp);
	$thisyear=$this->getyear($timestamp);
	
	
	$time_two=$thisday.$thismonth.$thisyear;
	
	if ($time_one==$time_two) {
	   return TRUE;	
	} else {
	   return FALSE;	
	}
}
   
function convert_seconds_to_nice_time($seconds) {
    
    switch ($seconds) {
        case '900':
        $nice_time = "Fifteen Minutes";
            break;
        
        case '1800':
        $nice_time = "Half an Hour";
            break;
        
        case '3600':
        $nice_time = "One Hour";
            break;
        
        case '7200':
        $nice_time = "Two Hours";
            break;
        
        case '10800':
        $nice_time = "Three Hours";
            break;
        
        case '21600':
        $nice_time = "Six Hours";
            break;
        
        case '86400':
        $nice_time = "Twenty Four Hours";
            break;
        
        case '172800':
        $nice_time = "Two Days";
            break;
        
        case '259200':
        $nice_time = "Three Days";
            break;
        
        case '432000':
        $nice_time = "Five Days";
            break;
        
        case '604800':
        $nice_time = "Seven Days";
            break;
        
        case '864000':
        $nice_time = "Ten Days";
            break;
        
        case '1209600':
        $nice_time = "Two Weeks";
            break;
        
        case '1814400':
        $nice_time = "Three Weeks";
            break;
        
        case '2419200':
        $nice_time = "Four Weeks";
            break;
        
        case '2592000':
        $nice_time = "Thirty Days";
            break;
        
        case '3628800':
        $nice_time = "Six Weeks";
            break;
        
        case '5184000':
        $nice_time = "Two Months";
            break;
        
        case '7776000':
        $nice_time = "Three Months";
            break;

        default:
            $nice_time = "Unknown";
            break;
    }
return $nice_time;    
}

function convert_to_clock_time($hour, $minute) {
//takes two variables and returns in format suitable for digital clock
//For example - 14 and 0 would become returns 14:00
    if ($minute=="0") {
        $minute = "00";
    }
    
    $clock_time = $hour.":".$minute;
    return $clock_time;
}

function get_days_from_range($timestamp1, $timestamp2) {
    $numDays = abs($timestamp1 - $timestamp2)/60/60/24;

    for ($i = 1; $i < $numDays; $i++) {
        //echo date('Y m d', strtotime("+{$i} day", $timestamp1)) . '<br />';
        $unix_timestamp = date(strtotime("+{$i} day", $timestamp1));
        $day_name = date('l', $unix_timestamp);

        if (($day_name!="Saturday") && ($day_name!="Sunday")) {
            $days[] = $unix_timestamp;
        }
    }

    if (!isset($days)) {
        $days = "";
    }

    return $days;
}
    
}