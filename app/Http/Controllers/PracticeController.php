<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class PracticeController extends Controller {
    

        public function practiceX()
    {
        # Instantiate a new Book Model object
        $book = new Book();

        # Set the properties
        # Note how each property corresponds to a field in the table
        $book->title = 'Harry Potter and the Sorcerer\'s Stone';
        $book->author = 'J.K. Rowling';
        $book->published_year = 1997;
        $book->cover_url = 'http://prodimage.images-bn.com/pimages/9780590353427_p0_v1_s484x700.jpg';
        $book->purchase_url = 'http://www.barnesandnoble.com/w/harry-potter-and-the-sorcerers-stone-j-k-rowling/1100036321?ean=9780590353427';

        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data
        $book->save();

        dump('Added: '.$book->title);
    }
    
    public function practice14(){
        $results = Book::where('author','LIKE','%Rowling%')->get();
        
        foreach( $results as $book ){
            dump($book->title . " : " . $book->author);
            $book->delete();
        }
        dump('done with practice14()');
    }
    
    public function practice13() {
        $results = Book::where('author','=','J.K. Rowling')->get();
        foreach($results as $book){
            dump($book->title . " | " . $book->author);
            
            //change author of book
            $auth = 'JK Rowling';
            $book->author = $auth;
            
            //save the changes
            $book->save();
        }
        dump('done with practice13()');
    }
    
    public function practice12(){
        $results = Book::orderBy('published_year', 'desc')->get();
        foreach($results as $book){
            dump($book->published_year . " : " . $book->title . " : " . $book->author);
        }
        dump('done with practice12()');
    }
    
    public function practice11(){
        $results = Book::orderBy('title')->get();
        foreach($results as $book){
            dump($book->title);
        }
        dump('done with practice11()');
    }
    
    public function practice10(){
        $results = Book::where('published_year', '>', '1950')->get();
        foreach($results as $book){
            dump($book->title);
        }
        dump('done with practice10');
    }
    
    public function practice9(){
        $results = Book::orderBy('updated_at','desc')->limit(2)->get();
        foreach($results as $book){
            dump($book->title);
        }
        dump('done with practice9');
    }
    
    public function practice6() {
        $results = Book::where('author','=','J.K. Rowling')->get();
        foreach($results as $book){
            dump($book->title);
        }
        dump('done with practice6');
    }
    
    public function practice5() {
        $books = Book::where('author','=', 'Dr. Seuss')->get();
        foreach($books as $book){
            dump($book->title);
        }
        $books->delete();
        dump('book deleted');
    }
    
    public function practice4(){
        $book = new Book();
        $books = $book->where('title','LIKE','%Harry Potter%')->get();
        dump('title like Harry Potter');
        
        if($books->isEmpty()){
            dump('No matches found');
        } else {
            foreach ($books as $book){
                dump($book->title);
            }
        }
    }

    /**
     *
     */
    public function practice3() {
        $book = new Book();
        $books = $book->where('published_year','>',1950)->get();
        dump('published year > 1950');
        
        if($books->isEmpty()){
            dump('No matches found');
        } else {
            foreach ($books as $book){
                dump($book->title);
            }
        }
    }

    /**
     *
     */
    public function practice2() {
        return 'Need help? Email us at ' . config('mail.supportEmail');
    }

    /**
     * Demonstrating the first practice example
     */
    public function practice1() {
        dump('This is the first example.');
    }

    /**
     * ANY (GET/POST/PUT/DELETE)
     * /practice/{n?}
     * This method accepts all requests to /practice/ and
     * invokes the appropriate method.
     * http://foobooks.loc/practice => Shows a listing of all practice routes
     * http://foobooks.loc/practice/1 => Invokes practice1
     * http://foobooks.loc/practice/5 => Invokes practice5
     * http://foobooks.loc/practice/999 => 404 not found
     */
    public function index($n = null) {
        $methods = [];

# Load the requested `practiceN` method
        if (!is_null($n)) {
            $method = 'practice' . $n; # practice1
# Invoke the requested method if it exists; if not, throw a 404 error
            return (method_exists($this, $method)) ? $this->$method() : abort(404);
        } # If no `n` is specified, show index of all available methods
        else {
# Build an array of all methods in this class that start with `practice`
            foreach (get_class_methods($this) as $method) {
                if (strstr($method, 'practice')) {
                    $methods[] = $method;
                }
            }

# Load the view and pass it the array of methods
            return view('practice')->with(['methods' => $methods]);
        }
    }

}
