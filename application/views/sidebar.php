<div id="sidebar" class="sidebar responsive sidebar-fixed sidebar-scroll">
    <ul class="nav nav-list" >
        <?php foreach($menu as $module):?>
        <?php if (count($module['page'])>0):?>
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa <?php echo $module['module_icon']?$module['module_icon']:'fa-gears'; ?>"></i>
                <span class="menu-text"><?php echo $module['module_name'] ?> </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu" style="display: block">
                <?php foreach($module['page'] as $value):?>
                <li class="">
                    <a href="index.php/<?php echo $value['module_resource'] ?>" >
                        <i class="menu-icon fa fa-caret-right"></i>
                        <?php echo $value['module_name'] ?>
                    </a>
                    <b class="arrow"></b>
                </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
           data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

</div>