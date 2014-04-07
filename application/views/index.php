
    <h2 class="sub-header">Projects List</h2>


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
                       <td><?= $row['name']; ?></td>
                       <td><?= $row['description']; ?></td>
                       <td><?= $row['homepage']; ?></td>
                       <td><?= $row['identifier']; ?></td>
                       <td><?= $row['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
               
            </tbody>
        </table>
    </div>
    <h2 class="sub-header">Users List</h2>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>name</th>
                    <th>mail</th>
                    <th>admin</th>
                    <th>status</th>
                    <th>last_login_on</th>
                    <th>language</th>
                    <th>mail_notification</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $row): ?>
                    <tr>
                       <td><?= $row['login']; ?></td>
                       <td><?= $row['firstname']; ?> <?= $row['lastname']; ?></td>
                       <td><?= $row['mail']; ?></td>
                       <td><?= $row['admin']; ?></td>
                       <td><?= $row['status']; ?></td>
                       <td><?= $row['last_login_on']; ?></td>
                       <td><?= $row['language']; ?></td>
                       <td><?= $row['mail_notification']; ?></td>
                    </tr>
                <?php endforeach; ?>
               
            </tbody>
        </table>
    </div>