<div class="container">
    <div class="d-flex justify-content-between">

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
            </tr>
            <?php
            $users = getUser();
            if ($users) {
                $count = 1;
                while ($row = $users->fetch_object()) {
                    echo '
                    <tr>
                        <th>' . $count . '</th>
                        <th>
                            <img src="' . ($row->photo ?? './assets/images/emptyuser.png') . '"
                                 class="rounded img-thumbnail" style="max: width 200px;"    
                            "/>
                        </th>
                        <th>' . $row->name . '</th>
                    </tr>';
                    $count++;
                }
            }

            ?>

        </table>
    </div>
</div>