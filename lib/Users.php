<?php
   
    class Users {
        private static $filename = '../authentication/users.txt';
		private static $user = null;
        private $attributes = array('id' => 0, 'username' => '', 'password' => '');
        private static $history_id = null;
        
        public function __construct($data = null) {
            if ($data) {
                $this->id = $data['id'];
                $this->username = $data['username'];
                $this->password = $data['password'];
            }
        }   // end of constructor function

        public function open($user) {
            $file = fopen( self::$filename, "r");
            if ($file) {
                while ( ! feof( $file )) {
                    $fields = fgetcsv ($file, 999, "~");
                    if ( count( $fields) > 0 ) {
                        
                        /*object creation*/
                        $userData = new Users(array('id'=>$fields[0], 'username'=>$fields[1], 'password'=>$fields[2]));
        
                        $user[$userData->id] = $userData;                      
                    } else {
                        echo "Your file is empty!";          
                        exit;
                    }
                }
                array_pop($user);
                fclose($file);
            } else {
                echo "There was a fatal error opening your file!";
                exit;
            }
            
            return $user;  
        }  // end of open function

        public static function all( ) {
            
			if( self::$user != null ) {
                return self::$user;
                
			} else {
				$lines = file( self::$filename );
                
				foreach( $lines as $record ) {
                    $fields = explode( "~", trim($record) );
					$added = new Users( array( 'id'=>$fields[0], 'username'=>$fields[1], 'password'=>$fields[2] ) );
                    self::$user[$added->id] = $added;
                    
				}		
				return self::$user;
			}
		} // end of all function

        public function append($user, $last_id) {   //function for new user creation
            $file = fopen( self::$filename, "a");
            if($file) {
                array_pop($user);
                $output = ++$last_id . "~" . $_POST['username'] . "~" . $_POST['password'] . "\n";
                fwrite($file, $output);
                fclose($file);
                Flash::set_notice("New user created!");
                header( "location: addUser.php" );
                exit;
                
            } else {
                echo "Could not create new user!";
            }
        }  //end of append function

        public function remove($user) {   
            unset( $user[$_GET['id']]);  //deletes id from array
            
             $file = fopen ( self::$filename, "w");   //writing new array back to file
             if ($file) {
                 //array_pop($user);
                 foreach ($user as $foo) {
                     $output = $foo->id . "~" . $foo->username . "~" . $foo->password . "\n";
         
                     fwrite ($file, $output);
                 }
                 fclose ($file);
                 
                 header ("location: addUser.php");
                 exit;
             }
        }  // end of remove function      
      
    } //end of class

?>