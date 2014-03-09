
<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li <?php if($this->uri->segment(1) == ''):?>class="active"<?php endif; ?>><a href="<?=base_url();?>">Overview</a></li>
        <li <?php if($this->uri->segment(1) == 'projects'):?>class="active"<?php endif; ?>>
            <a href="<?=base_url();?>projects">Projects</a>
        </li>
        <li><a href="#">Analytics</a></li>
        <li><a href="#">Export</a></li>
    </ul>
    <ul class="nav nav-sidebar">
        <li><a href="">Nav item</a></li>
        <li><a href="">Nav item again</a></li>
        <li><a href="">One more nav</a></li>
        <li><a href="">Another nav item</a></li>
        <li><a href="">More navigation</a></li>
    </ul>
    <ul class="nav nav-sidebar">
        <li><a href="">Nav item again</a></li>
        <li><a href="">One more nav</a></li>
        <li><a href="">Another nav item</a></li>
    </ul>
</div>