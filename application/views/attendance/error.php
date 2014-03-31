
<h1 class="page-header"><?= $title; ?><div class="rSidePosition"><?= $dropdown_groups; ?></div></h1>

<div class="bs-callout bs-callout-danger">
    <h4>Warning!</h4>
    <p>
        You have to do some preparations as follows in advance.</p>
</div>

<ol>
    <li>Click on <a href="<?= REDMINE_URL; ?>roles" target="_blank">this link</a> and create a new role, e.g. DailyReporter, has the only permission to view and add issues.</li>
    <li>Click on <a href="<?= REDMINE_URL; ?>projects/new" target="_blank">this link</a> and create a project for attendance management, e.g. AttendanceManagement, if you didn't.</li>
    <li>Add staffs as the new role and add admin users as a manager to the new project.</li>
    <li>Click on <a href="<?= REDMINE_URL; ?>trackers" target="_blank">this link</a> and create 2 new trackers, e.g. DailyReport and PaidHoliday, add these trackers to only the project.

        <img src="<?= base_url(); ?>img/tracker2.png"  alt="tracker" class="img-responsive" />
        <strong>Note:</strong>Don't forget to add PaidHoliday tracker as well. 
    </li>
    <li>Remove other trackers from the project.
        <img src="<?= base_url(); ?>img/tracker1.png"  alt="tracker" class="img-responsive" />
    </li>
    <li>Click on <a href="<?= REDMINE_URL; ?>workflows/edit" target="_blank">this link</a> and set each parameter as follows.
        <ul>
            <li>In the case of Role:Manager and Tracker:DailyReport.
                <img src="<?= base_url(); ?>img/workflow1.png"  alt="workflow1" class="img-responsive" /></li>
            <li>In the case of Role:DailyReporter and Tracker:DailyReport.
                <img src="<?= base_url(); ?>img/workflow2.png"  alt="workflow2" class="img-responsive" />
                <strong>Note:</strong>Don't forget to each parameter in the case of Tracker:PaidHoliday. 
            </li>
        </ul>
    </li>

    <li>Set ATTENDANCE_* constants in application/config/constants.php</li>
    <li>Come back to this page.</li>

</ol>
