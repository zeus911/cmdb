<div class="main-content" id="page_div">
<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="<?php echo site_url() ?>">首页</a>
        </li>
        <li class="active">用户组管理</li>
    </ul>
    <!-- /.breadcrumb -->
</div>
<style>
    .modal-dialog {
        width: 380px;
        height: 700px;
        top: 20%
    }
</style>
<div class="page-content">
<div class="page-content-area">
    <div class="row" style="height: 100%">
        <div class="col-xs-12">
            <div>
                <button class="btn btn-xs  btn-success" id="addForm">
                    <i class="ace-icon fa  fa-plus bigger-110"></i>
                    <span class="bigger-110 no-text-shadow">新增</span>
                </button>
            </div>

            <div class="space-2"></div>
            <div class="hr hr-dotted"></div>

            <div class="page-header">
                <form class="form-inline" id="search-form">
                    <label class="inline input-sm">
                        <span class="lbl">组名：</span>
                    </label>

                    <div class="form-group">
                        <input id="sgroup_name" name="sgroup_name" type=text class="form-control input-sm"
                               style="width: 200px"/>
                    </div>
                    <span> &nbsp;&nbsp;</span>
                    <button class="btn btn-xs   btn-purple" type="submit" id="search">
                        <i class="ace-icon fa  fa-search  bigger-110"></i>
                        <span class="bigger-110 no-text-shadow">查询</span>
                    </button>
                    <span> &nbsp;&nbsp;</span>
                    <button id="refresh" class="btn btn-xs  btn-success">
                        <i class="ace-icon fa  fa-refresh   bigger-110"></i>
                        <span class="bigger-110 no-text-shadow">刷新</span>
                    </button>
                </form>

            </div>

            <!-- PAGE CONTENT BEGINS -->

            <table id="table-data"></table>
            <div class="space-2"></div>
            <div style="text-align:left;">
                <div id="paginator-div"></div>
            </div>
            <!-- PAGE CONTENT ENDS -->
            <div class="modal fade" id="myModal-add">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <button type="button " class=" close" data-dismiss="modal"><span
                                    aria-hidden="true">&times;</span><span
                                    class="sr-only">Close</span></button>
                            <h4 class="modal-title ">增加</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="myform" method="post">
                                <input id="id" class=" input-sm" type="text" value=""
                                       name="id" hidden="hidden">

                                <div class="form-group ">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right"
                                           for="username">组名：</label>

                                    <div class="col-xs-12 col-sm-8">
                                        <div class="clearfix">
                                            <input id="group_name" class=" input-sm" type="text" value=""
                                                   name="group_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-20"></div>
                                <div class="clearfix ">
                                    <div class="text-center">
                                        <button class="btn btn-xs   btn-purple" type="submit" id="submitForm">
                                            <span class="bigger-110 no-text-shadow">提交</span>
                                            <i class="ace-icon fa fa-arrow-right  bigger-110"></i>
                                        </button>
                                        <span> &nbsp;&nbsp;</span>
                                        <button class="btn btn-xs  btn-success" type="reset">
                                            <span class="bigger-110 no-text-shadow">重置</span>
                                            <i class="ace-icon fa  fa-refresh   bigger-110"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <p></p>
                </div>

            </div>
            <!-- /.modal-content -->
            <div class="modal fade" id="permissionModal">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <button type="button " class=" close" data-dismiss="modal"><span
                                    aria-hidden="true">&times;</span><span
                                    class="sr-only">Close</span></button>
                            <h4 class="modal-title ">增加</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" id="myform" method="post">
                                <input id="id" class=" input-sm" type="text" value=""
                                       name="id" hidden="hidden">
                                <div class="form-group ">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right"
                                           for="username">组名：</label>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="clearfix">
                                            <input id="group_name" class=" input-sm" type="text" value=""
                                                   name="group_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-20"></div>
                                <div class="clearfix ">
                                    <div class="text-center">
                                        <button class="btn btn-xs   btn-purple" type="submit" id="submitForm">
                                            <span class="bigger-110 no-text-shadow">提交</span>
                                            <i class="ace-icon fa fa-arrow-right  bigger-110"></i>
                                        </button>
                                        <span> &nbsp;&nbsp;</span>
                                        <button class="btn btn-xs  btn-success" type="reset">
                                            <span class="bigger-110 no-text-shadow">重置</span>
                                            <i class="ace-icon fa  fa-refresh   bigger-110"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <p></p>
                </div>

            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</div>

