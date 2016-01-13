<div class="main-content" id="page_div">
    <!-- #section:basics/content.breadcrumbs -->
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="<?php echo site_url() ?>">首页</a>
            </li>
            <li><a href="javascript:void(0)" onclick="loadPage('sys/module')">模块管理</a></li>
            <li class="active">编辑</li>
        </ul>
        <!-- /.breadcrumb -->
    </div>
    <div class="page-content">
        <div class="page-content-area">
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <h3 class="lighter block green">模块信息</h3>

                    <form class="form-horizontal" id="validation-form" method="post" role="form">
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right"
                                   for="module_name">模块名称:</label>

                            <div class="col-xs-12 col-sm-6">
                                <div class="clearfix">
                                    <input type="text" name="module_name" id="module_name" class="col-xs-12 col-sm-6"
                                           value="<?php echo @$entity['module_name']; ?>"  />
                                </div>
                            </div>
                        </div>
                            <div class="form-group <?php if (!empty($parent_id)){echo "hidden";}?>">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right"
                                   for="module_icon">模块图标:</label>

                            <div class="col-xs-12 col-sm-6">
                                <div class="clearfix">
                                    <input type="text" name="module_icon" id="module_icon" class="col-xs-12 col-sm-6"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group <?php if (empty($parent_id)){echo "hidden";}?>">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="module_resource">模块地址:</label>

                            <div class="col-xs-12 col-sm-6">
                                <div class="clearfix">
                                    <input type="text" name="module_resource" id="module_resource" class="col-xs-12 col-sm-6"
                                           value="<?php echo @$entity['module_resource']; ?>" />
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="module_parent_id" value="<?php echo $parent_id; ?>">
                        <input type="hidden" name="module_type" value="<?php echo $module_type; ?>">
                        <div class="clearfix ">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info btn-xs" type="submit">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    提交
                                </button>
                                &nbsp; &nbsp; &nbsp;
                                <a class="btn btn-xs" href="javascript:void(0)" onclick="loadPage('sys/module')">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    返回
                                </a>
                            </div>
                        </div>
                    </form>
                    <script src="resources/assets/js/jquery.validate.min.js"></script>
                    <script>
                        $(function () {


                            $('#validation-form').validate({
                                errorElement: 'div',
                                errorClass: 'help-block',
                                focusInvalid: false,
                                rules: {

                                    module_name: {
                                        required: true,
                                        minlength: 3,
                                        maxlength: 15
                                    }

                                },
                                messages: {

                                    module_name: {
                                        required: "请输入模块名",
                                        minlength: "模块名需要3-15个字符",
                                        maxlength: "模块名需要3-15个字符"
                                    }
                                },
                                highlight: function (e) {
                                    $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                                },

                                success: function (e) {
                                    $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                                    $(e).remove();
                                },

                                errorPlacement: function (error, element) {
                                    if (element.is(':checkbox') || element.is(':radio')) {
                                        var controls = element.closest('div[class*="col-"]');
                                        if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                                        else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                                    }
                                    else if (element.is('.select2')) {
                                        error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                                    }
                                    else if (element.is('.chosen-select')) {
                                        error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                                    }
                                    else error.insertAfter(element.parent());
                                },
                                submitHandler: function (form) {
                                    $.ajax({
                                        type: "POST",
                                        dataType: "json",
                                        url: "sys/module/add",
                                        data: $('#validation-form').serialize(),
                                        success: function (data) {
                                            if (data.code == 0) {
                                                $.popMessage('ok', data.message);
//                            $("#validation-form")[0].reset();
                                            } else if (data.code == 1001) {
                                                $.popMessage('error', data.message);
                                            } else {
                                                $.popMessage('warn', data.message);
                                            }
                                        },
                                        error: function (data) {
                                            $.popMessage('error', '服务器故障！');
                                        }
                                    });
                                }


                            });
                        });
                    </script>
                    <!-- PAGE CONTENT ENDS -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.page-content-area -->
    </div>
    <!-- /.page-content -->
</div>
<!-- /.main-content -->