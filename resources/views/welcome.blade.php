<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Delete Multiple Data using Checkbox in Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-3">
        <h1 class="text-center">Bootstrap Table</h1>
        <hr>
        @if ($message = Session::get('success'))
            <div class="alert alert-info">
            <p>{{ $message }}</p>
            </div>
        @endif
        <div class="row">
            <button class="btn btn-sm btn-danger w-25 my-3 m-auto removeAll">Mark Delete</button>
            <div class="col-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="bg-secondary">
                            <th scope="col">
                                <input class="form-check-input" type="checkbox" id="mainCheckBox">
                            </th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr id="tr_{{ $user->id }}">
                            <th scope="row">
                                <input class="form-check-input selectCheckBox" type="checkbox" data-id="{{ $user->id }}">
                            </th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Check All CheckBox
            $('#mainCheckBox').click(function (e) {
                if ($(this).is(':checked', true)) {
                    $(".selectCheckBox").prop('checked', true);
                } else {
                    $(".selectCheckBox").prop('checked', false);
                }
            });

            // UnCheck Main CheckBox
            $('.selectCheckBox').click(function (e) {
                if ('.selectCheckBox:checked'.length == $('.selectCheckBox').length) {
                    $('#mainCheckBox').prop('checked', true);
                } else {
                    $('#mainCheckBox').prop('checked', false);
                }
            });

            $('.removeAll').click(function (e) {
                let ids = [];
                $('.selectCheckBox:checked').each(function () {
                    ids.push($(this).data('id'));
                });
                if (ids.length > 0) {
                    if (confirm('Are you sure you want to delete this data?')) {
                        let userid = ids.join(",");
                        $.ajax({
                            type: "DELETE",
                            url: "mark-delete-user",
                            data: {
                                ids: userid
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.status == true) {
                                    $(".selectCheckBox:checked").each(function () {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(response.message);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function(response) {
                                alert(response.responseText);
                            }
                        });
                    }
                }else{
                    alert('Please select at least one checkbox');
                }
            });
        });
    </script>
</body>

</html>
