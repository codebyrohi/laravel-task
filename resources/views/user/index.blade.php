@extends('layout.master') @section('main_content') 
<style type="text/css">
  .pointer{
    cursor: pointer;
  }
</style>
  @include('user.create')
  <div class="container mt-5">
    <h2 class="mb-4">Users List</h2>
    <table id="usersList" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email </th>
                <th>Mobile No </th>
            </tr>
        </thead>
    </table>
</div>
 @include('layout._operation_status') <script>
$(document).ready(function() {
  $("#usersList").DataTable({
       dom: 'Bfrtip',
        ajax: {
            url: "{{ $module_url_path}}/load_data",
        },
        processing: true,
        serverSide: true,
        columns: [ 
        {data:"id",orderable: false,searchable: true,name: "id"}, 
        {data:"image",orderable: false,searchable: true,name: "image"}, 
        {data:"name",orderable: false,searchable: true,name: "name"}, 
        {data:"email",orderable: false,searchable: true,name: "email"}, 
        {data:"mobile_no",orderable: false,searchable: true,name: "mobile_no"}, 
        ],
         buttons: [],
    });

});


</script> @endsection