<div class="container">
    <div class="d-flex justify-content-between">
        <h3>List User</h3>
        <a class="btn btn-success" href="./?page=user/create" role="button">Create new</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Option</th>
            </tr>
            <?php
            $users = getUsers();
            $count = 1;
            while ($row = $users->fetch_object()) {
                $photo = $row->photo ?? './assets/images/emptyuser.png';

                echo '<tr style="vertical-align: middle;">
                    <td>' . $count . '</td>
                    <td> <img src="' . $photo . '" class="rounded img-thumbnail" style="max-width:100px"></img></td>
                    <td>' . $row->name . '</td>
                    <td>
                        <a class="btn btn-primary" href="./?page=user/update&id=' . $row->id . '" role="button">Edit</a>
                        <a class="btn btn-danger" href="./?page=user/delete&id=' . $row->id . '" role="button">Delete</a>
                    </td>
            </tr>';
                $count++;


            }
            ?>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.btn-danger').click(function (e) {
            e.preventDefault();
            const href = $(this).attr('href');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location.href = href;
                    Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"});
            };
        });
    });
})

</script>