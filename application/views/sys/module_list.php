<div class="main-content" id="page_div">
<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="<?php echo site_url() ?>">首页</a>
        </li>
        <li class="active">模块管理</li>
    </ul>
    <!-- /.breadcrumb -->
</div>

<!-- /section:basics/content.breadcrumbs -->
<div class="page-content">
<div class="page-content-area">
<div class="row">
<div class="col-xs-12">
<!-- PAGE CONTENT BEGINS -->
<div class="page-header">

    <div class="row">
        <div class="col-xs-12">
            <a href="javascript:void(0)" class="btn btn-success btn-xs" onclick="loadPage('sys/module/add?module_type=module')">
                <i class="ace-icon fa fa-plus bigger-110"></i>新建
            </a>
            <span> &nbsp;&nbsp;</span>
            <a id="sort_save" href="javascript:saveSort()" class="btn  btn-xs disabled">
                <i class="ace-icon fa fa-save bigger-110"></i>保存排序
            </a>
        </div>
    </div>
</div>
<table id="myTable" class="table table-striped  table-hover">
    <thead>
    <tr>


        <th>模块名称</th>
        <th style="width: 90px">操作</th>
    </tr>
    </thead>

    <tbody id="sortable1">
    <?php foreach ($list as $value): ?>
        <tr>
        <td colspan="2">
        <table class="table table-striped table-bordered table-hover" style="margin: 0">
        <tr>

            <td><a  href="javascript:void(0)" class="portlet-header" module="module" value="<?php echo $value['id'] ?> "><i
                        class="ace-icon fa fa-arrows bigger-110"></i><?php echo $value['module_name'] ?> </a></td>

            <td style="width: 90px">
                <div class="action-buttons">

                    <a class="orange"
                       href="javascript:void(0)"  onclick="loadPage('sys/module/add?module_parent_id=<?php echo $value['id'] ?>&module_type=page')"
                       title="添加页面">
                        <i class="ace-icon fa fa-plus bigger-130"></i>
                    </a>

                    <a class="green"
                       href="javascript:void(0)"  onclick="loadPage('sys/module/edit?id=<?php echo $value['id'] ?>')">
                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                    </a>

                    <div class="inline position-relative">

                        <a href="#" class="red dropdown-toggle" data-toggle="dropdown" data-position="auto">
                            <i class="ace-icon fa fa-trash-o icon-only bigger-130"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                            <li>
                                <a href="javascript:void(0)" onclick="deleteEntity('<?php echo $value['id'] ?>',this)"
                                   class="tooltip-error" data-rel="tooltip" title=""
                                   data-original-title="Delete">
                                <span class="red">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </td>
        </tr>
        <?php if (!empty($value['children']) > 0): ?>
            <tr>
                <td colspan="2">
                    <table class="table table-striped table-bordered"
                           style="margin-bottom: 0px;width: 98%;float: right">
                        <tbody id="sortable_{%$value@index%}">
                        <?php foreach ($value['children'] as $page): ?>
                            <tr>
                                <td>
                                    <table class="table table-striped table-bordered" style="margin: 0">
                                        <tr>
                                            <td><a  href="javascript:void(0)" class="portlet-header1" module="page"
                                                   value="<?php echo $page['id'] ?>"><i
                                                        class="ace-icon fa fa-arrows bigger-110"></i> <?php echo $page['module_name'] ?>
                                                </a>
                                            </td>

                                            <td>
                                                <?php echo $page['module_resource'] ?>
                                            </td>

                                            <td style="width: 90px">
                                                <div class="action-buttons">
                                                    <a class="orange"
                                                       href="javascript:void(0)"  onclick="loadPage('sys/module/add?module_parent_id=<?php echo $page['id']  ?>&module_type=action')"
                                                       title="添加功能">
                                                        <i class="ace-icon fa fa-plus bigger-130"></i>
                                                    </a>

                                                    <a class="green"
                                                       href="javascript:void(0)"  onclick="loadPage('sys/module/edit?id=<?php echo $page['id']  ?>&module_type=action&parent_id=<?php echo $page['module_parent_id'] ?>')">
                                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                    </a>

                                                    <div class="inline position-relative">

                                                        <a href="#" class="red dropdown-toggle" data-toggle="dropdown"
                                                           data-position="auto">
                                                            <i class="ace-icon fa fa-trash-o icon-only bigger-130"></i>
                                                        </a>

                                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                            <li>
                                                                <a href="javascript:void(0)"
                                                                   onclick="deleteEntity('<?php echo $page['id'] ?>',this)"
                                                                   class="tooltip-error" data-rel="tooltip" title=""
                                                                   data-original-title="Delete">
                                                                    <span class="red">
                                                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>

                                            </td>
                                        </tr>
                                        <?php if (!empty($page['children']) > 0): ?>
                                            <tr>
                                                <td colspan="3">
                                                    <table class="table table-striped table-bordered"
                                                           style="margin-bottom: 0px;width: 98%;float: right">
                                                        <tbody>
                                                        <?php foreach ($page['children'] as $action): ?>
                                                            <tr>
                                                                <td><?php echo $action['module_name'] ?></td>

                                                                <td>
                                                                    <?php echo $action['module_resource'] ?>
                                                                </td>

                                                                <td style="width: 70px">
                                                                    <div class="action-buttons">
                                                                        <a class="green"
                                                                           href="javascript:void(0)"  onclick="loadPage('sys/module/edit?id=<?php echo $action['id']  ?>&parent_id=<?php echo $action['module_parent_id'] ?>')">
                                                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                                        </a>
                                                                        <div class="inline position-relative">

                                                                            <a href="#" class="red dropdown-toggle"
                                                                               data-toggle="dropdown"
                                                                               data-position="auto">
                                                                                <i class="ace-icon fa fa-trash-o icon-only bigger-130"></i>
                                                                            </a>
                                                                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                                <li>
                                                                                    <a href="javascript:void(0)"
                                                                                       onclick="deleteEntity('<?php echo $action['id'] ?>',this)"
                                                                                       class="tooltip-error"
                                                                                       data-rel="tooltip"
                                                                                       title=""
                                                                                       data-original-title="Delete">
                                                                                    <span class="red">
                                                                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                                                    </span>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>

                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>

                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </table>


                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </td>
            </tr>
            </table>


            </td>
            </tr>

        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- PAGE CONTENT ENDS -->
