<?php
// connect to the db

class Books
{

    // properties
    protected $localhost ="localhost";
    protected $user = "root";
    protected $pass = "";
    protected $db = "books";
    protected $conn;

    private $b_name;
    private $action;
    private $authors;
    private $name;
    private $country;
    private $isbn;
    private $number_of_pages;
    private $publisher;
    private $release_date;
    private $data;
    private $query = '';
    private $book_item;
    private $result;
    private $id;

    public function __construct()
    {
        // params
        $this->name = isset($_REQUEST['name']) ? $_REQUEST['name'] : ' ';
        $this->data = json_decode(file_get_contents("php://input"));
        $this->id = isset($_REQUEST['id']) ? $_REQUEST['id'] : ' ';
        $this->action = isset($_REQUEST['action']) ? $_REQUEST['action'] : ' ';
        $this->b_name = isset($this->data->b_name) ? $this->data->b_name : ' ';
        $this->isbn = isset($this->data->isbn) ? $this->data->isbn : ' ';
        $this->publisher = isset($this->data->publisher) ? $this->data->publisher : ' ';
        $this->authors = isset($this->data->authors) ? $this->data->authors : ' ';
        $this->country = isset($this->data->country) ? $this->data->country : ' ';
        $this->number_of_pages = isset($this->data->number_of_pages) ? $this->data->number_of_pages : ' ';
        $this->publisher = isset($this->data->publisher) ? $this->data->publisher : ' ';
        $this->release_date = isset($this->data->release_date) ? $this->data->release_date : ' ';

        $this->conn = mysqli_connect($this->localhost, $this->user, $this->pass, $this->db);

        if ($this->conn) {
//echo "connection successfull";
        } else {
//echo "connection not successfull";
        }
    }




