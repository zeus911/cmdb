<div class="main-content" id="page_div">
<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="<?php echo site_url() ?>">首页</a>
        </li>
        <li class="active">用户管理</li>
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
                <span> &nbsp;&nbsp;</span>
                <button class="btn btn-xs  btn-pink" id="editForm">
                    <i class="ace-icon fa  fa-edit  bigger-110"></i>
                    <span class="bigger-110 no-text-shadow">修改</span>
                </button>
                <span> &nbsp;&nbsp;</span>
                <button class="btn btn-xs   btn-danger" id="delForm">
                    <i class="ace-icon fa fa-university bigger-110"></i>
                    <span class="bigger-110 no-text-shadow">删除</span>
                </button>
            </div>

            <div class="space-2"></div>
            <div class="hr hr-dotted"></div>

            <div class="page-header">
                <form class="form-inline" id="search-form">
                    <label class="inline input-sm">
                        <span class="lbl">姓名：</span>
                    </label>

                    <div class="form-group">
                        <input id="struename" name="struename" type=text class="form-control input-sm"
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

            
            <!--团队树-->
			<div class="modal fade" id="myModal-tree" style="z-index:999999;">
			    <div class="modal-dialog modal-sm">
			        <div class="modal-content">
			            <div class="modal-header ">
			                <button type="button " class=" close" data-dismiss="modal"><span
			                        aria-hidden="true">&times;</span><span
			                        class="sr-only">Close</span></button>
			                <h4 class="modal-title ">增加</h4>
			            </div>
			            <div class="modal-body">
			                <div class="space-2"></div>
			                <div class="hr hr-dotted"></div>
			                <div class="scrollable" data-height="300">
			                    <div class="content">
			                        <div id="tree"></div>
			                    </div>
			                </div>
			                <div class="space-2"></div>
			                <div class="hr hr-dotted"></div>
			                <div>所选的团队: <span id="echoSelection">-</span></div>
			                <div class="space-2"></div>
			                <div class="hr hr-dotted"></div>
			                <button class="btn btn-xs   btn-pink" id="btnSelectAll">
			                    <i class="ace-icon fa  	fa-check-square-o   bigger-110"></i>
			                    <span class="bigger-110 no-text-shadow">全选</span>
			                </button>
			                <span> &nbsp;&nbsp;</span>
			                <button  class="btn btn-xs  btn-purple" id="btnDeselectAll">
			                    <i class="ace-icon fa  	fa-square-o   bigger-110"></i>
			                    <span class="bigger-110 no-text-shadow">不选</span>
			                </button>
			                <span> &nbsp;&nbsp;</span>
			                <button  class="btn btn-xs  btn-yellow" id="btnToggleSelect">
			                    <i class="ace-icon fa  	fa-adjust    bigger-110"></i>
			                    <span class="bigger-110 no-text-shadow">反选</span>
			                </button>
			                <span> &nbsp;&nbsp;</span>
			                <button  class="btn btn-xs  btn-grey" id="btnOk">
			                    <i class="ace-icon fa  	fa-adjust    bigger-110"></i>
			                    <span class="bigger-110 no-text-shadow">确定</span>
			                </button>
			            </div>
			        </div>
			        <p></p>
			    </div>
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
                                    <label class="control-label col-xs-12 col-sm-4 no-padding-right"  >账号：</label>

                                    <div class="col-xs-12 col-sm-8">
                                        <div class="clearfix">
                                            <input id="user_name" class="input-sm" type="text" value=""
                                                   name="user_name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">用户组：</label>

                                    <div class="col-xs-12 col-sm-4">
                                        <div class="clearfix">
                                            <select class=" form-control input-sm " id="sys_group_id" name="sys_group_id">
                                                <option  >请选择</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">所属团队：</label>

                                    <div class="col-xs-12 col-sm-4">
                                        <div class="clearfix">
			                                <a class="btn btn-xs   btn-info" id="treeSelect">
									            <i class="ace-icon fa   fa-leaf   bigger-110"></i>
									            <span class="bigger-110 no-text-shadow">选择团队</span>
									        </a>
									    </div>
									    <div class="clearfix">
									           <input type="text" id="team" name="team" readonly="readonly">
									    </div>
                                    </div>
                                </div>
                                
                                <div class="form-group ">
                                    <label class="control-label col-xs-12 col-sm-4 no-padding-right" >密码：</label>

                                    <div class="col-xs-12 col-sm-8">
                                        <div class="clearfix">
                                            <input id="password" class="input-sm" type="password" value=""
                                                   name="password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label col-xs-12 col-sm-4 no-padding-right"  >姓名：</label>

                                    <div class="col-xs-12 col-sm-8">
                                        <div class="clearfix">
                                            <input id="truename" class="input-sm" type="text" value=""
                                                   name="truename" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label col-xs-12 col-sm-4 no-padding-right"   >邮箱：</label>

                                    <div class="col-xs-12 col-sm-8">
                                        <div class="clearfix">
                                            <input id="email" class="input-sm" type="text" value=""
                                                   name="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label col-xs-12 col-sm-4 no-padding-right">是否启用：</label>
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="clearfix">
                                            <select class=" form-control input-sm " id="flag_valid" name="flag_valid">
                                                <option value="0">无效</option>
                                                <option value="1">有效</option>
                                            </select>
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
                user_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15,
                   // isEnglish:true
                },
                password: {
                    required: true
                },
                truename: {
                    required: true,
                   // isChinese:true
                },
                email: {
                    required: true,
                    email:true
                }
            },
            messages: {
                user_name: {
                    required: "请输入账号",
                    minlength: "账号需要3-15个字符",
                    maxlength: "账号需要3-15个字符"
                },
                password: {
                    required: "请输入密码",
                    minlength: "账号需要3-15个字符",
                    maxlength: "账号需要3-15个字符"
                },
                truename: {
                    required: "请输入中文名"
                },
                email: {
                    required: "请输入Email",
                    email:"请输入Email地址"

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
            console.log(p,data[p]);
            if(p=='createdate'||p=='group_name'){
                continue;
            }else if(p=='sys_group_id'){
                var se = $("#sys_group_id").empty();
                $("<option value=" + data[p] + ">" + data['group_name'] + "</option>").appendTo(se);
            }else{
                $(eval(p)).val(data[p]);
            }
            $('#myModal-add').modal('show');
        }
    }

    $("#editForm").click(function (e) {
        postUrl = 'sys/useredit';
        var data = mmg.selectedRows();
        validForm.resetForm();
        $('.form-group').removeClass('has-error');
        if (data.length == 1) {
            editForm(data[0]);
        } else if (data.length > 1) {
            bootbox.alert({
                message: "<h4>只能选择一行修改！</h4>",
                buttons: {
                    ok: {
                        label: "确定",
                        className: "btn-primary btn-sm fa fa-check"
                    }
                }
            });
            return false;
        } else {
            bootbox.alert({
                message: "<h4>请选择要修改的行！</h4>",
                buttons: {
                    ok: {
                        label: "确定",
                        className: "btn-primary btn-sm fa fa-check"
                    }
                }
            });
            return false;
        }
    });
    $("#addForm").click(function (e) {
        postUrl = 'sys/useradd';
        $('.modal-title').text('增加');
        validForm.resetForm();
        $('.form-group').removeClass('has-error');
        $("#myform")[0].reset();
        $('#myModal-add').modal('show');
    });
    $('.date-picker').datepicker({autoclose: true});


    var renderStatus = function (val) {
        if (val == 0) {
            return '<span class="label label-primary ">无效</span>';
        } else if (val == 1) {
            return '<span class="label label-success ">有效</span>';
        }
    }
    //列
    var cols = [
        { title: 'ID', name: 'id', width: 100, align: 'center', sortable: true },
        { title: '中文拼音', name: 'user_name', width: 100, align: 'center', sortable: true},
        { title: '中文名', name: 'truename', width: 60, align: 'center'},
        { title: 'Email', name: 'email', width: 60, align: 'center'},
        { title: '用户组', name: 'group_name', width: 60, align: 'center'},
        { title: '团队', name: 'team', width: 60, align: 'center'},
        { title: '是否有效', name: 'flag_valid', width: 60, align: 'center', renderer: renderStatus},
        { title: '创建时间', name: 'createdate', width: 60, align: 'center'}
    ];
    //AJAX示例
    var mmg = $('#table-data').mmGrid({
        cols: cols,
        url: 'sys/userget_list',
        method: 'post',
        remoteSort: true,
        root: 'items',
        height: '350px',
        fullWidthRows: true,
        params: function () {
            return {"truename": $('#struename').val()};
        },
        plugins: [
            $('#paginator-div').mmPaginator({limitList: [20, 30, 40, 50]})
        ],
        checkCol: true,
        indexColWidth: 45,
        showBackboard: false

    });

    $('#search').on('click', function () {
        mmg.load({page: 1});
        return false;
    });
    $('#reset').on('click', function () {
        $('#myform')[0].reset();
    });


    $('#delForm').on('click', function () {
        var data = mmg.selectedRows();
        if (data.length == 0) {
            bootbox.alert({
                message: "<h4>请选择要选择删除的行！</h4>",
                buttons: {
                    ok: {
                        label: "确定",
                        className: "btn-primary btn-sm fa fa-check"
                    }
                }
            });
        } else {
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
                            var arr = new Array();
                            for (var i = 0; i < data.length; i++) {
                                arr.push(data[i]['id']);
                            }
                            var arr = arr.join(',');
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "sys/userdelete",
                                data: {'id': arr},
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
    $('#refresh').on('click', function () {
        $('#search-form')[0].reset();
        mmg.load({page: 1});
        return false;
    });
    $("#sys_group_id").focus(function () {
        var se = $("#sys_group_id");
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "sys/userget_group",
            success: function (data) {
                console.log(data);
                se.empty();
                $.each(data, function (i, n) {
                    $("<option value=" + n.id + ">" + n.group_name + "</option>").appendTo(se);
                });
            }
        });
    });
    
    $("#treeSelect").click(function (e) {
	    $('.modal-title').text('业务模块选择');
	    $('#myModal-tree').modal('show');
	});
	$("#tree").fancytree({
	    ajax: { type: "POST", contentType: "application/json" },
	    source: {
	        url: "zcmdb/open/get_group_tree"
	    },
	    checkbox: true,
	    //selectMode: 1,
	    selectMode: 3,
	    select: function(event, data) {
	        var re =new RegExp("^_");
	        var arr;
	        // Get a list of all selected nodes, and convert to a key array:
	        var selKeys = $.map(data.tree.getSelectedNodes(), function(node){
	            if (!re.test(node.key)){
	                return node.key;
	            }
	        });
	        $("#echoSelection").text(selKeys.join(","));
	        $("#team").val(selKeys.join(","));
	    },
	    dblclick: function(event, data) {
	        data.node.toggleSelected();
	    },
	    keydown: function(event, data) {
	        if( event.which === 32 ) {
	            data.node.toggleSelected();
	            return false;
	        }
	    },
	    cookieId: "fancytree-Cb3",
	    idPrefix: "fancytree-Cb3-"
	});
	$("#btnToggleSelect").click(function(){
	    $("#tree").fancytree("getRootNode").visit(function(node){
	        node.toggleSelected();
	    });
	    return false;
	});
	$("#btnDeselectAll").click(function(){
	    $("#tree").fancytree("getTree").visit(function(node){
	        node.setSelected(false);
	    });
	    return false;
	});
	$("#btnSelectAll").click(function(){
	    $("#tree").fancytree("getTree").visit(function(node){
	        node.setSelected(true);
	    });
	    return false;
	});
	$("#btnOk").click(function(){
	    $('#myModal-tree').modal('hide');
	});
	
	$('.scrollable').each(function () {
        var $this = $(this);
        $(this).ace_scroll({
            size: $this.data('size') ||300
            //styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
        });
    });

    autoHeight(120);

});
</script>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.page-content-area -->