<script>
    function deleteEntity(id, btn) {

        $.get("sys/module/delete?id=" + id, function (r) {
            if (r == 1000) {
                tr_row = btn.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode
                list_table = tr_row.parentNode;
                list_table.removeChild(tr_row);
            } else {
                alert("删除失败");
            }
        });

    }
    $(function () {
        $("#sortable1").sortable({
            update: function (event, ui) {
                $("#sort_save").removeClass('disabled');
                $("#sort_save").addClass('btn-warning');
            },
            handle: ".portlet-header"
        });
        $('tbody[id^=sortable_]').sortable({
            update: function (event, ui) {
                $("#sort_save").removeClass('disabled');
                $("#sort_save").addClass('btn-warning');
            },
            handle: ".portlet-header1"
        });

//        $( "#sortable" ).disableSelection();
    });
    function saveSort() {

        var idlist = "";
        var s = "";
        var data = {};
        $("#sortable1").find("a[module='module']").each(function () {
            if (idlist != "") {
                s = "|";
            }
            idlist = idlist + s + $(this).attr('value');
        });

        data['module'] = idlist;

        idlist = "";
        s = "";
        $("#sortable1").find("a[module='page']").each(function () {
            if (idlist != "") {
                s = "|";
            }
            idlist = idlist + s + $(this).attr('value');
        });
        data['page'] = idlist;


        $.post("sys/module/sort", data, function (r) {

            if (r == 1000) {

                $("#sort_save").removeClass('btn-warning');
                $("#sort_save").addClass('disabled');
            } else {
                alert("操作失败");
            }
        });
    }

    autoHeight(300);
</script>
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
