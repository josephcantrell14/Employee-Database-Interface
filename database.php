<?php

class Database {
    /* Array of MySQL results */
    var $output;
    /* Array of raw queries */
    var $input;
    /* The MySQL link */
    var $mysqli;
    /* Counts the queries */
    var $counter;
    /* Keeps track of all the errors */
    var $errors;
    /* boolean value, if debug info should be collected */
    var $debug;

    function __construct($debug = false) {
        $this->mysqli = new mysqli("localhost:3306", "root", "", "person") or die('<h3>The SQL Server is down</h3>Please check again later. If this error message persists for more than a few minutes, please contact an administrator.');
        $this->debug = $debug;
        //console($this->mysqli->host_info);
        if ($debug) {
            $this->output = array();
            $this->input = array();
            $this->errors = array();
            $this->counter = 0;
        }
    }

    /**
     * Sends a query. Gives you a result.
     *
     * It also remembers the query in the inputs
     * and remembers the MySQL result in outputs
     * so that you can dump them out for debugging
     * purposes.
     */
    function query($q) {
        $result = $this->mysqli->query($q);
        $errno = $this->mysqli->errno;
        if ($errno != 0) {
            echo '<b>Error in SQL statement</b><br />';
            if ($this->debug) {
                echo $this->mysqli->errno.'<br/>';
                $this->errors[$this->counter]['num'] = $errno;
                $this->errors[$this->counter]['description'] = $this->mysqli->error;
            }
        }
        if ($this->debug) {
            $this->output = array_merge($this->output, array($result));
            $this->input  = array_merge($this->input,  array($q));
            $this->counter++;
        }
        return $result;
    }

    /* Echos a string of all the queries called so far */
    function dump_input() {
        if (! $this->debug) {
            die("dump_input error: debug not enabled");
        }
        $s = '';
        for ($i = 0; $i < count($this->input); $i++) {
            $query = $this->input[$i];
            $query = nl2br(htmlspecialchars($query));
            $query = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $query);
            $s .= 'Query #'.($i + 1);
            $s .= $query;

            if ($this->errors[$i]['num'] != 0) {
                $s .= 'ERROR '.$this->errors[$i]['num'].':';
                $s .= htmlspecialchars($this->errors[$i]['description']);
            }
            //$s .= '<br />';
        }
        echo $s;
        if ($this->counter == 1) $plural = 'y was';
        else $plural = 'ies were';
        //echo '<p>A total of <b>'.$this->counter.'</b> quer'.$plural.' made.</p>';
    }

    function get_link() {
        return $this->mysqli;
    }

}

?>
