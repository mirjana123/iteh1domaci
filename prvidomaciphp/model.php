<?php
    Class Model{
        private $server = "localhost";
        private $username = "root";
        private $password = "";
        private $db = "domacidb";
        private $conn; 

        public function __construct() 
        {
            try 
            { 
                $this-> conn = new PDO("mysql:host=$this->server;dbname=$this->db",$this->username,$this->password);    
            }
            catch(PDOException $e){ 
                echo "Connection failed!" . $e->getMessage();
            }
        }

        public function insert(){
            if(isset($_POST['submit'])){ // isset()  - vraca tacno ako je vrednost postavljena i razlicita od null
                if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['designer'])){
                    if(!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['designer'])){
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $designer = $_POST['designer'];
                        $designerID= null;
                        $stmt = $this -> conn -> prepare("SELECT designer_id from designer where designer='$designer'");
                        $stmt -> execute();
                        $designerID = $stmt ->fetch();
                        
                            if($designerID==null){
                                $query2 = "INSERT INTO designer (designer) VALUES ('$designer')";
                                $sql2=$this->conn->exec($query2);
                                $stmt = $this -> conn -> prepare("SELECT designer_id from designer where designer='$designer'");
                                $stmt -> execute();
                                $designerID = $stmt ->fetch();
                            }
                       
                        $query = "INSERT INTO records (title,description,designer_id) VALUES ('$title','$description','$designerID[0]')";
                            
                            if( $sql2=$this->conn->exec($query)){
                                echo 
                                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Parfume and designer  are successfully added to the database!
                                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                    </button>
                                    </div>';
                            } 
                            else{
                                    echo 
                                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Parfume is not added to the database!
                                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                                    </button>
                                    </div>';
                                }
                        }
                    else{
                        echo
                        '<br>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Empty fields are not allowed. 
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                        </button>
                        </div>';
                        }
                          
                    }
                else{
                    echo
                    '<br>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Empty fields are not allowed. 
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    </button>
                    </div>';
                }
            }
        }
               
            
        

        public function fetch(){
            $data = null;
            $stmt = $this->conn->prepare("SELECT * FROM records r JOIN designer a on (r.designer_id=a.designer_id)");
            $stmt -> execute();
            $data = $stmt->fetchAll();
            return $data;    
        }
          
        public function getRow($title_id){
            $data= null;

            $stmt = $this->conn->prepare("SELECT * FROM records WHERE id='$title_id'");
          
            $stmt->execute();
          
            $data = $stmt->fetch();
          
            return $data;
          }
        
          
        public function search(){
              $data= null;
              if(!empty($_POST['value'])){
              $title = $_POST['value'];
              } else $title="";
          
              //A prepared statement is a feature used to execute the same (or similar) SQL statements repeatedly with high efficiency.
              $stmt = $this->conn->prepare("SELECT * FROM records r join designer a on (a.designer_id=r.designer_id) WHERE r.id in (SELECT id from records WHERE title LIKE '%$title%')");
          
              $stmt->execute();
          
              $data = $stmt->fetchAll();
          
              return $data;
          }
        public function delete($del_id){
            $query = "DELETE FROM records where id='$del_id'";
            if($sql = $this ->conn->exec($query)){
                
                echo 
                    '<br>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Record is successfully deleted from the database!
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                    </button>
                    </div>';
            }else{
                echo 
                '<br>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                Record could not be deleted from the database!
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                </button>
                </div>';
               
            }
        }

        public function read($read_id){
            $data = null;
            $stmt = $this -> conn-> prepare("SELECT * FROM records where id='$read_id'");
            $stmt -> execute();
            $data = $stmt->fetch();
            return $data;
        }

        public function edit($edit_id){
            $data= null;
            $stmt = $this -> conn -> prepare("SELECT * FROM records WHERE id='$edit_id' ");
            $stmt -> execute();
            $data = $stmt ->fetch();
            return $data;
        }

        public function update($data){
            $query = "UPDATE records SET title='$data[edit_title]', description='$data[edit_description]' WHERE id='$data[edit_id]'";
            if($sql = $this->conn->exec($query))
            {
                echo '<br>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                Record is successfully updated!
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                </div>
            <script>$("#exampleModal1").modal("hide")<script>';
            
            }else{
                echo "<br>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                Record could not be updated!
                <button type='button' class='btn-close' data-dismiss='alert' aria-label='Close'></button>
            </div>";
            }
        }

        public function sort(){
            if(isset($_POST['sort_title'])){
                $data= null;
                $stmt = $this->conn->prepare("SELECT * FROM records r JOIN designer a on (a.designer_id=r.designer_id) ORDER BY title asc");
            
                $stmt->execute();
            
                $data = $stmt->fetchAll();
            
                return $data;
      
      
      
              }
        }
        
    }
?>