
<h1 class="page-header"><?= $title; ?><div class="rSidePosition"><?= $dropdown_groups; ?></div></h1>


<?php if (count($issues_noassigned) > 0): ?>
    <div class="bs-callout bs-callout-danger">
        <h4>Warning!</h4>
        <p>These issues as follows are assigned to nobody. Click on the subject and set the Assignee parameter in Redmine.<br/>
            <strong>NOTE</strong> If you bother to update issues in bulk, you can use <a target="_blank" href="http://www.redmine.org/projects/redmine/wiki/RedmineIssueList#Bulk-editing-issues">Bulk editing issues</a>.</p>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="70">ID</th>
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

<?php if (count($holiday_applications) > 0): ?>
    <div class="bs-callout bs-callout-warning">
        <h4>Paid Holiday applications</h4>
        <p>These issues as follows are applications of paid holiday. If you accept it, change the status "Closed". If not, Set "Rejected".<br/>
            <strong>NOTE</strong> If you bother to update issues in bulk, you can use <a target="_blank" href="http://www.redmine.org/projects/redmine/wiki/RedmineIssueList#Bulk-editing-issues">Bulk editing issues</a>.</p>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="70">ID</th>
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
                foreach ($holiday_applications as $row):
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



<div class="bs-callout">
    <h4>Usage</h4>
    <ul>
        <li>Daily Report
            <ol>
                <li>At the end of the day, staffs add new issue setting Tracker to DailyReport, Estimated time to work hours on the day and Start date to the day.</li>
                <li>Admin user check it and change the status to "Closed" if it's ok.</li>
            </ol>
        </li>
        <li>Paid Holiday application
            <ol>
                <li>In the case that staffs want to apply paid holiday, they add new issue setting Tracker to PaidHoliday, Estimated time to the amount of paid hours, and Start date to the day they want.</li>
                <li>Admin user check it and change the status to "Closed" if it's ok.</li>
            </ol>
        </li>
    </ul>
    <p><strong>NOTE</strong> If you bother to update issues in bulk, you can use <a target="_blank" href="http://www.redmine.org/projects/redmine/wiki/RedmineIssueList#Bulk-editing-issues">Bulk editing issues</a>.</p>
</div>
<div style="text-align:right; margin-bottom:20px;">
    <form class="form-inline">
        <div class="form-group">
            <input type="text" style="text-align: right; width:100px;" class="form-control year" name="year" value="<?= $date['year']; ?>" placeholder="Year">
        </div>
        <div class="form-group">
            <?= form_dropdown('month', $date['month_dropdown'], $date['month'], ' class="form-control month"'); ?> 
        </div>
        <button type="submit" class="btn btn-default date_change">Change</button>
    </form>
</div>

<div class="row">
    <div class="col-md-2">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr >
                        <th><?= $date['year']; ?> <?= $date['month_en']; ?></th>
                    </tr>
                    <tr>
                        <td><small>#</small></td>
                    </tr>
                    <?php
                    foreach ($users as $row):
                        $name = anchor(REDMINE_URL . 'users/' . $row['id'], substr($row['firstname'] . ' ' . $row['lastname'], 0, 21), 'target="_blank"');
                        ?>
                        <tr>
                            <td><small><?= $name; ?></small></td>

                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td><small>#</small></td>
                    </tr>
                    <tr >
                        <th><?= $date['year']; ?> <?= $date['month_en']; ?></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-10">
        <div id="attend_table" style="overflow-x:scroll;">
            <?= $date_table; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        
        //popover
        $('[rel=popover]').popover({
            placement: 'top',
            html: true,
            trigger: "hover"
        });
        
        //Change month
        $('.date_change').click(function() {
            document.location = '<?= base_url(); ?>attendance/'+$('.year').val()+'/'+$('.month').val()+'<?= $group_get_query; ?>';
            return false;
        });
        
        //horizontal scroll
        var speed = 30;
        $('#attend_table').on('mousewheel', function(event, mov) {
            //ie firefox
            $(this).scrollLeft($(this).scrollLeft() - mov * speed);
            //webkit
            $('body').scrollLeft($('body').scrollLeft() - mov * speed);
            
            //Stop vertical scroll
            return false;  
        });
       
    });
</script>