<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">All Datas</h5>
                    <table id="userOrder" width="100%"  style="border-collapse: collapse;">
                        <thead>
                        <tr>
                            <th scope="col">S.no</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Number</th>
                            <th scope="col">Status</th>
                            <th scope="col">Total Spend</th>
                            <th scope="col">Number Of Orders</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script>
<script
    src="http://code.jquery.com/jquery-3.5.1.js"
    integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
<!-- status changing -->
<script>
    $(document).on('click', '.toggle-class', function () {
        var status = $(this).data('status');
        var user_id = $(this).data('id');
        $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: "{{ route('changeStatus')}}",
            data: {
                'status': status,
                'user_id': user_id
            },
            success: function (data) {
                var button = document.getElementById("status-btn-" + user_id);
                if (data.status == 1) {
                    button.innerHTML=`<button data-id="${user_id}" data-status="0" class="btn btn-sm btn-success toggle-class">Active</button>`;
                } else {
                    button.innerHTML = `<button data-id="${user_id}" data-status="1" class="btn btn-sm btn-warning toggle-class">Inactive</button>`;
                }
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background', 'green');
                $('#notifDiv').text('Status Updated Successfully');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                }, 3000);
            }
        });
    });
</script>

<!-- ajax call -->
<!-- Script -->
<script type="text/javascript">
    $(document).ready(function () {

        // DataTable
        $('#userOrder').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('users.details')}}",

            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'email'},
                {data: 'mobile'},
                {
                    "data": null,
                    render: function (data, type, row) {
                        if (row.status == 1) {
                            return `<div id="status-btn-${row.id}"><button data-id="${row.id}" data-status="0" class="btn btn-sm btn-success toggle-class">Active</button></div>`;
                        } else {
                            return `<div id="status-btn-${row.id}"><button data-id="${row.id}" data-status="1" class="btn btn-sm btn-warning toggle-class">Inactive</button></div>`;
                        }
                    }
                },
                {data: 'total'},
                {data: 'count'},

            ]

        });

    });
</script>

<!-- ajax cdn -->
<script src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
