<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($code_transaction)
    {
        $products = Product::all();
        $transactions = Transaction::select('transactions.*','products.*','transactions.id as transaction_id')
                        ->join('products','products.id','=','transactions.product_id')
                        ->where('transactions.code_transaction', $code_transaction)->get();
        return view('admin.transaction', compact('products','transactions'));
    }

    public function add_qty($transaction_id){
        $transaction = Transaction::where('id',$transaction_id)->first();
        $product = Product::where('id',$transaction->product_id)->first();

        $update_stock_product = Product::where('id', $transaction->product_id)
                                  ->update(['stock' => Product::raw('stock-1')]);

        $update_qty_transaction = Transaction::where('id', $transaction->id)
                                  ->update(['qty' => Transaction::raw('qty+1'),
                                            'total_price' => Transaction::raw("total_price + $product->price")
                                ]);
        return redirect('transaction/'. $transaction->code_transaction);
    }

    public function minus_qty($transaction_id){
            $transaction = Transaction::where('id',$transaction_id)->first();
        if($transaction->qty == 1){
          echo '<script> alert("Cannot min below 1 qty!")
                         window.location.href = "'.route("transaction", $transaction->code_transaction).'";
                </script>';
        } else {
            $product = Product::where('id',$transaction->product_id)->first();

            $update_stock_product = Product::where('id', $transaction->product_id)
                                    ->update(['stock' => Product::raw('stock+1')]);

            $update_qty_transaction = Transaction::where('id', $transaction->id)
                                    ->update(['qty' => Transaction::raw('qty-1'),
                                                'total_price' => Transaction::raw("total_price - $product->price")
                                    ]);
            return redirect('transaction/'. $transaction->code_transaction);
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();

        $transaction = new Transaction;
        $transaction->user_id = $request->user_id;
        $transaction->code_transaction = $request->code_transaction;
        $transaction->product_id = $request->product_id;
        $transaction->qty = $request->qty;
        $transaction->total_price = $product->price * $request->qty;
        $transaction->save();

        return redirect('transaction/'. $request->code_transaction);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function struk($code_transaction){
        $transactions = Transaction::select('transactions.*','products.*','transactions.id as transaction_id')
                        ->join('products','products.id','=','transactions.product_id')
                        ->where('transactions.code_transaction', $code_transaction)->get();

        $transactionDetails = TransactionDetail::where('code_transaction', $code_transaction)->first();
        return view('admin.struk', compact('transactions','transactionDetails'));
    }

    public function save_transaction(Request $request){
        TransactionDetail::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data Transaction has Been Saved!',
        ]);
    }

    public function delete($transaction_id){
        $transaction = Transaction::where('id',$transaction_id)->first();

        $update_stock_product = Product::where('id', $transaction->product_id)
                                  ->update(['stock' => Product::raw("stock + $transaction->qty")]);

        Transaction::where('id',$transaction->id)->delete();

        return redirect('transaction/'. $transaction->code_transaction);
    }
}