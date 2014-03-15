
<h1 class="page-header"><?= $title; ?></h1>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Project Description</div>
    <div class="panel-body">
        <p><?= nl2br($project['description']); ?></p>
    </div>

    <!-- Table -->
    <table class="table">
        <tr>
            <th>HP</th>
            <td><?= $project['homepage']; ?></td>
        </tr>
        <tr>
            <th>Redmine URL</th>
            <td><a target="_blank" href="http://redmine.bit-vietnam.com/projects/<?= $project['identifier']; ?>">http://redmine.bit-vietnam.com/projects/<?= $project['identifier']; ?></a></td>
        </tr>
        <tr>
            <th>is_public</th>
            <td><?= $project['is_public']; ?></td>
        </tr>
        <tr>
            <th>parent_id</th>
            <td><?= $project['parent_id']; ?></td>
        </tr>
        <tr>
            <th>created_on</th>
            <td><?= $project['created_on']; ?></td>
        </tr>
        <tr>
            <th>lft</th>
            <td><?= $project['lft']; ?></td>
        </tr>
        <tr>
            <th>rgt</th>
            <td><?= $project['rgt']; ?></td>
        </tr>
    </table>
</div>
<div class="table-responsive">

    <div id="dataTable"></div>
    <script>
        var data = [
<?php foreach ($issues as $row): ?>
            ["#<?= $row['id']; ?>", "<?= $row['root_id']; ?>", "<?= $row['parent_id']; ?>", "<?= $row['subject']; ?>","<?= $row['priority_id']; ?>", "<?= $row['done_ratio']; ?>", "<?= $row['estimated_hours']; ?>", "<?= $row['start_date']; ?>", "<?= $row['due_date']; ?>"],
<?php endforeach; ?>
    ];
    $("#dataTable").handsontable('selectCell');
    $("#dataTable").handsontable({
        data: data,
        startRows: 6,
        currentRowClassName: 'currentRow',
        currentColClassName: 'currentCol',
        autoWrapRow: true,
        colHeaders: ["id", "root_id", "parent_id", "subject","priority_id", "done_ratio", "estimated_hours", "start_date", "due_date", "assigned_to_id"],
        columns: [
            {
                //simple text, no special options here id
            },
            {
                //simple text, no special options here root_id
            },
            {
                //simple text, no special options here parent_id
            },
            {
                //simple text, no special options here subject
            },
            {
                //simple text, no special options here priority_id
            },
            {
                //simple text, no special options here done_ratio
                type: 'dropdown',
                source: ["0", "10", "20", "30", "40", "50", "60", "70", "80", "90", "100"]
            },
            {
                //simple text, no special options here estimated_hours
                type: 'numeric',
                format: '0.0'
            },
            {
                //start_date
                type: 'date',
                dateFormat: 'yy-mm-dd'
            },
            {
                //due_date
                type: 'date',
                dateFormat: 'yy-mm-dd'
            },
            {
                //simple text, no special options here assigned_to_id
            }
        ]

    });
    
    </script>

</div>