@extends('layouts.admin')
@section ('header', 'Transaction')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<div id="controller">
<div class="row">
        <div class="col-9">
            <div class="card">
              <div class="card-header">
                  <strong>No Invoice: </strong>{{ request()->segment(2) }}
              </div>
                <div class="card-body">
                    <table class="table table-stripted table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 80px">No.</th>
                                <th class="text-center">Name Product</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php
                            $no = 1;
                            $total_payment = 0;
                          @endphp
                          @foreach($transactions as $item)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ rupiah($item->product->price) }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ rupiah($item->total_price) }}</td>
                            <td>
                              <a href="{{ url('transaction/add_qty') }}/{{ $item->transaction_id }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i>
                              </a>
                              <a href="{{ url('transaction/minus_qty') }}/{{ $item->transaction_id }}" class="btn btn-warning text-white btn-sm">
                                <i class="fas fa-minus"></i>
                              </a>
                              <a href="{{ url('transaction/delete') }}/{{ $item->transaction_id }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                              </a>
                            </td>
                          </tr>
                          @php
                            $total_payment = $total_payment + $item->total_price;
                          @endphp
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <label for="date">Add Product</label>
            </div>
            <div class="card-body">
                <form action="{{ url('transaction') }}" method="post">
                  @csrf
                    <div class="row mb-3" hidden>
                        <label class="col-md-4 col-form-label text-md-end">Code</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="code_transaction" value="{{ request()->segment(2) }}">
                        </div>
                    </div>

                    <div class="row mb-3" hidden>
                        <label class="col-md-4 col-form-label text-md-end">User</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="user_id" value="{{ auth()->user()->id }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Name Product</label>
                        <div class="col-md-8">
                            <select name="product_id" class="form-control">
                                @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Qty</label>
                        <div class="col-md-8">
                            <input type="number" name="qty" value="1" min="1" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="nav-icon fa-solid fa-basket-shopping"></i> Add
                        </button>
                    </div>
                </form>

                <hr>
                    <label for="date">Payment</label>
                <hr>
                <form name="form-save-transaction">
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Total Price</label>
                        <div class="col-md-8">
                            <input type="hidden" name="" id="code_transaction" value="{{ request()->segment(2) }}">
                            <input type="text" name="" class="form-control" value="{{ rupiah($total_payment) }}" readonly>
                            <input type="hidden" name="total_payment" id="total_payment" value="{{ $total_payment }}">
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Payment</label>
                        <div class="col-md-8">
                            <input type="text" name="" id="payment" class="form-control" autocomplete="off" onkeyup="calculate()" required>
                            <input type="hidden" name="payment" id="payment1">
                        </div>
                    </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Change</label>
                        <div class="col-md-8">
                            <input type="text" name="" id="change" class="form-control" readonly>
                            <input type="hidden" name="change" id="change1" >
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-primary" id="btnSaveTransaction">
                            <i class="nav-icon fa-solid fa-basket-shopping"></i> Save Transaction
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript"> 
var urlStruk = '{{ url('transaction/struk/') }}';

function calculate(){
  let payment = $('#payment').val().split('.');
  let payment1 = $('#payment1').val(payment.join(""));

  let total_payment = $('#total_payment').val();
  let results = payment1.val() - total_payment;
  let convert = parseInt(results).toLocaleString("id-ID");

  $('#change').val(convert);
  $('#change1').val(results);
}

$(document).on('click', '#btnSaveTransaction', function(){
  let _token = $('meta[name="csrf-token"]').attr('content');
  let code_transaction = $('#code_transaction').val();
  let total_payment = $('#total_payment').val();
  let payment1 = $('#payment1').val();
  let change1 = $('#change1').val();

  $.ajax({
    url:'{{ url('transaction/save_transaction') }}',
    type: 'post',
    data: {
      _token: _token,
      code_transaction: code_transaction,
      total_payment: total_payment,
      payment: payment1,
      change: change1,
    },
    success: function(result){
      if (result.success == true){
        alert(result.message);
        window.open('/eduwork/bajuku/public/transaction/struk/' + code_transaction, '_blank');
        window.location.href = '/eduwork/bajuku/public/transaction/{{no_invoice()}}';
      }
    }
  });
});
</script>
@endsection