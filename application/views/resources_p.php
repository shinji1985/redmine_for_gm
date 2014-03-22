
<h1 class="page-header"><?= $title; ?></h1>
<ul class="nav nav-tabs">
    <li class="active"><a href="<?= base_url(); ?>resources">Every projects</a></li>
    <li><a href="<?= base_url(); ?>resources/issues">Every issues</a></li>
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
        ?>
                                {
                                    name: '<?= $name; ?>',
                                    desc: "<?= $issues_row['project_name']; ?>",
                                    values: [{
                                            id: "1",
                                            from: "/Date(<?= strtotime($issues_row['start_date']) * 1000; ?>)/",
                                            to: "/Date(<?= strtotime($issues_row['due_date']) * 1000; ?>)/",
                                            label: "<?= $issues_row['project_name']; ?>", 
                                            customClass: "<?= $issues_row['customClass']; ?>",
                                            dep: "t01",
                                            dataObj: {
                                                flg:'<?= $issues_row['identifier']; ?>',
                                                project_name:'<?= $issues_row['project_name']; ?>',
                                                identifier:'<?= $issues_row['identifier']; ?>',
                                                description:"<?= $issues_row['project_name']; ?> <br/>"
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
                if(data.flg != ''){
                    window.open('<?= REDMINE_URL; ?>projects/'+data.identifier);
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
                if($(this).data('dataObj').flg != ''){
                    return $(this).data('dataObj').project_name;
                }
            },
            content: function() {
                if($(this).data('dataObj').flg != ''){
                    return $(this).data('dataObj').description;
                }
            },
            trigger: "hover"
        });
       
        

        prettyPrint();

    });

</script>