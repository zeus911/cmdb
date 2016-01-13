<div class="main-content" id="page_div">
    <!-- #section:basics/content.breadcrumbs -->
    <div class="breadcrumbs" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="<?php echo site_url() ?>">首页</a>
            </li>
            <li><a href="javascript:void(0)" onclick="loadPage('sys/user_group')">用户组管理</a></li>
            <li class="active">权限配置</li>
        </ul>
        <!-- /.breadcrumb -->
    </div>
    <script>
        function changePermission(cb){
            if(cb.checked){
                var parent_id =$(cb).attr('parent_id');
                if(parent_id!=""){
                    if(!document.getElementById(parent_id).checked){
                        document.getElementById(parent_id).checked = true;
                        changePermission(document.getElementById(parent_id));
                    }
                }
            }else{
                var parent_id =$(cb).attr('parent_id');
                var id = cb.id;
                if(parent_id==""){
                    $("input[parent_id='"+id+"']").each(function(){
                        console.log(this);
                        if(this.checked){
                            this.checked = false;
                            changePermission(this);
                        }
                    });
                }
            }

            $.get("sys/group_permission/change?module_id="+cb.value+"&flag="+(cb.checked?1:0),
                { group_id:"<?php echo $group_id; ?>" } ,
                function(r){
                if(r==1000){

                }else{
                    alert("修改失败");
                }
            });
        }
    </script>
    <style>
        .ace-thumbnails li{
            border: 0;
            margin-top: 5px;
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 5px;
        }
        .widget-box{
            background: #fcfcfc;
            border: 1px solid #bebebe;
        }
        .lbl {
            font-size: 15px;
        }

    </style>
    <!-- /section:basics/content.breadcrumbs -->
    <div class="page-content">
        <div class="page-header">
            <div class="row">
                <div class="col-xs-12">
                    <button id="sort_save" href="javascript:void(0)" class="btn btn-pink btn-xs " onclick="loadPage('sys/user_group/index')">
                        <i class="ace-icon  btn-xs fa fa-undo bigger-110"></i>返回
                    </button>
                </div>
            </div>
        </div>
        <div class="page-content-area">
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <?php foreach ($permission as $module): ?>
                    <div class="col-sm-12 widget-box " style="opacity: 1; z-index: 0;border: 1px solid #f4f4f4">
                        <div class="widget-header">
                            <h5 style="padding: 5px"><?php echo $module['module_name'] ?></h5>
                        </div>

                        <div class="widget-body" style="padding-bottom: 20px">
                            <div class="widget-main padding-6 no-padding-left no-padding-right">
                                <ul class="ace-thumbnails">
                                    <?php foreach ($module['page'] as $value): ?>
                                      <li>
                                        <div class="widget-box widget-color-blue" style="min-width: 180px">
                                            <div class="widget-header">
                                                <h5><label style="padding: 0;margin: 0">
                                                        <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox"
                                                               onchange="changePermission(this)" parent_id="" id="<?php echo $value['id'] ?>"
                                                               value="<?php echo $value['id'] ?>" <?php if ($value['p'] !=0) {echo "checked";} ?> >
                                                        <span class="lbl"> <?php echo $value['module_name'] ?></span>
                                                    </label></h5>

                                            </div>

                                            <div class="widget-body">
                                                <?php if ( !empty($value['action'])): ?>
                                                <div class="widget-main">
                                                    <ul class="list-unstyled spaced2" module="{%$value.id%}">
                                                        <?php foreach ($value['action'] as $action): ?>
                                                          <li>
                                                            <label style="padding: 0;margin: 0">
                                                                <input name="form-field-checkbox" class="ace ace-checkbox-2" type="checkbox"
                                                                       onchange="changePermission(this)" parent_id="<?php echo $value['id'] ?>"
                                                                       value="<?php echo $action['id'] ?>" <?php if ($action['p'] !=0) {echo "checked";} ?> >
                                                                <span class="lbl"><?php echo $action['module_name'] ?></span>
                                                            </label>
                                                        </li>
                                                        <?php endforeach; ?>

                                                    </ul>

                                                </div>

                                                <?php endif; ?>
                                            </div>

                                        </div>
                                    </li>

                                    <?php endforeach; ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

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
