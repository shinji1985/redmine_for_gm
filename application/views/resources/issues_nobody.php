<?php if(count($issues_noassigned)>0): ?>
<div class="bs-callout bs-callout-danger">
    <h4>Warning!</h4>
    <p>These issues as follows are assigned to nobody except for issues have subtasks. Click on the subject and set the Assignee parameter in Redmine.<br/>
        <strong>NOTE</strong> If you bother to update issues in bulk, you can use <a target="_blank" href="http://www.redmine.org/projects/redmine/wiki/RedmineIssueList#Bulk-editing-issues">Bulk editing issues</a>.</p>
</div>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th width="70"><span class='glyphicon glyphicon-flag'></span></th>
                <th width="70"><span class='glyphicon glyphicon-play'></span></th>
                <th>Project Name</th>
                <th>Subject</th>
                <th width="100">Start Date</th>
                <th width="100">Due Date</th>
                <th class="cell_center" width="70"><span class='glyphicon glyphicon-time'></span></th>
                <th class="cell_center" width="70"><span class='glyphicon glyphicon-tasks'></span></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($issues_noassigned as $row):
                if ($row['estimated_hours'] != ''):
                    $row['estimated_hours'] = $row['estimated_hours'] . ' H';
                endif;
                ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['tracker_name']; ?></td>
                    <td><?= $row['issue_status']; ?></td>
                    <td><a target="_blank" href="<?= REDMINE_URL; ?>projects/<?= $row['identifier']; ?>"><?= $row['project_name']; ?></a></td>
                    <td><a target="_blank" href="<?= REDMINE_URL; ?>issues/<?= $row['id']; ?>"><?= $row['subject']; ?></a></td>
                    <td><?= $row['start_date']; ?></td>
                    <td><?= $row['due_date']; ?></td>
                    <td class="cell_right"><?= $row['estimated_hours']; ?></td>
                    <td class="cell_right"><?= $row['done_ratio']; ?> %</td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>

<?php endif; ?>