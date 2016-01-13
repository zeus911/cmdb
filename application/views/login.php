<?php $this->load->view('header'); ?>
<!-- /section:basics/navbar.layout -->
<body class="login-layout blur-login">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="space-30"></div>

                    <div class="space-30"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">

                                    <div class="space-10"></div>

                                    <form id="login-form" role="form"  method="post">
                                        <fieldset>
                                            <label class="block clearfix">
														<span class="block input-icon input-icon-left">
															<input type="text" class="form-control" name="user_name"
                                                                   placeholder="用户名" required/>
															<i class="ace-icon fa fa-user"></i>
														</span>
                                            </label>

                                            <label class="block clearfix">
														<span class="block input-icon input-icon-left">
															<input type="password" class="form-control" name="password"
                                                                   placeholder="密码" required/>
															<i class="ace-icon fa fa-lock"></i>
														</span>
                                            </label>

                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <button type="submit"
                                                        class="width-35 pull-right btn btn-sm btn-primary" value="submit">
                                                    <i class="ace-icon fa fa-key"></i>
                                                    <span class="bigger-110">登录</span>
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>

                                </div>
                                <!-- /.widget-main -->
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.login-box -->
                    </div>
                    <!-- /.position-relative -->

                </div>
            </div>
            <!-- /.col -->
            <script>
                    $('#login-form').submit(function() {
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "index.php/home/login",
                            data: $('#login-form').serialize(),
                            success: function (data) {
                                if (data.code == 0){
                                    $.popMessage('ok', data.message);
                                    window.location.href="<?php echo site_url()?>";
                                }else if(data.code == 1001){
                                    $.popMessage('error', data.message);
                                    $("#login-form")[0].reset();
                                }else{
                                    $.popMessage('warn', data.message);
                                    $("#login-form")[0].reset();
                                }
                            },
                            error: function (data) {
                                $.popMessage('error', '服务器故障！');
                                $("#login-form")[0].reset();
                            }
                        });
                        return false;
                    });



            </script>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.main-content -->
</div>
<!-- /.main-container -->
<?php $this->load->view('footer'); ?>

