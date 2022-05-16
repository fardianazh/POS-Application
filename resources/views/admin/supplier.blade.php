@extends('layouts.admin')
@section ('header', 'Supplier')

@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-12">
            <div class="card">
            @hasanyrole('Super Admin|Manager')
                <div class="card-header">
                    <a href="#" @click="addData()" data-target="#modal-default" data-toggle="modal" class="btn btn-sm btn-primary pull-right">Create New Supplier</a>
                </div>
                @endhasanyrole
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="datatable" class="table table-stripted table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 80px">No.</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" :action="actionUrl" autocomplete="off" @submit="submitForm($event, data.id)">
                    <div class="modal-header">

                        <h4 class="modal-title">Supplier</h4>
    
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <input type="hidden" name="_method" value="PUT" v-if="editStatus">

                        <div class="form-group">
                            <label>Name</label>
                            <input placeholder="Supplier Name" type="text" class="form-control" name="name" :value="data.name" required="">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input placeholder="Jl. xxx" type="text" class="form-control" name="address" :value="data.address" required="">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input placeholder="Description of Supplier Products" type="text" class="form-control" name="description" :value="data.description" required="">
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-default">Save Changes</button>
                        </div>
                </form>
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
      var actionUrl = '{{ url('supplier') }}';
      var apiUrl = '{{ url('api/supplier') }}';

      var columns = [
      {data: 'DT_RowIndex', class: 'text-center', orderable: true},
      {data: 'name', class: 'text-center', orderable: true},
      {data: 'address', class: 'text-center', orderable: true},
      {data: 'description', class: 'text-center', orderable: true},
      {render: function (index, row, data, meta){
        return `
        @hasanyrole('Super Admin|Manager')
        <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">
        Edit
        </a>
        <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">
        Delete
        </a>
        @else
        <b>Dont Have Permission
        @endhasanyrole`;
          }, orderable: false, width: '200px', class: 'text-center'},
    ];
</script>
<script type="text/javascript">
    var controller = new Vue({
    el: '#controller',
    data: {
      datas: [],
      data: {},
      actionUrl,
      apiUrl,
      editStatus: false,
    },
    mounted: function(){
      this.datatable();
    },
    methods: {
      datatable() {
        const _this = this;
        _this.table = $('#datatable').DataTable({
          ajax: {
            url: _this.apiUrl,
            type: 'GET',
          },
          columns
        }).on('xhr', function() {
          _this.datas = _this.table.ajax.json().data;
        });
      },
      addData() {
      this.data = {};
      this.editStatus = false;
        $('#modal-default').modal();
     },
     editData(event, row) {
        this.data = this.datas[row];
        this.editStatus = true;
        $('#modal-default').modal();
     },
     deleteData(event, id) {
        if (confirm("Are you sure?")) {
          $(event.target).parents('tr').remove();
          axios.post(this.actionUrl+'/'+id, {_method: 'DELETE'}).then(response =>{
            alert('Data has been removed');
          });
        }
     },
     submitForm(event, id){
       event.preventDefault();
       const _this = this;
       var actionUrl = ! this.editStatus ? this.actionUrl : this.actionUrl+'/'+id;
       axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
         $('#modal-default').modal('hide');
         _this.table.ajax.reload();
       });
     },
   }
  });
  </script>
@endsection