<script>
$(document).ready(function () {

    var postUrl;

    var validForm = $('#myform').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            rules: {
                group_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15
                }
            },
            messages: {
                group_name: {
                    required: "请输入组名",
                    minlength: "账号需要3-15个字符",
                    maxlength: "账号需要3-15个字符"
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
                    url: postUrl,
                    data: $('#myform').serialize(),
                    success: function (data) {
                        if (data.code == 0) {
                            $.popMessage('ok', data.message);
                            $("#myform")[0].reset();
                            $('#myModal-add').modal('hide');
                            mmg.load({page: 1});
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
        })
        ;

    function editForm(data) {

        $('.modal-title').text('修改');
        for (var p  in data) {
            console.log(p);
            $(eval(p)).val(data[p]);
            $('#myModal-add').modal('show');
        }
    }

    $("#addForm").click(function (e) {
        postUrl = 'sys/user_groupadd';
        $('.modal-title').text('增加');
        validForm.resetForm();
        $('.form-group').removeClass('has-error');
        $("#myform")[0].reset();
        $('#myModal-add').modal('show');
    });

    $("#permissonForm").click(function (e) {
        postUrl = 'sys/user_groupadd';
        $('.modal-title').text('增加');
        validForm.resetForm();
        $('.form-group').removeClass('has-error');
        $("#myform")[0].reset();
        $('#myModal-add').modal('show');
    });

    var renderOpt = function (val) {

        var ret = ['<div class="hidden-sm hidden-xs btn-group">'
            , '<button class="btn btn-xs btn-success"><i class="ace-icon fa fa-check bigger-120"></i>授权'
            , '</button>'
            , '<button class="btn btn-xs btn-info"><i class="ace-icon fa fa-pencil bigger-120"></i>修改'
            , '</button>'
            , '<button class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-120">删除</i>'
            , '</button>'
            , '</div>'
        ].join('')
        return ret;
    }
    //列
    var cols = [
        { title: 'ID', name: 'id', width: 100, align: 'center', sortable: true },
        { title: '组名', name: 'group_name', width: 100, align: 'center', sortable: true},
        { title: '操作', name: '-', width: 200, align: 'center', renderer: renderOpt}
    ];
    //AJAX示例
    var mmg = $('#table-data').mmGrid({
        cols: cols,
        url: 'sys/user_groupget_list',
        method: 'post',
        remoteSort: true,
        root: 'items',
        height: '500px',
        fullWidthRows: true,
        params: function () {
            return {"group_name": $('#sgroup_name').val()};
        },
        plugins: [
            $('#paginator-div').mmPaginator({limitList: [20, 30, 40, 50]})
        ],
//        checkCol: true,
        indexCol: true,
//        multiSelect: true,
        indexColWidth: 45,
        showBackboard: false

    });
    mmg.on('cellSelected', function (e, item, rowIndex, colIndex) {
        if ($(e.target).is('.btn-success')) {
            e.stopPropagation();  //阻止事件冒泡
//            alert(JSON.stringify(item["id"]));
            var id = item["id"];
            loadPage('sys/group_permission/config?sys_group_id='+id);
        } else if ($(e.target).is('.btn-info')) {
            e.stopPropagation();  //阻止事件冒泡
            postUrl = 'sys/user_groupedit';
            validForm.resetForm();
            $('.form-group').removeClass('has-error');
            editForm(item);
        } else if ($(e.target).is('.btn-danger')) {
            e.stopPropagation();  //阻止事件冒泡
            bootbox.confirm({
                    message: "<h4>确定要删除吗?</h4>",
                    buttons: {
                        confirm: {
                            label: "确定",
                            className: "btn-primary btn-sm fa fa-check"
                        },
                        cancel: {
                            label: "取消",
                            className: "btn-sm"
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            var id = item['id'];
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "sys/user_groupdelete",
                                data: {'id': id},
                                success: function (data) {
                                    if (data.code == 0) {
                                        $.popMessage('ok', data.message);
                                        mmg.load({page: 1});
                                    } else if (data.code == 1001) {
                                        $.popMessage('error', data.message);
                                    } else {
                                        $.popMessage('warn', data.message);
                                    }
                                },
                                error: function (data) {
                                    $.popMessage('error', '服务器故障！');
                                    $("#myform")[0].reset();
                                }
                            });
                        }
                    }
                }
            );
        }
    });

    $('#search').on('click', function () {
        mmg.load({page: 1});
        return false;
    });
    $('#reset').on('click', function () {
        $('#myform')[0].reset();
    });

    $('#refresh').on('click', function () {
        $('#search-form')[0].reset();
        mmg.load({page: 1});
        return false;
    });

    autoHeight(120);

});
</script>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.page-content-area -->

