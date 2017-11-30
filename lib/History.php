<?php   
    class History {
        public function __construct($data = null) {
            if ($data) {
                $this->id = $data['id'];
                $this->username = $data['username'];
                $this->date = $data['date'];
            }
        }   // end of constructor function

        public function addHistory($date, $history_id) {
            if ( $_SESSION['addHistory'] = true ) {
                $file = fopen( "loginHistory.txt", "a");
                if($file) {
                    $output = ++$history_id . "~" . $_POST['username'] . "~" . $date . "\n";
                    fwrite($file, $output);
                    fclose($file);                 
                } else {
                    echo "Could not save history!";
                } 
            }
        }  // end of addHistory

        public function openHistory($history) {
            $file = fopen( "loginHistory.txt", "r");
            if ($file) {
                while ( ! feof( $file )) {
                    $fields = fgetcsv ($file, 999, "~");
                    if ( count( $fields) > 0 ) {
                        
                        /*object creation*/
                        $userData = new History(array( 'id'=>$fields[0], 'username'=>$fields[1], 'date'=>$fields[2] ));

                        $history[$userData->id] = $userData;                     
                    } else {
                        echo "Your file is empty!";          
                        exit;
                    }
                }
                fclose($file);
                array_pop($history);
                return $history;
            } else {
                echo "There was a fatal error opening your file!";
                exit;
            }
        }  // end of openHistory
    } // end of class
?>