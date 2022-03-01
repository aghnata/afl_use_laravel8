@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Setting Shop</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Setting Content</a></li>
          <li class="breadcrumb-item active">Shop</li>
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
         <div class="card-header">
             <a href="#" data-toggle="modal" data-target="#formInputCreate">
               <button type="button" class="btn btn-success"><i class="fa fa-plus" ></i> Add new transport</button>
             </a>
             <br><br>
             <h5 class="card-title">List Transport</h5>
           </div>
           <div class="card-body">
             <table id="donations" class="table table-bordered table-striped">
                 <thead>
                     <tr class="bg-success">
                         <th scope="col">No</th>
                         <th scope="col">Location</th>
                         <th scope="col">Cost</th>
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
                         <td> {{$dt->place_name}} </td>
                         <td> {{ number_format($dt->cost) }} </td>
                         
                         {{-- <td> 
                           <a target="_blank" href="{{ $dt->no_whatsapp }}">
                             {{ str_replace('https://api.whatsapp.com/send?phone=', '', $dt->no_whatsapp) }} 
                           </a>
                         </td>
                         <td>
                           <a target="_blank" href="{{ url($dt->link_olshop) }}">
                             {{ $dt->link_olshop }} 
                           </a> 
                         </td> --}}
                         <td> 
                           <a href="#" data-toggle="modal" data-target="#formInputEdit">
                             {{-- <button value="{{$dt->id}}" class="btn btn-warning id_shop"
                               no_whatsapp="{{ str_replace('https://api.whatsapp.com/send?phone=', '', $dt->no_whatsapp) }}" 
                               link_olshop="{{ $dt->link_olshop }}" name_of_product="{{ $dt->name_of_product }}" >
                                 Edit
                             </button>  --}}
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
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    {{-- MODAL CREATE FORM --}}
     <div class="modal fade" id="formInputCreate">
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
     </div>

    {{-- MODAL EDIT FORM --}}
     <div class="modal fade" id="formInputEdit">
         <div class="modal-dialog modal-lg">
           <div class="modal-content">       
               <div class="modal-body">
                   <div class="card card-warning">
                       <div class="card-header">
                           <h3 id="form_title" class="card-title">Edit Shop</h3>
                       </div>
                       
                       <!-- form start -->
                       <form enctype="multipart/form-data" role="form" method="POST"
                         action="{{url('/admin-cms/content_management/shop')}}">
                           {{ method_field('put') }}
                           @csrf
                           <input hidden id="id_shop" name="id_shop" >
                           <div class="card-body">
                               <div class="form-group">
                                   <label>Nama Product</label>
                                   <input required type="text" class="form-control" 
                                   id="name_of_product_edit" name="name_of_product" value="">
                                   <br>
                                   <label>Upload Gambar Shop</label><br>
                                   <input type="file" name="image">
                                   <br><br>
                                   <label>No Whatsapp (angka nol pertama diganti dengan +62, <b> contoh: +6281122233212 </b>)</label>
                                   <input required type="text" class="form-control" name="no_whatsapp" 
                                   id="no_whatsapp_edit" value=""
                                   onkeyup="this.value=this.value.replace(/[^0-9\+]+/g, '')">
                                   <br>
                                   <label>Link Olshop (link harus diawali dengan "http atau https, contoh: https://afledu.com")</label>
                                   <input required type="text" class="form-control" 
                                   id="link_olshop_edit" name="link_olshop" value="">
                                   <br>
                               </div>
                           </div>
                           <div class="card-footer">
                               <button onclick="confirmForm('#no_whatsapp_edit', '#link_olshop_edit', '#real_add_edit')" type="button" class="btn btn-warning">Update</button>
                               <button hidden type="submit" id="real_add_edit">Real Add</button>
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

@push('name')
    
@endpush