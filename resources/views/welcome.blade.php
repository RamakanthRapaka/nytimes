<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdn.datatables.net/1.10.0/css/jquery.dataTables.css" rel="stylesheet" id="bootstrap-css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet"
    id="bootstrap-css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://cdn.datatables.net/plug-ins/1.13.1/integration/font-awesome/dataTables.fontAwesome.css"
    rel="stylesheet" id="bootstrap-css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Top Books</title>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                ajax: 'http://127.0.0.1:8000/api/topthreebooks',
                "columns": [{
                        "data": "list_name"
                    },
                    {
                        "data": "title"
                    },
                    {
                        "data": "author"
                    },
                    {
                        "data": "book_rank"
                    },
                    {
                        "data": "weeks_on_list"
                    },
                    {
                        "data": "image",
                        "orderable": false,
                        "render": function(data, type, row) {
                            return '<img src="' + data + '" width="30" height="30"/>';
                        }
                    },
                    {
                        "data": "buy_links",
                        "orderable": false,
                        "render": function(data, type, row) {
                            var url = '';
                            $.each(JSON.parse(data), function(key, value) {
                                url += '<a href="' + value.url +
                                    '" target="_blank" data-toggle="tooltip" title="' +
                                    value.name + '"> <i class="fa fa-dribbble"></i></a>';
                            });
                            return url;
                        }
                    },
                    {
                        "data": "id",
                        "orderable": false,
                        "render": function(data, type, row) {
                            return '<a href="#" onclick="bookdetails(' + data +
                                ')" class="info_link" data-id="' + data +
                                '" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-edit"></i></a>';
                        }
                    }
                ]
            });
        });

        function bookdetails(id) {
            $.ajax({
                url: "http://127.0.0.1:8000/api/getbookbyid",
                method: "POST",
                dataType: "json",
                async: true,
                cache: false,
                data: {
                    id: id,
                },
                success: function(data, status) {
                    if (data.status_code == 200) {
                        console.log(data.data[0]);
                        $('#list_name').val(data.data[0].list.list_name);
                        $('#book_name').val(data.data[0].title);
                        $('#author').val(data.data[0].author);
                        $('#id').val(id);
                    }
                }
            });
        }

        function updatebookdetails() {
            $.ajax({
                url: "http://127.0.0.1:8000/api/updatebookbyid",
                method: "POST",
                dataType: "json",
                async: true,
                cache: false,
                data: {
                    'id': $('#id').val(),
                    'list_name': $('#list_name').val(),
                    'book_name': $('#book_name').val(),
                    'author': $('#author').val(),
                },
                success: function(data, status) {
                    if (data.status_code == 200) {
                        console.log(data);
                        $('#message').text("Book Details Updated!");
                        $('#example').DataTable().ajax.reload();
                        $('#exampleModal').modal('toggle');
                    }
                    if (data.status_code == 422) {
                        $('#message').text("All Fields Are Mandatory!");
                    }
                }
            });
        };
    </script>
</head>

<div class="container">
    <div class="row">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>List Name</th>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>Rank</th>
                    <th>Weeks On List</th>
                    <th>Image</th>
                    <th>Links To Buy</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>List Name</th>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>Rank</th>
                    <th>Weeks On List</th>
                    <th>Image</th>
                    <th>Links To Buy</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Book Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">List Name:</label>
                        <input type="text" class="form-control" id="list_name" name="list_name">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Book Name:</label>
                        <input type="text" class="form-control" id="book_name" name="book_name">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Author:</label>
                        <input type="text" class="form-control" id="author" name="author">
                        <input type="hidden" class="form-control" id="id" name="id">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-12" id="message"></div>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update_book_details"
                    onclick="updatebookdetails();">Update</button>
            </div>
        </div>
    </div>
</div>

</html>
