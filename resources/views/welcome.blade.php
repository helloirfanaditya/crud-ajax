<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AJAX CRUD</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="text-center">AJAX CRUD</h5>
                    <button type="button" data-toggle="modal" data-target="#add" class="btn btn-primary">Add Data</button>
                    <hr>
                    <div class="ajax__load__table">
                        @include('load_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- add --}}
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-edit">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" name="name" id="add-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Email :</label>
                            <input class="form-control" name="email" id="add-email"></input>
                        </div>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary" id="button-add-data">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Update --}}
    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-edit">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" class="id">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Email :</label>
                            <input class="form-control" name="email" id="email"></input>
                        </div>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary" id="button-edit-data">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Create
            $('#button-add-data').on('click',function(e){
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url:'/',
                    method: 'POST',
                    data:{
                        'name': $('#add-name').val(),
                        'email': $('#add-email').val()
                    },
                    success:function(response){
                        if(response.code == 200) {
                            $('table tbody').prepend('<tr id="data_'+response.data.id+'"><td>'+response.data.name+'</td><td>'+response.data.email+'</td><td><button type="button" data-toggle="modal" data-target="#update" data-name="{{ '+response.data.name+' }}" data-email="{{ '+response.data.email+' }}" data-id="{{ '+response.data.id+' }}"data-attr="{{ route("update",["id" => '+response.data.id+']) }}" class="btn btn-warning btn-sm">Update</button></td><td><a href="javascript:void(0)" id="button-delete" class="btn btn-danger btn-sm">Delete</a></td>');
                        }
                    }
                });
            });

            // Load
            $('body').on('click', '.ajax__load__paginate .pagination li a', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                $.ajax({
                    url: url
                }).done(function (response) {
                    $('.ajax__load__table').html(response)
                })
                window.history.pushState('', '', url)
            });

            // Update
            $('#update').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var name = button.data('name')
                var email = button.data('email')
                var attr = button.data('attr')
                var modal = $(this)
                modal.find('.modal-title').text('Update ' + name)
                modal.find('#id').val(id)
                modal.find('#name').val(name)
                modal.find('#email').val(email)
                modal.find('.form-edit').attr('action',attr)
            })

            $('body').on('click','#button-edit-data',function(e){
                e.preventDefault();
                const id = $('.id').val();
                const url = "/update/"+id
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url:url,
                    method: 'POST',
                    data:{
                        'name': $('#name').val(),
                        'email': $('#email').val()
                    },
                    success:function(response){
                        if(response.code == 200) {
                          $("#data_"+id+" td:nth-child(1)").html(response.name)
                          $("#data_"+id+" td:nth-child(2)").html(response.email)
                        }
                    }
                });
            });

            // Delete
            $('body').on('click','#button-delete',function(e) {
                e.preventDefault()
                var id = $(this).attr('data-id')
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/delete/"+id,
                    method:'get',
                    data: {
                        'id': id
                    },
                    success:function(response) {
                        if(response.code == 200) {
                            $('#data_'+id).remove()
                        }
                    }
                })
            });
        });

    </script>
</body>

</html>
