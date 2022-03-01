@extends('layouts.main')

@section('style')
<link rel="stylesheet" href="{{asset('plugins/datatables/jquery.dataTables.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables/jquery.dataTables_themeroller.css')}}">

@endsection

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Setting User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Setting User</a></li>
            <li class="breadcrumb-item active">Data Aflee</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
           {{-- <div class="card-header">
               <a href="#" data-toggle="modal" data-target="#formInputCreate">
                 <button type="button" class="btn btn-success"><i class="fa fa-plus" ></i> Add new transport</button>
               </a>
               <br><br>
               <h5 class="card-title">List Aflee</h5>
            </div> --}}

             <table id="donations" class="table table-bordered table-striped">
                 <thead>
                     <tr class="bg-success">
                         <th scope="col">No</th>
                         <th scope="col">Nama Siswa</th>
                         <th scope="col">WA Orangtua</th>
                         <th scope="col">Action</th>
                         <th></th>
                     </tr>
                 </thead>
                 <tbody>
                   @php
                       $no = 1;
                   @endphp
                   @foreach ($data as $dt)
                     <tr>
                         <td> {{$no++}} </td>
                         <td> {{$dt->aflee_name}} </td>
                         <td> 
                             <a target="_blank" href="{{'https://api.whatsapp.com/send?phone='.$dt->parent_wa_number}}">
                                 {{ $dt->parent_wa_number }} 
                             </a>
                         </td>
                         
                        
                         <td> 
                           <a href="#" data-toggle="modal" data-target="#formInputEdit">
                             <button value="{{$dt->id}}" class="btn btn-warning id_shop"
                                parent_wa_number="{{ $dt->parent_wa_number }}" 
                                aflee_name="{{ $dt->aflee_name }}" 
                               >
                                 Edit
                             </button> 
                           </a>
                         </td>
                         <td>
                             <form method="POST" action=" {{ url('/admin-cms/content_management/shop')}} ">
                                 @csrf
                                 {{ method_field('delete') }}
                                 <input hidden name="id" value="{{ $dt->id }}">
                                 <button class="btn btn-danger" onclick="return confirm(&quot;Anda yakin akan menghapus shop ini?&quot;)">
                                     Delete
                                 </button>
                             </form>
                         </td>
                     </tr>
                   @endforeach
                 </tbody>
             </table>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  
      {{-- MODAL CREATE FORM --}}
       {{-- <div class="modal fade" id="formInputCreate">
         <div class="modal-dialog modal-lg">
           <div class="modal-content">       
               <div class="modal-body">
                   <div class="card card-success">
                       <div class="card-header">
                           <h3 id="form_title" class="card-title">Create New Shop</h3>
                       </div>
                       
                       <!-- form start -->
                       <form enctype="multipart/form-data" role="form" method="POST"
                         action="{{url('/admin-cms/content_management/shop')}}">
                           @csrf
                           <div class="card-body">
                               <div class="form-group">
                                 <label>Nama Product</label>
                                 <input required type="text" class="form-control" 
                                  name="name_of_product">
                                 <br>
                                 <label>Upload Gambar Shop</label><br>
                                 <input required type="file" name="image">
                                 <br><br>
                                 <label>No Whatsapp (angka nol pertama diganti dengan +62, <b> contoh: +6281122233212 </b>)</label>
                                 <input required type="text" class="form-control" name="no_whatsapp" 
                                 id="no_whatsapp" onkeyup="this.value=this.value.replace(/[^0-9\+]+/g, '')">
                                 <br>
                                 <label>Link Olshop (link harus diawali dengan "http atau https, contoh: https://afledu.com")</label>
                                 <input required type="text" class="form-control" id="link_olshop" name="link_olshop" value="">
                                 <br>
                               </div>
                           </div>
                           <div class="card-footer">
                               <button onclick="confirmForm('#no_whatsapp', '#link_olshop', '#real_add')" type="button" class="btn btn-success">Add</button>
                               <button hidden type="submit" id="real_add">Real Add</button>
                               <button type="button" class="btn btn-default float-right" data-dismiss="modal">Cancel</button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
           <!-- /.modal-content -->
         </div>
           <!-- /.modal-dialog -->
       </div> --}}
  
      {{-- MODAL EDIT FORM --}}
       <div class="modal fade" id="formInputEdit">
           <div class="modal-dialog modal-lg">
             <div class="modal-content">       
                 <div class="modal-body">
                     <div class="card card-warning">
                         <div class="card-header">
                             <h3 id="form_title" class="card-title">Edit Aflee</h3>
                         </div>
                         
                         <!-- form start -->
                         <form enctype="multipart/form-data" role="form" method="POST"
                           action="{{url('/update-aflee')}}">
                             {{ method_field('put') }}
                             @csrf
                             <input hidden id="aflee_id" name="aflee_id" >
                             <div class="card-body">
                                 <div class="form-group">
                                     <label>Nama Aflee</label>
                                     <input required type="text" class="form-control" 
                                     id="aflee_name" name="aflee_name" value="">
                                     <br>
                                     
                                     <label>No Whatsapp (angka nol pertama diganti dengan +62, <b> contoh: +6281122233212 </b>)</label>
                                     <input required type="text" class="form-control" name="parent_wa_number" 
                                     id="parent_wa_number" value=""
                                     onkeyup="this.value=this.value.replace(/[^0-9\+]+/g, '')">
                                     <br>
                                     
                                     <br>
                                 </div>
                             </div>
                             <div class="card-footer">
                                <button type="submit" class="btn btn-warning">Update</button>
                                {{-- <button onclick="confirmForm('#no_whatsapp_edit', '#link_olshop_edit', '#real_add_edit')" type="button" class="btn btn-warning">Update</button>
                                 <button hidden type="submit" id="real_add_edit">Real Add</button> --}}
                                 <button type="button" class="btn btn-default float-right" data-dismiss="modal">Cancel</button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
             <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
       </div>
  
  
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->

@endsection

@push('script')
<!-- datatable -->
<script src="{{url('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{url('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
{{-- <script src='{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}'></script> --}}

<script>
    $(function () {
      $("#donations").DataTable({
         //  "order": [[ 1, "asc" ]]
      });
    });
</script>

<script>
    $('.id_shop').click(function(e){
    console.log(e.target.value)
      $('#aflee_id').val(e.target.value);
      $('#aflee_name').attr('value', e.target.getAttribute("aflee_name") );
      $('#parent_wa_number').attr('value', e.target.getAttribute("parent_wa_number") );
    });
</script>


    
@endpush