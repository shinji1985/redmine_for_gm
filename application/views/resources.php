
<h1 class="page-header"><?= $title; ?></h1>
<ul class="nav nav-tabs">
  <li class="active"><a href="#">Every projects</a></li>
  <li><a href="#">Every tickets</a></li>
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
//                                        {
//                                            name: "<?= $user_row['firstname']; ?> <?= $user_row['lastname']; ?>",
//                                            desc: "<?= $issues_row['subject']; ?>",
//                                            values: [{
//                                                    id: "<?= $issues_row['id']; ?>",
//                                                    from: "/Date(<?= strtotime($issues_row['start_date']) * 1000; ?>)/",
//                                                    to: "/Date(<?= strtotime($issues_row['due_date']) * 1000; ?>)/",
//                                                    label: "<?= $issues_row['subject']; ?>", 
//                                                    customClass: "ganttGreen",
//                                                    dep: "t01"
//                                                }]
//                                        },
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
                                        dep: "t01"
                                    }]
                            },
    <?php endif; ?>
<?php endforeach; ?>
                //                {
                //                    name: " ",
                //                    desc: "Scoping",
                //                    values: [{
                //                            id: "t02",
                //                            from: "/Date(1322611200000)/",
                //                            to: "/Date(1323302400000)/",
                //                            label: "Scoping", 
                //                            customClass: "ganttRed",
                //                            dep: "t01"
                //                        }]
                //                },{
                //                    name: "Sprint 1",
                //                    desc: "Development",
                //                    values: [{
                //                            from: "/Date(1323802400000)/",
                //                            to: "/Date(1325685200000)/",
                //                            label: "Development", 
                //                            customClass: "ganttGreen"
                //                        }]
                //                },{
                //                    name: " ",
                //                    desc: "Showcasing",
                //                    values: [{
                //                            from: "/Date(1325685200000)/",
                //                            to: "/Date(1325695200000)/",
                //                            label: "Showcasing", 
                //                            customClass: "ganttBlue"
                //                        }]
                //                },{
                //                    name: "Sprint 2",
                //                    desc: "Development",
                //                    values: [{
                //                            from: "/Date(1326785200000)/",
                //                            to: "/Date(1325785200000)/",
                //                            label: "Development", 
                //                            customClass: "ganttGreen"
                //                        }]
                //                },{
                //                    name: " ",
                //                    desc: "Showcasing",
                //                    values: [{
                //                            from: "/Date(1328785200000)/",
                //                            to: "/Date(1328905200000)/",
                //                            label: "Showcasing", 
                //                            customClass: "ganttBlue"
                //                        }]
                //                },{
                //                    name: "Release Stage",
                //                    desc: "Training",
                //                    values: [{
                //                            from: "/Date(1330011200000)/",
                //                            to: "/Date(1336611200000)/",
                //                            label: "Training", 
                //                            customClass: "ganttOrange"
                //                        }]
                //                },{
                //                    name: " ",
                //                    desc: "Deployment",
                //                    values: [{
                //                            from: "/Date(1336611200000)/",
                //                            to: "/Date(1338711200000)/",
                //                            label: "Deployment", 
                //                            customClass: "ganttOrange"
                //                        }]
                //                },{
                //                    name: " ",
                //                    desc: "Warranty Period",
                //                    values: [{
                //                            from: "/Date(1336611200000)/",
                //                            to: "/Date(1349711200000)/",
                //                            label: "Warranty Period", 
                //                            customClass: "ganttOrange"
                //                        }]
                //                }
            ],
            navigate: "scroll",
            scale: "days",
            maxScale: "months",
            minScale: "days",
            itemsPerPage: 1000,
            scrollToToday:true,
            onItemClick: function(data) {
                alert("Item clicked - show some details");
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
            title: "I'm a popover",
            content: "And I'm the content of said popover.",
            trigger: "hover"
        });

        prettyPrint();

    });

</script>
<div class="table-responsive">

    <div id="dataTable"></div>
    <?php foreach ($users as $user_row): ?>
        <?= $user_row['firstname']; ?> <?= $user_row['lastname']; ?><br/>

        <?php foreach ($user_row['issues'] as $issues_row): ?>
            <a href="<?= REDMINE_URL; ?>issues/<?= $issues_row['id']; ?>" target="_blank"><?= $issues_row['subject']; ?></a> <?= $issues_row['issue_status']; ?><br/>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
[id] => 1025
[subject] => データベース設計ver.1.0
[description] => 
[due_date] => 2013-09-10
[start_date] => 2013-09-06
[done_ratio] => 100
[estimated_hours] => 18
[assigned_to_id] => 1
[name] => お仕事Navi
[identifier] => navi