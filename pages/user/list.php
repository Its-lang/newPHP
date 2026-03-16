<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3>User list</h3>
        <a href="./?page=user/create" role="button" class="btn btn-success">
            Create New
        </a>
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
            $users = getUser();
            if ($users) {
                $count = 1;
                while ($row = $users->fetch_object()) {
                    echo '
                    <tr>
                        <td>' . $count . '</td>
                        <td>
                            <img src="' . ($row->photo ?? './assets/images/emptyuser.png') . '"
                                 class="rounded img-thumbnail"
                                 style="max-width:100px;">
                        </td>
                        <td>' . $row->name . '</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="./?page=user/update&id=' . $row->id . '" 
                                   class="btn btn-primary btn-sm">
                                   Edit
                                </a>

                                <a href="./?page=user/delete&id=' . $row->id . '" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm(\'Are you sure?\')">
                                   Delete
                                </a>
                            </div>
                        </td>
                    </tr>';
                    $count++;
                }
            }
            ?>
        </table>
    </div>
</div>