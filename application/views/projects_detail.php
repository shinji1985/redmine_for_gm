
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header"><?= $title; ?></h1>

    <div class="table-responsive">
        <?= nl2br($project['description']); ?><br/>
        homepage:<?= $project['homepage']; ?><br/>
        is_public:<?= $project['is_public']; ?><br/>
        parent_id:<?= $project['parent_id']; ?><br/>
        created_on:<?= $project['created_on']; ?><br/>
        homepage:<?= $project['homepage']; ?><br/>
        lft:<?= $project['lft']; ?><br/>
        rgt:<?= $project['rgt']; ?><br/>
        <div id="dataTable"></div>
        <script>
            var data = [
<?php foreach ($issues as $row): ?>
            ["#<?= $row['id']; ?>", "<?= $row['root_id']; ?>", "<?= $row['parent_id']; ?>", "<?= $row['subject']; ?>", "<?= $row['done_ratio']; ?>%", "<?= $row['estimated_hours']; ?> hours", "<?= $row['start_date']; ?>", "<?= $row['due_date']; ?>"],
<?php endforeach; ?>
    ];
    $("#dataTable").handsontable({
        data: data,
        startRows: 6,
        startCols: 8,
        colHeaders: ["id", "root_id", "parent_id", "subject", "done_ratio", "estimated_hours", "start_date", "due_date", "assigned_to_id"]
    });
        </script>
        
    </div>
</div>