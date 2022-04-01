<?php 

include_once '../../autoload.php';
date_default_timezone_set('Asia/Hong_Kong'); 
class TrialController {
    
    private $next_date     = null;
    private $current_date = null;
    public function __construct()
    {
        $this->next_date    = date('Y-m-d', strtotime(' +1 day'));
        $this->current_date = date('Y-m-d');
    }

    public function count_request()
    {
        global $db, $common;

        $has_trial = $db->select("SELECT * FROM trial_preview", []);
      
        if (empty($has_trial)) {
            $db->query("TRUNCATE TABLE trial_preview", []);
            $db->query("INSERT INTO 
                                trial_preview 
                                (no_request, date_start, date_end) 
                                VALUES (?,?,?)", [1, $this->current_date, $this->next_date]);
            return true;
        } else {
            $has_trial = $has_trial[0];
        }

        if ($has_trial['no_request'] == 30 && $has_trial['date_start'] === $this->current_date) {
            return false;
        }
        
        if ($has_trial['date_start'] === $this->current_date) {
            $has_trial['no_request'] = $has_trial['no_request'] + 1; 
            $db->query("UPDATE trial_preview SET no_request = ? WHERE id = ?", [$has_trial['no_request'], 1]);
            return true;
        } else {
            $db->query("TRUNCATE TABLE trial_preview", []);

            $db->query("INSERT INTO 
                        trial_preview 
                        (no_request, date_start, date_end) 
                        VALUES (?,?,?)", [1, $this->current_date, $this->next_date]);
            return true;
        }
    }
}

$trial_controller = new TrialController();