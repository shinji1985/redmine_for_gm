
<h1 class="page-header"><?= $title; ?></h1>
<ul class="nav nav-tabs">
    <li><a href="<?= base_url(); ?>resources">Every projects</a></li>
    <li class="active"><a href="<?= base_url(); ?>resources/issues">Every issues</a></li>
</ul>
<div class="gantt"></div>
<script>
    $(function() {

        "use strict";

        $(".gantt").gantt({
            source: [
<?php foreach ($users as $user_row):
    ?>
                                                                                            
    <?php
    if (count($user_row['issues']) != 0):
        foreach ($user_row['issues'] as $issues_row):
//        if ($issues_row['start_date'] == NULL):
//            continue;
//        endif;
            if ($issues_row['due_date'] == NULL):
                $issues_row['due_date'] = $issues_row['start_date'];
            endif;
            ?>
                                        {
                                            name: "<?= $user_row['firstname']; ?> <?= $user_row['lastname']; ?>",
                                            desc: "<?= $issues_row['subject']; ?>",
                                            values: [{
                                                    id: "<?= $issues_row['id']; ?>",
                                                    from: "/Date(<?= strtotime($issues_row['start_date']) * 1000; ?>)/",
                                                    to: "/Date(<?= strtotime($issues_row['due_date']) * 1000; ?>)/",
                                                    label: "<?= $issues_row['subject']; ?>", 
                                                    customClass: "ganttGreen",
                                                    dep: "t01",
                                                    dataObj: {
                                                        flg:'issue',
                                                        id:'<?= $issues_row['id']; ?>',
                                                        subject:'<?= $issues_row['subject']; ?>',
                                                        project_name:'<?= $issues_row['project_name']; ?>',
                                                        identifier:'<?= $issues_row['identifier']; ?>',
                                                        description:"<?= $issues_row['subject']; ?> <br/>"
                                                            +"ESTIMATED: <?= $issues_row['estimated_hours']; ?> hours<br/>"
                                                            +"STATUS: <?= $issues_row["issue_status"]; ?><br/>"
                                                            +"PROGRESS: <?= $issues_row["done_ratio"]; ?> %<br/>",
                                                        estimated_hours:'<?= $issues_row['estimated_hours']; ?>',
                                                        issue_status:'<?= $issues_row['issue_status']; ?>',
                                                        done_ratio:'<?= $issues_row['done_ratio']; ?>'
                                                    }
                                                }]
                                        },
        <?php endforeach; ?>
    <?php else: ?>
                            {
                                name: "<?= $user_row['firstname']; ?> <?= $user_row['lastname']; ?>",
                                desc: "Opening",
                                values: [{
                                        id: "t02",
                                        from: "/Date(<?= strtotime(date('Y-m-d', time())) * 1000; ?>)/",
                                        to: "/Date(<?= strtotime(date('Y-m-d', strtotime('+1 month'))) * 1000; ?>)/",
                                        label: "Opening", 
                                        customClass: "ganttRed",
                                        dep: "t01",
                                        dataObj: {
                                            flg:'open'
                                        }
                                    }]
                            },
    <?php endif; ?>
<?php endforeach; ?>
            ],
            navigate: "scroll",
            scale: "days",
            maxScale: "months",
            minScale: "days",
            itemsPerPage: 1000,
            scrollToToday:true,
            onItemClick: function(data) {
                if(data.flg == 'open'){
                    
                }else{
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
            selector: ".bar",
            placement: 'top',
            html: true,
            title: function() {
                return $(this).data('dataObj').project_name;
            },
            content: function() {
                return $(this).data('dataObj').description;
            },
            trigger: "hover"
        });
       
        

        prettyPrint();

    });

</script>