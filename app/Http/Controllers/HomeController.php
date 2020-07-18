<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Book;
use App\Library;
use App\Transaction;

use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /*** Area for adding CSS ***/
        $this->fragment['site']['css'] = [
            "text/css,stylesheet,".url("plugins/sweetalert2/dist/sweetalert2.min.css"),
        ];
        /*** Area for adding JS ***/
        $this->fragment['site']['js'] = [
            url("plugins/sweetalert2/dist/sweetalert2.min.js"),
            url("js/home.js"),
        ];

        $library_join  = DB::table('transactions')
                ->select('transactions.id', "transactions.library_id", "transactions.book_id", "books.name")
                ->join('books', 'books.id', '=', 'transactions.book_id')
                ->get();
        // echo "<pre>" , var_dump($library_join);exit();
        $this->fragment['data_book']    = Book::all();
        $this->fragment['data_library'] = Library::all();
        $this->fragment['data_trans']   = $library_join;

        return view('home', $this->fragment);
    }

    public function save(Request $req){
        $book_id        = $req->input('name');
        $type           = $req->input('type');
        $library_id     = $req->input('id');
        $trans_id       = $req->input('id_trans');

        if ( empty($book_id) ){$response['msg'] = "Please Input Book Name."; return json_encode($response);exit;}

        $type = ($type == "update") ? "update" : "new";
        if ( $type == "update" ){
            if ( empty($trans_id) ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
            $trans = Transaction::find($trans_id);
            if ( !$trans ) {$this->response['msg'] = "Book not found.";echo json_encode($this->response);exit;}

        }else{
            $trans = new Transaction;
            $trans->library_id = $library_id;
        }

        $trans->book_id = $book_id;
        $trans->save();
        /*** Result Area ***/
        $response['type'] = 'done';
        $response['msg'] = ($type == "update") ? "Successfully to update data." : "Successfully to insert data.";
        return json_encode($response);exit;
    }

    public function detail(Request $req){
        $key = $req->input('key');
        if( empty($key) ){$response['msg'] = "Error parameters"; return json_encode($response);exit;}

        $book = Book::find($key);
        if ( !$book ) {$this->response['msg'] = "Book not found.";echo json_encode($this->response);exit;}

        $response['type']   = 'done';
        $response['msg']    = $book;
        echo json_encode($response);exit;
    }

    public function delete(Request $req){
        $key = $req->input('key');
        if( empty($key) ){$response['msg'] = "Error parameters"; return json_encode($response);exit;}

        $trans = Transaction::find($key);
        if ( !$trans ) {$this->response['msg'] = "Book not found.";echo json_encode($this->response);exit;}

        $trans->delete();

        $response['type']   = 'done';
        $response['msg'] = "Successfully to delete data.";
        echo json_encode($response);exit;

    }
}
