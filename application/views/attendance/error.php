
<h1 class="page-header"><?= $title; ?><div class="rSidePosition"><?= $dropdown_groups; ?></div></h1>
<div class="well"><?= $page_description; ?></div>
<div class="bs-callout bs-callout-danger">
    <h4>Warning!</h4>
    <p>
    You have to prepare a project for attendance management in adcance.</p>
</div>

<ol>
    <li>Click on <a href="<?=REDMINE_URL;?>projects/new" target="_blank">this link</a> and create a project for attendance management, e.g. worktime, if you didn't.</li>
    <li>Set ATTENDANCE_PRJ_IDENTIFIER to project Identifier you created in application/config/constants.php</li>
    <li>Come back to this page.</li>
</ol>