    public function process(){
     switch ($this->action){

               case 'get_external_book':


$ch = curl_init();

                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                   curl_setopt($ch, CURLOPT_URL,'https://www.anapioficeandfire.com/api/books?name='.urlencode($this->name));

                   $result=curl_exec($ch);

                   curl_close($ch);


$result = file_get_contents('https://www.anapioficeandfire.com/api/books?name='.urlencode($this->name));

$fin = json_decode($result, true);
if ($fin != null){
    //show item in json format
    $this->book_item = array(
        "status_code" => 200,
        'status' => 'success',
        'data' => array(
            'book' => array(
                "name" => $fin[0]['name'],
                "isbn" => $fin[0]['isbn'],
                "authors" => array(
                    $fin[0]['authors']
                ),
                "number_of_pages" => $fin[0]['numberOfPages'],
                "publisher" => $fin[0]['publisher'],
                "country" => $fin[0]['country'],
                "release_date" => $fin[0]['released']
            )
        )
    );

    array_push($this->book_item);


    echo json_encode(array($this->book_item));

}


else{
    $this->book_item = array(
        "status_code" => 200,
        'status' => 'success',
        'data' => array()
    );

    array_push($this->book_item);


    echo json_encode(array($this->book_item));
}
break;



               case 'create':

                   // queries
                   if (!$this->data) {
                       // set the response code to 404
                       http_response_code(404);

                       echo json_encode(array("message" => "Data missing or invalid"));
                   }

                   else {
                       //echo ($this->country);
                       $this->query = "INSERT INTO books(name,isbn, authors, release_date, number_of_pages, publisher, country) 
                          VALUES('$this->b_name', '$this->isbn', '$this->authors', '$this->release_date', '$this->number_of_pages','$this->publisher', '$this->country')";
                       mysqli_query($this->conn, $this->query);
                       if (mysqli_affected_rows($this->conn) > 0) {
                           // set response code to 200 -OK
                           http_response_code(201);

                           //show item in json format
                           $this->book_item = array(
                               'status' => 'success',
                               'data' => array(
                                   'book' => array(
                                       "name" => $this->b_name,
                                       "isbn" => $this->isbn,
                                       "authors" => array(
                                           $this->authors
                                       ),
                                       "number_of_pages" => $this->number_of_pages,
                                       "publisher" => $this->publisher,
                                       "country" => $this->country,
                                       "release_date" => $this->release_date
                                   )
                               )
                           );

                           array_push($this->book_item);


                           echo json_encode(array($this->book_item));
                       } else {
                           // set the response code to 404
                           http_response_code(404);

                           echo json_encode(array("message" => "Error creating the book"));
                       }
                   }
               break;



               case 'read':
               
                   $qry1 = '';
                   $qry2 = '';
                   $qry3 = '';
                   $qry4 = '';
                 
                   
                   

                   if(($this->b_name !=' ') && ($this->country ===' ') && ($this->publisher ===' ') && ($this->release_date ===' ')) {
                       $qry1 = " AND name = '$this->b_name' ";
                       $this->query = "SELECT * from books WHERE 1=1".$qry1;
                   }
                  elseif (($this->b_name ===' ') && ($this->country !=' ') && ($this->publisher ===' ') && ($this->release_date ===' ')) {
                    
                       $qry2 = " AND country = '$this->country' ";
                       $this->query = "SELECT * from books WHERE 1=1".$qry2;

                   }
                   elseif (($this->b_name ===' ') && ($this->country ===' ') && ($this->publisher !=' ') && ($this->release_date ===' ')) {

                       $qry3 = " AND publisher = '$this->publisher' ";
                       $this->query = "SELECT * from books WHERE 1=1".$qry3;
                   }
                  elseif (($this->b_name ===' ') && ($this->country ===' ') && ($this->publisher ===' ') && ($this->release_date !=' ')) {

                       $qry4 = " AND release_date = '$this->release_date' ";
                       $this->query = "SELECT * from books WHERE 1=1".$qry4;
                   }

                  else{
                    $this->query = "SELECT * from books WHERE 1=1" ;
                  } 
                
                   
                  //$this->query = "SELECT * from books WHERE 1=1" ;
                  

                  // echo $this->query;

                   $this->result = mysqli_query($this->conn, $this->query);
                   if(mysqli_num_rows($this->result) > 0){
                       // set response code to 200 -OK

                       http_response_code(200);
                       while($row = mysqli_fetch_array($this->result)){
                       //show item in json format
                           $this->book_item = array(
                               'status' =>'success',
                               'data' =>array(
                                   'book' => array(
                                       'id' => $row['id'],
                                       "name" => $row['name'],
                                       "isbn" => $row['isbn'],
                                       "authors" => array(
                                           $row['authors']
                                       ),
                                       "number_of_pages" => $row['number_of_pages'],
                                       "publisher" => $row['publisher'],
                                       "country" => $row['country'],
                                       "release_date" =>  $row['release_date']
                                   )
                               )
                           );

                           array_push($this->book_item);


                           echo json_encode(array($this->book_item));
                       }

                   }

                   else{
                       $this->book_item = array(
                       "status_code" => 200,
                       "status" => "success",
                       "data" => []
                   );
                       array_push($this->book_item);
                       echo json_encode(array($this->book_item));
                   }
                   break;




         case 'update':

             // queries
             if (!$this->data) {
                 // set the response code to 404
                 http_response_code(404);

                 echo json_encode(array("message" => "Data missing or invalid"));
             }

             else {
                // echo $this->name;


                   if(($this->b_name !=' ')) {
                      
                       $this->query = "UPDATE books SET name = '$this->b_name' where id='$this->id'";
                   }

                  elseif (($this->country !=' ')) {
                    
                     $this->query = "UPDATE books SET country = '$this->country' where id='$this->id'";

                   }

                   elseif (($this->publisher !=' ')) {

                      $this->query = "UPDATE books SET publisher = '$this->publisher' where id='$this->id'";
                   }

                  elseif (($this->release_date !=' ')) {

                      $this->query = "UPDATE books SET release_date = '$this->release_date' where id='$this->id'";
                   }

                    elseif (($this->isbn !=' ')){

                      $this->query = "UPDATE books SET isbn = '$this->isbn' where id='$this->id'";
                   }

                    elseif (($this->authors !=' ')) {

                      $this->query = $this->query = "UPDATE books SET authors = '$this->authors' where id='$this->id' ";
                   }

                    elseif (($this->number_of_pages !=' ')) {

                      $this->query = $this->query = "UPDATE books SET number_of_pages = '$this->number_of_pages' where id='$this->id'";
                   }

                  else{
                    $this->query = "SELECT * from books WHERE 1=1" ;
                  } 

        echo $this->query;

                    //die(); 

                 mysqli_query($this->conn, $this->query);
                 if (mysqli_affected_rows($this->conn) > 0) {
                     // set response code to 200 -OK
                     http_response_code(200);

                     //show item in json format
                     $this->book_item = array(
                         'status' => 'success',
                         'message'=> "The book My First Book was updated successfully",
                         'data' => array(
                             'book' => array(
                                 "id"   => $this->id,
                                 "name" => $this->b_name,
                                 "isbn" => $this->isbn,
                                 "authors" => array(
                                     $this->authors
                                 ),
                                 "number_of_pages" => $this->number_of_pages,
                                 "publisher" => $this->publisher,
                                 "country" => $this->country,
                                 "release_date" => $this->release_date
                             )
                         )
                     );

                     array_push($this->book_item);


                     echo json_encode(array($this->book_item));
                 } else {
                     // set the response code to 404
                     http_response_code(404);

                     echo json_encode(array("message" => "Error updating the book. This value already exists or the book is removed"));
                 }
             }
             break;





case 'delete':

if ($this->id === '') {
                 // set the response code to 404
                 http_response_code(404);

                 echo json_encode(array("message" => "Data missing or invalid"));
             }

             else {
              if($this->id !=' '){
                 $this->query = "DELETE from books where id = $this->id";


                mysqli_query($this->conn, $this->query);
                 if (mysqli_query($this->conn, $this->query)) {
                     // set response code to 200 -OK
                  //http_response_code(204);


                     //show item in json format
                     $this->book_item = array(
                         'status_code' => 204,
                         'status' => 'success',
                         'message'=> "The book My First Book was deleted successfully",
                         'data' => array(

                         )
                     );

                     array_push($this->book_item);


                     echo json_encode(array($this->book_item));
                 } 


              }
           
              }


break;




case 'show':

if ($this->id =='') {
                 // set the response code to 404
                 http_response_code(404);

                 echo json_encode(array("message" => "Data missing or invalid"));
             }

             else {
              if($this->id !=' '){
                 $this->query = "SELECT * from books where id = $this->id";
   //echo $this->id;

                $this->result = mysqli_query($this->conn, $this->query);
                   if(mysqli_num_rows($this->result) > 0){
                       // set response code to 200 -OK

                       http_response_code(200);
                       while($row = mysqli_fetch_array($this->result)){
                       //show item in json format
                           $this->book_item = array(
                               'status' =>'success',
                               'data' =>array(
                                   'book' => array(
                                       'id' => $row['id'],
                                       "name" => $row['name'],
                                       "isbn" => $row['isbn'],
                                       "authors" => array(
                                           $row['authors']
                                       ),
                                       "number_of_pages" => $row['number_of_pages'],
                                       "publisher" => $row['publisher'],
                                       "country" => $row['country'],
                                       "release_date" =>  $row['release_date']
                                   )
                               )
                           );

                           array_push($this->book_item);


                           echo json_encode(array($this->book_item));
                       }

                   }

                   else{
                       $this->book_item = array(
                       "status_code" => 200,
                       "status" => "success",
                       "data" => []
                   );
                       array_push($this->book_item);
                       echo json_encode(array($this->book_item));
                   }
}
break;




           }

       }

}

}

// instatitiate database object and users object
$books = new Books();
$books->process();
