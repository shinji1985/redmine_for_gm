
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Redmine URL</div>
    <div class="panel-body">
        <p><a target="_blank" href="<?= REDMINE_URL; ?>projects/<?= $project['identifier']; ?>">http://redmine.bit-vietnam.com/projects/<?= $project['identifier']; ?></a></p>
    </div>

</div>
<div class="table-responsive">

    <div id="dataTable"></div>
    <script>
        var data = [
<?php
foreach ($issues as $row):
    $subject = str_replace("\"", "", mb_strimwidth($row['subject'] , 0, 15,'...'));
    ?>
                ["#<?= $row['id']; ?>", "<?= $row['root_id']; ?>", "<?= $row['parent_id']; ?>", "<?= $subject; ?>","","","<?= $row['priority_id']; ?>", "<?= $row['done_ratio']; ?>", "<?= $row['estimated_hours']; ?>", "<?= $row['start_date']; ?>", "<?= $row['due_date']; ?>", "<?= $row['assigned_to_id']; ?>"],
    <?php
    if (count($row['child']) > 0):
        foreach ($row['child'] as $childrow):
    $csubject = str_replace("\"", "", mb_strimwidth($childrow['subject'] , 0, 15,'...'));
            ?>
                                ["#<?= $childrow['id']; ?>", "<?= $childrow['root_id']; ?>", "<?= $childrow['parent_id']; ?>","","<?= $csubject; ?>","","<?= $childrow['priority_id']; ?>", "<?= $childrow['done_ratio']; ?>", "<?= $childrow['estimated_hours']; ?>", "<?= $childrow['start_date']; ?>", "<?= $childrow['due_date']; ?>", "<?= $childrow['assigned_to_id']; ?>"],
            <?php
            if (count($childrow['child']) > 0):
                foreach ($childrow['child'] as $cchildrow):
    $ccsubject = str_replace("\"", "", mb_strimwidth($cchildrow['subject'] , 0, 15,'...'));
                    ?>
                                                ["#<?= $cchildrow['id']; ?>", "<?= $cchildrow['root_id']; ?>", "<?= $cchildrow['parent_id']; ?>","","","<?= $ccsubject; ?>","<?= $cchildrow['priority_id']; ?>", "<?= $cchildrow['done_ratio']; ?>", "<?= $cchildrow['estimated_hours']; ?>", "<?= $cchildrow['start_date']; ?>", "<?= $cchildrow['due_date']; ?>", "<?= $cchildrow['assigned_to_id']; ?>"],
                    <?php
                endforeach;
            endif;

        endforeach;
    endif;


endforeach;
?>
    ];
    $("#dataTable").handsontable('selectCell');
    $("#dataTable").handsontable({
        data: data,
        startRows: 6,
        currentRowClassName: 'currentRow',
        currentColClassName: 'currentCol',
        autoWrapRow: true,
        colHeaders: ["id", "root_id", "parent_id", "subject"," "," ","priority_id", "done_ratio", "estimated_hours", "start_date", "due_date", "assigned_to_id"],
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
                //simple text, no special options here subject
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