@extends('admin.layouts.app')
@section('title', 'Product')
@section('content')
    <div class="container mt-5">
        <h2 class="text-danger text-center">All Product List</h2>
        <div align="right" class="mb-3">
            <button class="btn btn-info" id="addBtn">Add Product</button>
        </div>
        <table class="table table-bordered data-table" id="product_table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Image</th>
                    <th width="20%" class="text-center">Action</th>
                </tr>
            </thead>
            
            <tbody>
            </tbody>
        </table>
        <div class="modal fade" id="productModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-muted"></h5>
                </div>
                <div class="modal-body">
                    <div id="form_result">

                    </div>
                    <form method="POST" id="product_form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="product_name">Product name:</label>
                            <input type="text" class="form-control" id="product_name" value="{{old('product_name')}}" name="product_name" placeholder="Product Name...">
                        </div>
                        <div class="form-group">
                            <label for="product_price">Product Price:</label>
                            <input type="text" class="form-control" id="product_price" value="{{old('product_price')}}" name="product_price" placeholder="Product Price...">
                        </div>
                        <div class="form-group">
                            <label for="category_name">Choose Category:</label>
                            <select name="category_name" id="category_name" class="form-control">
                                <option value="" selected disabled>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group old_image d-none">
                            <label for="product_image">Product current Image:</label><br>
                            <img alt="" height="100" width="100" id="old_image" name="old_image">
                        </div> 
                        <div class="form-group">
                            <label for="product_image">Product Image:</label><br>
                            <input type="file" id="product_image" name="product_image">
                        </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success saveBtn"></button>
                    <input type="hidden" id="hiddenID" >
                    <button type="button" class="btn btn-danger closeBtn" data-dismiss="modal">Close</button>
                </div>  
            </form>
            </div>
            
            </div>
            </div>
        </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $("#product_table").DataTable({
                processing : true,
                serverSide : true,
                ajax : "{{route('product.index')}}",
                columns  : [
                    {name : 'category_id', data : 'category_id'},
                    {name : 'product_name', data : 'product_name'},
                    {name : 'product_price', data : 'product_price'},
                    {name : 'image', data : 'image'},
                    {name : 'action', data : 'action', orderable : false},
                ]
            });

            $(document).on('click', '.delete', function(){
                let id = $(this).data('id');
                swal({
                        title: `Do you want to delete this record?`,
                        text: "If you delete this, it will be gone forever.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url : "/product/destroy/" + id,
                                success : function(data)
                                {
                                    if(data.success)
                                    {
                                        $("#product_table").DataTable().ajax.reload();
                                        swal({
                                            title: data.success,
                                            icon: "success",
                                            dangerMode: true,
                                        });
                                    }
                                }
                            });
                        }
                    });
            });

            $("#addBtn").click(function(){
                $("#productModal").modal('show');
                $("#category_name").val("");
                $("#hiddenID").val("");
                $(".saveBtn").text('Save');
                $(".modal-title").text('Add New Product');
                $(".old_image").addClass('d-none');
            });

            $("#product_form").on("submit", function(event){
                event.preventDefault();
                let hiddenID = $("#hiddenID").val();
                let url = "";
                if(hiddenID == "")
                {
                    url = "{{route('product.store')}}";
                }
                else {
                    url = "/product/update/" + hiddenID;
                }
                $.ajax({
                    url : url,
                    method : "POST",
                    data : new FormData(this),
                    dataType : "JSON",
                    contentType: false,
                    processData: false,
                    success : function(data)
                    {
                        let result = "";
                        if(data.errors)
                        {
                            result = "<div class='alert alert-danger'>";
                            for(let i = 0; i <data.errors.length; i++)
                            {
                               result += "<p>"+data.errors[i]+"</p>";
                            }
                            result += "</div>";
                        }
                        else
                        {
                            result = `<div class='alert alert-success'><p>${data.success}</p></div>`;
                             $("#category_table").DataTable().ajax.reload();
                             if(hiddenID == "")
                             {
                                $("#category_name").val("");
                                $("#product_name").val("");
                                $("#product_price").val("");
                             }
                             else{
                                $("#hiddenID").val("");
                                setTimeout(()=>{
                                    $("#productModal").modal('hide');
                                    $("#form_result").html("");
                                },1000);
                             }
                             $("#product_table").DataTable().ajax.reload();
                        }
                        $("#form_result").html(result);

                    }
                });
            });
            $(".closeBtn").click(function(){
                $("#form_result").html("");
                $("#hiddenID").val("");
            });
            $(document).on('click', '.edit', function(){
                let id = $(this).data('id');
                $(".old_image").removeClass('d-none');
                $(".saveBtn").text('Update');
                $("#hiddenID").val(id);
                
                            $.ajax({
                                url : "/product/"+ id + "/edit",
                                success : function(data)
                                {
                                    $("#productModal").modal('show');
                                    $("#category_name").val(data.category_id);
                                    $("#product_name").val(data.product_name);
                                    $("#product_price").val(data.product_price);
                                    $("#old_image").attr('src', data.product_image);
                                    $(".saveBtn").text('Update');
                                    $(".modal-title").text('Update Product');
                                }
                            });                      
                    });
        });
    </script>
@endpush