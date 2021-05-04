THE BOOKS API


1. Import the "books.sql" file to mysql database
2. Import the 'books postman collection' file to Postman


=========================== Create Endpoint ===================

URL: http://localhost/books-api/api/v1/Books.php?action=create

Enter the data (preferrably as raw data ) to Postman and send




=========================== Read  Endpoint ===================

URL: http://localhost/books-api/api/v1/Books.php?action=read

Enter the desired filter as raw data and hit send.
In the absence of data sent it will select all records from the db.





=========================== Update Endpoint ===================

URL: http://localhost/books-api/api/v1/Books.php?action=update&id={id}

Enter the required value to be altered in raw format




=========================== Delete Endpoint ===================

URL: http://localhost/books-api/api/v1/Books.php?action=delete&id={id}

Enter the id to be removed as part of query params





=========================== Show Endpoint ===================

URL: http://localhost/books-api/api/v1/Books.php?action=show&id={id}

Enter the id to be shown as part of query params




========================== External API endpoint =======================

URL: http://localhost/books-api/api/v1/Books.php?action=get_external_book&name={book}

Enter the name of book to be queried under the name param