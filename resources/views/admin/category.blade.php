@extends('admin.layouts.app')
@section('title', 'Category')
@section('content')
    <div class="container mt-5">
        <h2 class="text-danger text-center">All Category List</h2>
        <div align="right" class="mb-3">
            <button class="btn btn-info" data-toggle="modal" id="addBtn">Add Category</button>
        </div>
        <table class="table table-bordered data-table" id="category_table">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th width="20%" class="text-center">Action</th>

                </tr>
            </thead>
            
            <tbody>
            </tbody>
        </table>
        <div class="modal fade" id="categoryModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-muted"></h5>
                </div>
                <div class="modal-body">
                    <div id="form_result">

                    </div>
                    <form method="POST" id="category_form">
                        @csrf
                        <div class="form-group">
                            <label for="category_name">Category Name:</label>
                            <input type="text" class="form-control" id="category_name" value="{{old('category_name')}}" name="category_name" placeholder="Category Name...">
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
            $("#category_table").DataTable({
                processing : true,
                serverSide : true,
                ajax : "{{route('category.index')}}",
                columns  : [
                    {name : 'id', data : 'id'},
                    {name : 'category_name', data : 'category_name'},
                    {name : 'action', data : 'action', orderable : false},
                ]
            });

            $(document).on('click', '.delete', function(){
                let id = $(this).data('id');
                swal({
                        title: `Do you want to delete this category?`,
                        text: "If you delete this, then will be remove all products under this category",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url : "/category/destroy/" + id,
                                success : function(data)
                                {
                                    if(data.success)
                                    {
                                        $("#category_table").DataTable().ajax.reload();
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
                $("#categoryModal").modal('show');
                $("#category_name").val("");
                $("#hiddenID").val("");
                $(".saveBtn").text('Save');
                $(".modal-title").text('Add New Category');
            });

            $("#category_form").on("submit", function(event){
                event.preventDefault();
                let hiddenID = $("#hiddenID").val();
                let url = "";
                if(hiddenID == "")
                {
                    url = "{{route('category.store')}}";
                }
                else {
                    url = "/category/update/" + hiddenID;
                }
                $.ajax({
                    url : url,
                    method : "POST",
                    data : $(this).serialize(),
                    dataType : "JSON",
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
                             }
                             else{
                                $("#hiddenID").val("");
                                setTimeout(()=>{
                                    $("#categoryModal").modal('hide');
                                    $("#form_result").html("");
                                },1000);
                             }
                             $("#category_table").DataTable().ajax.reload();
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
                $("#hiddenID").val(id);
                
                            $.ajax({
                                url : "/category/"+ id + "/edit",
                                success : function(data)
                                {
                                    $("#categoryModal").modal('show');
                                    $("#category_name").val(data.category_name);
                                    $(".saveBtn").text('Update');
                                    $(".modal-title").text('Update Category');
                                }
                            });                      
                    });
        });
    </script>
@endpush