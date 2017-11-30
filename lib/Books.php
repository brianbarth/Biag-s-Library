<?php 

    class Books {

        private static $filename = 'assets/bookData.txt';
		private static $info = null;
        private $attributes = array('id' => 0, 'title' => '', 'author' => '', 'publisher' => '', 'ISBN' => '');
        private $errors = array();
        public function __construct($data = null) {
            if ($data) {
                $this->id = $data['id'];
                $this->title = $data['title'];
                $this->author = $data['author'];
                $this->publisher = $data['publisher'];
                $this->ISBN = $data['ISBN'];
            }
        }

        public static function all( ) {
            
			if( self::$info != null ) {
                return self::$info;
                
			} else {
				$lines = file( self::$filename );
                
				foreach( $lines as $record ) {
                    $fields = explode( "~", trim($record) );
					$book = new Books( array( 'id'=>$fields[0], 'title'=>$fields[1], 'author'=>$fields[2], 'publisher'=>$fields[3], 'ISBN'=>$fields[4] ) );
                    self::$info[$book->id] = $book;
                    
				}		
				return self::$info;
			}
		}

        public static function find( $id ) {
            
            $editData = self::all( );
            
			if( isset( $editData[$id] ) ) {
               

                return $editData[$id];
			} else {
				return false;
			}		
        }

        public static function save_all( ) {
			$file = fopen( self::$filename, 'w' );
			if( $file ) {
				
				foreach( self::$info as $foo ) {
					fwrite( $file, $foo );
				}
				
				fclose( $file );
				
				return true;
				
			} else {
				return false;
			}
		}
        
        public function update( $data ) {
			$this->title = $data['title'];
			$this->author = $data['author'];
			$this->publisher = $data['publisher'];
			$this->ISBN = $data['ISBN'];
			
			$info = self::all( );
			
			return self::save_all( );		
        }
        

        public function __set ($name, $value) {
            $this->attributes[$name] = $value;
        }
        
        public function __get ($name) {
            return $this->attributes[$name];
        }

        public function __toString( ) {
			return $this->id . "~" . $this->title . "~" . $this->author . "~" 
													. $this->publisher . "~" . $this->ISBN . "\n";
        }
       
        public static function authenticate() {
            if ( ! self::loggedin() ) {
                Flash::set_alert("You must be logged in to access that page");
                header("location: authentication/login.php");
                exit;
            } //end of if statement
        } //end of authenticate function
        public static function loggedin() {
            return isset( $_SESSION['loggedin']) && $_SESSION['loggedin'] == true; 
        } //end loggedin function
        
        
        public function listBooks( $info ) {

            array_pop($info);
            $i = 1;
            foreach( $info as $book ) {
                
                echo '<tr>';
                echo '<td id="number">' .$i .'</td>';            
                echo '<td class="bookTitle"><a href="show.php?id=' . $book->id .'" >' . $book->title . '</a></td>';          
                if ( ! $book->title == "" ) {
                    if ( self::loggedin() ) {
                    echo   "<td class='edit'><span><a href='edit.php?id=$book->id'>EDIT</a></span></td>";
                    echo   "<td class='delete'><span><a href='delete.php?id=$book->id'>DEL</a></span></td>";
                    } //end of logged in validation for edit and delete display
                } //end of if statement to hide edit and delete if array item is blank
                echo '</tr>';
                $i++;
            }   //end of foreach loop   
        } //end of listBooks function

        public function validate($data) {
            
            if (empty($data['title'])) {
                $errors['title'] = "Title cannot be left blank!";
            }
            if (empty($data['author'])) {
                $errors['author'] = "Author cannot be left blank!";
            }
            if (empty($data['publisher'])) {
                $errors['publisher'] = "Publisher cannot be left blank!";
            }
            if (empty($data['ISBN'])) {
                $errors['ISBN'] = "ISBN cannot be left blank!";
            }
            
            return $errors;

        }   //end of validate array

        public function append($info, $last_id) {   //function for new book creation
            $file = fopen( self::$filename, 'a');
            if($file) {
                array_pop($info);
                $output = ++$last_id . "~" . $_POST['title'] . "~" . $_POST['author'] . "~" . $_POST['publisher'] . "~" . $_POST['ISBN'] . "\n";
                fwrite($file, $output);
                fclose($file);

                header( "location: show.php?id=" . $last_id );
                exit;
                
            } else {
                echo "Could not write new information to file!";
            }
        }  //end of append function

        public function remove($info) {   
            unset( $info[$_GET['id']]);  //deletes id from array
            
             $file = fopen ( self::$filename, "w");   //writing new array back to file
             if ($file) {
                 array_pop($info);
                 foreach ($info as $foo) {
                     $output = $foo->id . "~" . $foo->title . "~" . $foo->author . "~" . $foo->publisher . "~" . $foo->ISBN . "\n";
         
                     fwrite ($file, $output);
                 }
                 fclose ($file);
                 
                 header ("location: index.php");
                 exit;
             }
        }  // end of remove function

        public function open($info) {
            $file = fopen( self::$filename, "r");
            if ($file) {
                while ( ! feof( $file )) {
                    $fields = fgetcsv ($file, 999, "~");
                    if ( count( $fields) > 0 ) {
                        
                        /*object creation*/
                        $assInfo = new Books(array('id'=>$fields[0], 'title'=>$fields[1], 'author'=>$fields[2], 'publisher'=>$fields[3], 'ISBN'=>$fields[4]));
        
                        $info[$assInfo->id] = $assInfo;                      
                    } else {
                        echo "Your file is empty!";          
                        exit;
                    }
                }
                fclose($file);
            } else {
                echo "There was a fatal error opening your file!";
                exit;
            } 
            return $info;  
        }  // end of open function

        public function form($errors, $bookR) {    
               
               if ( sizeof($errors) == 0 ) {
                    $id = $bookR->id;
                    $title = $bookR->title;
                    $author = $bookR->author;
                    $publisher = $bookR->publisher;
                    $ISBN = $bookR->ISBN;                    
                } else {     
                $title = isset($_POST['title']) ? $_POST['title'] : null;
                $author = isset($_POST['author']) ? $_POST['author'] : null;
                $publisher = isset($_POST['publisher']) ? $_POST['publisher'] : null;
                $ISBN = isset($_POST['ISBN']) ? $_POST['ISBN'] : null;
                }
                
           

                if ( isset( $errors['title'])) {
                    echo '<p class="eb">';
                } else {
                    echo '<p>';
                }
                    echo '<label for="title">TITLE: </label>';
                    echo "<input type='text' name='title' value='" . str_replace('\'', '&#39;', $title) . "' id='title'>";
                    echo '</p>';
            
                if ( isset( $errors['author'])) {
                    echo '<p class="eb">';
                } else {
                    echo '<p>';
                }
                    echo '<label for="author">AUTHOR: </label>'; 
                    echo "<input type='text' name='author' value='" . str_replace('\'', '&#39;', $author) . "' id='author'>";                
                    echo '</p>';
            
                if ( isset( $errors['publisher'])) {
                    echo '<p class="eb">';
                } else {
                    echo '<p>';
                }
                    echo '<label for="author">PUBLISHER: </label>'; 
                    echo "<input type='text' name='publisher' value='" . str_replace('\'', '&#39;', $publisher) . "' id='publisher'>";                
                    echo '</p>';
            
                if ( isset( $errors['ISBN'])) {
                    echo '<p class="eb">';
                } else {
                    echo '<p>';
                }
                    echo '<label for="author">ISBN: </label>'; 
                    echo "<input type='text' name='ISBN' value='" . str_replace('\'', '&#39;', $ISBN) . "' id='ISBN'>";               
                    echo '</p>';
              
                return $_POST;
        }  // end of form function

    } //end of class
?>