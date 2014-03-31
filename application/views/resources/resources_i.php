
<h1 class="page-header"><?= $title; ?><div class="rSidePosition"><?= $dropdown_groups; ?></div></h1>
<div class="bs-callout">
    <?= $page_description; ?>
</div>
<ul class="nav nav-tabs">
    <li><a href="<?= base_url(); ?>resources<?= $group_get_query; ?>">Every projects</a></li>
    <li class="active"><a href="<?= base_url(); ?>resources/issues<?= $group_get_query; ?>">Every issues</a></li>
</ul>

<div class="gantt"></div>
<script>
    $(function() {

        "use strict";

        $(".gantt").gantt({
            source: [
<?php
foreach ($users as $user_row):
    $i = 0;
    foreach ($user_row['issues'] as $issues_row):
        if ($i > 0):
            $name = '';
        else:
            $name = anchor(REDMINE_URL . 'users/' . $user_row['id'], $user_row['firstname'] . ' ' . $user_row['lastname'], 'target="_blank"');
        endif;
        if ($issues_row['id'] != ''):
            $desc = "#{$issues_row['id']} {$issues_row['subject']}";
        else:
            $desc = ' ';
        endif;
        ?>
                                {
                                    name: '<?= $name; ?>',
                                    desc: "<?= $desc; ?>",
                                    values: [{
                                            id: "<?= $issues_row['id']; ?>",
                                            from: "/Date(<?= strtotime($issues_row['start_date']) * 1000; ?>)/",
                                            to: "/Date(<?= strtotime($issues_row['due_date']) * 1000; ?>)/",
                                            label: "<?= $issues_row['subject']; ?>", 
                                            customClass: "<?= $issues_row['customClass']; ?>",
                                            dep: "t01",
                                            dataObj: {
                                                flg:'<?= $issues_row['flg']; ?>',
                                                id:'<?= $issues_row['id']; ?>',
                                                subject:'<?= $issues_row['subject']; ?>',
                                                project_name:'<?= $issues_row['project_name']; ?>',
                                                identifier:'<?= $issues_row['identifier']; ?>',
                                                description:"#<?= $issues_row['id']; ?> <?= $issues_row['subject']; ?> <br/>"
                                                    +"<?= $issues_row['start_date']; ?>〜<?= $issues_row['due_date']; ?> <br/>"
                                                    +"<span class='glyphicon glyphicon-flag'></span> <?= $issues_row["tracker_name"]; ?><br/>"
                                                    +"<span class='glyphicon glyphicon-play'></span> <?= $issues_row["issue_status"]; ?><br/>"
                                                    +"<span class='glyphicon glyphicon-user'></span> <?= $user_row['firstname'] . ' ' . $user_row['lastname']; ?><br/>"
                                                    +"<span class='glyphicon glyphicon-time'></span> <?= $issues_row['estimated_hours']; ?> hours<br/>"
                                                    +"<span class='glyphicon glyphicon-tasks'></span> <?= $issues_row["done_ratio"]; ?> %<br/>",
                                                estimated_hours:'<?= $issues_row['estimated_hours']; ?>',
                                                issue_status:'<?= $issues_row['issue_status']; ?>',
                                                done_ratio:'<?= $issues_row['done_ratio']; ?>'
                                            }
                                        }]
                                },
        <?php
        $i++;
    endforeach;
endforeach;
?>
            ],
            navigate: "scroll",
            scale: "days",
            maxScale: "months",
            minScale: "days",
            itemsPerPage: 1000,
            scrollToToday:true,
            onItemClick: function(data) {
                if(data.flg != 'open'){
                    window.open('<?= REDMINE_URL; ?>issues/'+data.id);
                }
            },
            onAddClick: function(dt, rowId) {
                
                alert("Empty space clicked - add an item!");
            },
            onRender: function() {
                if (window.console && typeof console.log === "function") {
                    console.log("chart rendered");
                }
            }
        });
        $(".gantt").popover({
            container: 'body', 
            selector: ".bar",
            placement: 'top',
            html: true,
            title: function() {
                return $(this).data('dataObj').project_name;
            },
            content: function() {
                if($(this).data('dataObj').flg != 'open'){
                    return $(this).data('dataObj').description;
                }
            },
            trigger: "hover"
        });
       
        

        prettyPrint();

    });

</script>