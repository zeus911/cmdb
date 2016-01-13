<?php $_user = MAuth::get_user_info(); ?>
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title ">个人信息</h4>
            </div>
            <div class="modal-body">
                <!-- #section:pages/profile.info -->
                <div class="profile-user-info profile-user-info-striped">
                    <div class="profile-info-row">
                        <div class="profile-info-name"> 账号:</div>
                        <div class="profile-info-value">
                            <span class="editable" ><?php echo $_user['user_name']; ?></span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name"> 姓名</div>

                        <div class="profile-info-value">
                            <span class="editable" ><?php echo $_user['truename']; ?> </span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> 用户组:</div>
                        <div class="profile-info-value">
                            <span class="editable" ><?php echo $_user['group_name']; ?></span>
                            <span class="editable" id="sys_group_id2"><?php echo $_user['sys_group_id']; ?></span>
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> 邮箱</div>

                        <div class="profile-info-value">
                            <span class="editable"><?php echo $_user['email']; ?> </span>
                        </div>
                    </div>
                </div>
                <p></p>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-container" id="navbar-container">
	<!--	
	<ul class="nav navbar-nav head-navbar">
	    <li class=" link"><a href="http://******"><i class="fa fa-cog fa-lg"></i>CMDB</a></li>
	</ul>
	-->
        <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        欢迎你：<?php echo $_user['truename']?:$_user['user_name']; ?>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="javascript:void(0)" id="info">
                                <i class="ace-icon fa fa-user"></i>
                                个人信息
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="index.php/home/logout">
                                <i class="ace-icon fa fa-power-off"></i>
                                退出
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- /section:basics/navbar.user_menu -->
            </ul>
        </div>

        <!-- /section:basics/navbar.dropdown -->
    </div>
    <!-- /.navbar-container -->
</div>

