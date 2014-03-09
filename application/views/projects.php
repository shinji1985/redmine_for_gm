
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Projects List</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>name</th>
                    <th>description</th>
                    <th>homepage</th>
                    <th>identifier</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $row): ?>
                    <tr>
                       <td><a href="<?=base_url();?>projects/<?= $row['identifier']; ?>"><?= $row['name']; ?></a></td>
                       <td><?= $row['description']; ?></td>
                       <td><?= $row['homepage']; ?></td>
                       <td><?= $row['identifier']; ?></td>
                       <td><?= $row['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
               
            </tbody>
        </table>
    </div>
</div>