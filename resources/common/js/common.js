/**
 * Created by wenhua on 14-7-25.
 */
//获取URL地址hash参数的值
function getQueryStringRegExp(name,getAfter) {
	var reg = new RegExp('(^|\\?|&|#)' + name + '=([^&]*)(\\s|&|$)', 'i');
	if(getAfter){
		var reg = new RegExp('(^|\\?|&|#)' + name + '=(.*)(.*)', 'i');
	}
	if (reg.test(location.hash)) return decodeURIComponent(RegExp.$2.replace(/\+/g, ' '));
	return '';
}

$(function(){
	var isClickTriggerHashChange=false;
	var goUrl=getQueryStringRegExp("loadPage",true);
	if(goUrl) {
		loadPage(goUrl);
		$(".nav-list a").each(function (index) {
			if (goUrl == $(this).attr("href")) {
				$(this).closest("li").addClass("active");
				return false;
			}
		});
	}
	$(".nav-list a").click(function(){
		isClickTriggerHashChange=true;
        var href=$(this).attr("href");
        if(href!="#"){
            location.hash="loadPage="+href;
        }
	});

	window.onhashchange = function(){
		var goUrl=getQueryStringRegExp("loadPage",true);
		if(!isClickTriggerHashChange) {
			loadPage(goUrl);
			$(".nav-list a").parent().removeClass("active").end().each(function (index) {
				if (goUrl == $(this).attr("href")) {
					$(this).closest("li").addClass("active");
					return false;
				}
			});
		}
		isClickTriggerHashChange=false;
	};

    $(document).ajaxError(function( event, jqXHR, ajaxSettings, thrownError) {
        console.info('ajaxError-------',arguments);
        if(jqXHR.status==401){
            try {
                var responseJson = $.parseJSON(jqXHR.responseText);
                if(responseJson.redirectUrl){
                    var r=confirm(responseJson.message);
                    if (r==true){
                        window.location.href=responseJson.redirectUrl;
                    }
                }else{
                    alert(responseJson.message);
                }
            } catch (e) {
                alert('服务器返回了未定义的数据格式，您可以尝试重新登录本系统或联系管理员！');
            }
        }
    });
});

function openPage(href,callBack){
	var openWhat=window.open("#loadPage="+(href),""/*,"alwaysLowered=yes,alwaysRaised=yes,z-look=yes"*/);
	//console.info(openWhat,openWhat.document);
	$(openWhat.window).load(function () {
		openWhat.$("#sidebar,#navbar").remove();
		var target = openWhat.document.querySelector('#page_div');
		var observer = new MutationObserver(function(mutations) {
			if(callBack){
				callBack(openWhat.$);
			}
			mutations.forEach(function(mutation) {
				//console.log(mutation);
			});
		});
		var config = { attributes: false, childList: true, characterData: false,subtree:true };
		observer.observe(target, config);
	});
}
function loadPage(href) {
    $("#page_div").load(href, function (response, status, xhr) {
        if (status == "error") {
            var msg = "Sorry but there was an error: ";
            $("#page_div").html(msg + xhr.status + " " + xhr.statusText);
        }else{
            $( ".modal-dialog" ).draggable({ cursor: "move", handle: ".modal-title",containment:"document"}).find(".modal-title").css("cursor","move");
            $('table.mmg-body').on("loadSuccess",function(e, data){
				var thisTable=$(this);
				if(thisTable.attr("export")){
					var opts = $(this).mmGrid().opts;
					var cols = opts.cols;
					var checkCol = opts.checkCol;
					var indexCol = opts.indexCol;
					var fieldMap = {},
						fieldArray = [];
					var skipPrefix=0;//跳过前面的几列，比如复选框和#号列
					var exclude=["indexCol","checkCol"];//导出时默认排除的列
					var userExclude=thisTable.attr("data-export-exclude");
					if(userExclude){
						exclude=exclude.concat(userExclude.split(","));
					}
					checkCol?skipPrefix++:null;
					indexCol?skipPrefix++:null;
					if(indexCol){
						fieldMap.indexCol = "索引列";
						fieldArray.push("indexCol");
					}
					if(checkCol){
						fieldMap.checkCol = "显示checkbox";
						fieldArray.push("checkCol");
					}
					$.each(cols, function (i, v) {
						//console.info("c",v.name,v.title);
						if(i<skipPrefix)return;
						fieldMap[v.name] = v.title;
						fieldArray.push(v.name);
					});
					//console.info("fieldMap",fieldMap, "fieldArray",fieldArray);
					var fieldMapToServer={};
					var fieldArrayToServer=[];//多余的
					var mapFunctionIndex=0;
					fieldMap=$.map(fieldMap,function(v,i){
						//console.info("map",v,i);
						if($.inArray(i,exclude)==-1){
							fieldMapToServer[i]=v;
							fieldArrayToServer.push(fieldArray[mapFunctionIndex]);
						}
						mapFunctionIndex++;
					});
					var rows = [];
					thisTable.find('tr').each(function (i, element) {
						var row = {};
						var td = $(this).find('td').each(function (i2, e2) {
							var colFieldName=fieldArray[i2];
							if($.inArray(colFieldName,exclude)==-1){
								row[colFieldName]=$(this).text();
							}
						});
						rows.push(row);
					});
					//console.info("上传的数据",fieldMapToServer,fieldArrayToServer,rows);
					var jsonStr=JSON.stringify({fieldMap:fieldMapToServer,rows:rows});
					//console.info(jsonStr);
					function makeForm()
					{
						var form1 = document.createElement('form');
						form1.id = 'form20150728';
						form1.name = 'form20150728';
						document.body.appendChild(form1);
						var input = document.createElement('input');
						input.type = 'hidden';
						input.name = 'rowData';
						input.value = jsonStr;
						form1.appendChild(input);
						form1.method = 'POST';
						form1.action = 'zcmdb/open/export_by_client';
						form1.submit();
						document.body.removeChild(form1);
					}
					makeForm();
					thisTable.removeAttr("export");
					thisTable.mmGrid().load();
				}

			});
            $("#export_button").off("click");
            $("#export_button").on("click", function() {
            	$('#table-data').mmGrid().attr("export","true").load({export:true});
				return false;
            });
			var nowPageTitile=$("#breadcrumbs .active").text();
			if(this.titleSuffix){
			}else{
				this.titleSuffix=$("title").text();
			}
			$("title").text(nowPageTitile+" - "+this.titleSuffix);
            $('.mmg-body').mmGrid().on('loadSuccess', function (e, data) {
            	showMarkRow();
            });

        }
    });
}

function test(ret) {
    alert(ret);
}
$(function () {
    $(".sidebar li a").click(function (e) {
        var href = $(this).attr("href");
        if (href == "#") {

        } else {
            loadPage(href)
            e.preventDefault();
        }

    });

});
$.fn.extend({
    // 替换class
    replaceClass: function (replaceClass, stayClass) {
        var newClass = replaceClass;
        if (stayClass) {
            newClass += stayClass;
        }
        this.attr('class', newClass);
        return this;
    }
});

$.extend({
    // 切换显示
    toggleShow: function (c1, c2, d) {

        if (d) {
            $(c1).show();
            $(c2).hide();
        }
        else {
            $(c1).hide();
            $(c2).show();
        }
    },

    popMessage: function (type, message) {
        if ($('#msg-pop').length == 0) {
            $('<div id="msg-pop"><span id="msg-pop-body"></span></div>').appendTo('body');
        }
        $('#msg-pop-body').replaceClass('msg-pop-' + type).html(message);
        $('#msg-pop').show().delay(2000).fadeOut(500);
    }
});
$(function () {
    $("#info").click(function (e) {
        $('.modal-title').text('个人信息');
        $('#myModal').modal('show');
    });
});

/*****************************************************************
 jQuery Validate扩展验证方法  (linjq)
 *****************************************************************/
$(function () {
    // 判断整数value是否等于0
    jQuery.validator.addMethod("isIntEqZero", function (value, element) {
        value = parseInt(value);
        return this.optional(element) || value == 0;
    }, "整数必须为0");

    // 判断整数value是否大于0
    jQuery.validator.addMethod("isIntGtZero", function (value, element) {
        value = parseInt(value);
        return this.optional(element) || value > 0;
    }, "整数必须大于0");

    // 判断整数value是否大于或等于0
    jQuery.validator.addMethod("isIntGteZero", function (value, element) {
        value = parseInt(value);
        return this.optional(element) || value >= 0;
    }, "整数必须大于或等于0");

    // 判断整数value是否不等于0
    jQuery.validator.addMethod("isIntNEqZero", function (value, element) {
        value = parseInt(value);
        return this.optional(element) || value != 0;
    }, "整数必须不等于0");

    // 判断整数value是否小于0
    jQuery.validator.addMethod("isIntLtZero", function (value, element) {
        value = parseInt(value);
        return this.optional(element) || value < 0;
    }, "整数必须小于0");

    // 判断整数value是否小于或等于0
    jQuery.validator.addMethod("isIntLteZero", function (value, element) {
        value = parseInt(value);
        return this.optional(element) || value <= 0;
    }, "整数必须小于或等于0");

    // 判断浮点数value是否等于0
    jQuery.validator.addMethod("isFloatEqZero", function (value, element) {
        value = parseFloat(value);
        return this.optional(element) || value == 0;
    }, "浮点数必须为0");

    // 判断浮点数value是否大于0
    jQuery.validator.addMethod("isFloatGtZero", function (value, element) {
        value = parseFloat(value);
        return this.optional(element) || value > 0;
    }, "浮点数必须大于0");

    // 判断浮点数value是否大于或等于0
    jQuery.validator.addMethod("isFloatGteZero", function (value, element) {
        value = parseFloat(value);
        return this.optional(element) || value >= 0;
    }, "浮点数必须大于或等于0");

    // 判断浮点数value是否不等于0
    jQuery.validator.addMethod("isFloatNEqZero", function (value, element) {
        value = parseFloat(value);
        return this.optional(element) || value != 0;
    }, "浮点数必须不等于0");

    // 判断浮点数value是否小于0
    jQuery.validator.addMethod("isFloatLtZero", function (value, element) {
        value = parseFloat(value);
        return this.optional(element) || value < 0;
    }, "浮点数必须小于0");

    // 判断浮点数value是否小于或等于0
    jQuery.validator.addMethod("isFloatLteZero", function (value, element) {
        value = parseFloat(value);
        return this.optional(element) || value <= 0;
    }, "浮点数必须小于或等于0");

    // 判断浮点型
    jQuery.validator.addMethod("isFloat", function (value, element) {
        return this.optional(element) || /^[-\+]?\d+(\.\d+)?$/.test(value);
    }, "只能包含数字、小数点等字符");

    // 匹配integer
    jQuery.validator.addMethod("isInteger", function (value, element) {
        return this.optional(element) || (/^[-\+]?\d+$/.test(value) && parseInt(value) >= 0);
    }, "匹配integer");

    // 判断数值类型，包括整数和浮点数
    jQuery.validator.addMethod("isNumber", function (value, element) {
        return this.optional(element) || /^[-\+]?\d+$/.test(value) || /^[-\+]?\d+(\.\d+)?$/.test(value);
    }, "匹配数值类型，包括整数和浮点数");

    // 只能输入[0-9]数字
    jQuery.validator.addMethod("isDigits", function (value, element) {
        return this.optional(element) || /^\d+$/.test(value);
    }, "只能输入0-9数字");

    // 判断中文字符
    jQuery.validator.addMethod("isChinese", function (value, element) {
        return this.optional(element) || /^[\u0391-\uFFE5]+$/.test(value);
    }, "只能包含中文字符。");

    // 判断英文字符
    jQuery.validator.addMethod("isEnglish", function (value, element) {
        return this.optional(element) || /^[A-Za-z]+$/.test(value);
    }, "只能包含英文字符。");

    // 手机号码验证
    jQuery.validator.addMethod("isMobile", function (value, element) {
        var length = value.length;
        return this.optional(element) || (length == 11 && /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value));
    }, "请正确填写您的手机号码。");

    // 电话号码验证
    jQuery.validator.addMethod("isPhone", function (value, element) {
        var tel = /^(\d{3,4}-?)?\d{7,9}$/g;
        return this.optional(element) || (tel.test(value));
    }, "请正确填写您的电话号码。");

    // 联系电话(手机/电话皆可)验证
    jQuery.validator.addMethod("isTel", function (value, element) {
        var length = value.length;
        var mobile = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
        var tel = /^(\d{3,4}-?)?\d{7,9}$/g;
        return this.optional(element) || tel.test(value) || (length == 11 && mobile.test(value));
    }, "请正确填写您的联系方式");

    // 匹配qq
    jQuery.validator.addMethod("isQq", function (value, element) {
        return this.optional(element) || /^[1-9]\d{4,12}$/;
    }, "匹配QQ");

    // 邮政编码验证
    jQuery.validator.addMethod("isZipCode", function (value, element) {
        var zip = /^[0-9]{6}$/;
        return this.optional(element) || (zip.test(value));
    }, "请正确填写您的邮政编码。");

    // 匹配密码，以字母开头，长度在6-12之间，只能包含字符、数字和下划线。
    jQuery.validator.addMethod("isPwd", function (value, element) {
        return this.optional(element) || /^[a-zA-Z]\\w{6,12}$/.test(value);
    }, "以字母开头，长度在6-12之间，只能包含字符、数字和下划线。");

    // 身份证号码验证
    jQuery.validator.addMethod("isIdCardNo", function (value, element) {
        //var idCard = /^(\d{6})()?(\d{4})(\d{2})(\d{2})(\d{3})(\w)$/;
        return this.optional(element) || isIdCardNo(value);
    }, "请输入正确的身份证号码。");

    // IP地址验证
    /*    jQuery.validator.addMethod("ip", function(value, element) {
     return this.optional(element) || /^(([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))\.)(([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))\.){2}([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))$/.test(value);
     }, "请填写正确的IP地址。");*/
    jQuery.validator.addMethod("ip", function (value, element) {
        var ip = /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
        return this.optional(element) || (ip.test(value) && (RegExp.$1 < 256 && RegExp.$2 < 256 && RegExp.$3 < 256 && RegExp.$4 < 256));
    }, "Ip地址格式错误");
    // 字符验证，只能包含中文、英文、数字、下划线等字符。
    jQuery.validator.addMethod("stringCheck", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\u4e00-\u9fa5-_]+$/.test(value);
    }, "只能包含中文、英文、数字、下划线等字符");

    // 匹配english
    jQuery.validator.addMethod("isEnglish", function (value, element) {
        return this.optional(element) || /^[A-Za-z]+$/.test(value);
    }, "匹配english");

    // 匹配汉字
    jQuery.validator.addMethod("isChinese", function (value, element) {
        return this.optional(element) || /^[\u4e00-\u9fa5]+$/.test(value);
    }, "匹配汉字");

    // 匹配中文(包括汉字和字符)
    jQuery.validator.addMethod("isChineseChar", function (value, element) {
        return this.optional(element) || /^[\u0391-\uFFE5]+$/.test(value);
    }, "匹配中文(包括汉字和字符) ");

    // 判断是否为合法字符(a-zA-Z0-9-_)
    jQuery.validator.addMethod("isRightfulString", function (value, element) {
        return this.optional(element) || /^[A-Za-z0-9_-]+$/.test(value);
    }, "判断是否为合法字符(a-zA-Z0-9-_)");

    // 判断是否包含中英文特殊字符，除英文"-_"字符外
    jQuery.validator.addMethod("isContainsSpecialChar", function (value, element) {
        var reg = RegExp(/[(\ )(\`)(\~)(\!)(\@)(\#)(\$)(\%)(\^)(\&)(\*)(\()(\))(\+)(\=)(\|)(\{)(\})(\')(\:)(\;)(\')(',)(\[)(\])(\.)(\<)(\>)(\/)(\?)(\~)(\！)(\@)(\#)(\￥)(\%)(\…)(\&)(\*)(\（)(\）)(\—)(\+)(\|)(\{)(\})(\【)(\】)(\‘)(\；)(\：)(\”)(\“)(\’)(\。)(\，)(\、)(\？)]+/);
        return this.optional(element) || !reg.test(value);
    }, "含有中英文特殊字符");


    //身份证号码的验证规则
    function isIdCardNo(num) {
        //if (isNaN(num)) {alert("输入的不是数字！"); return false;}
        var len = num.length, re;
        if (len == 15)
            re = new RegExp(/^(\d{6})()?(\d{2})(\d{2})(\d{2})(\d{2})(\w)$/);
        else if (len == 18)
            re = new RegExp(/^(\d{6})()?(\d{4})(\d{2})(\d{2})(\d{3})(\w)$/);
        else {
            //alert("输入的数字位数不对。");
            return false;
        }
        var a = num.match(re);
        if (a != null) {
            if (len == 15) {
                var D = new Date("19" + a[3] + "/" + a[4] + "/" + a[5]);
                var B = D.getYear() == a[3] && (D.getMonth() + 1) == a[4] && D.getDate() == a[5];
            }
            else {
                var D = new Date(a[3] + "/" + a[4] + "/" + a[5]);
                var B = D.getFullYear() == a[3] && (D.getMonth() + 1) == a[4] && D.getDate() == a[5];
            }
            if (!B) {
                //alert("输入的身份证号 "+ a[0] +" 里出生日期不对。");
                return false;
            }
        }
        if (!re.test(num)) {
            //alert("身份证最后一位只能是数字和字母。");
            return false;
        }
        return true;
    }


});
var messages = {
    required: "必选字段",
    remote: "请修正该字段",
    email: "请输入正确格式的电子邮件",
    url: "请输入合法的网址",
    date: "请输入合法的日期",
    dateISO: "请输入合法的日期 (ISO).",
    number: "请输入合法的数字",
    digits: "只能输入整数",
    creditcard: "请输入合法的信用卡号",
    equalTo: "请再次输入相同的值",
    maxlength: $.validator.format("请输入一个长度最多是 {0} 的字符串"),
    minlength: $.validator.format("请输入一个长度最少是 {0} 的字符串"),
    rangelength: $.validator.format("请输入一个长度介于 {0} 和 {1} 之间的字符串"),
    range: $.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
    max: $.validator.format("请输入一个最大为 {0} 的值"),
    min: $.validator.format("请输入一个最小为 {0} 的值")
};
jQuery.extend(jQuery.validator.messages, messages);


function boot_alert(message) {
    bootbox.alert({
        message: "<h4 class='break_word'>" + message + "</h4>",
        buttons: {
            ok: {
                label: "确定",
                className: "btn-primary btn-sm fa fa-check"
            }
        }
    });
}

function ajax_submit_form(button, form, url, method, callback) {
    var url = url || $(form).attr('action');
    var method = method || 'post';
    $(button).click(function () {
        console.log('hello world', form, button, url);
        $(form).ajaxSubmit({
            type: method,
            dataType: 'json',
            url: url,
            success: function (ret) {
                if (ret.code == 0) {
                    if (callback) {
                        callback(ret);
                    }
                } else {
                    boot_alert(ret.message);
                }

            },
            error: function (XmlHttpRequest, textStatus, errorThrown) {
                boot_alert("服务器繁忙");
            }
        });
        return false;
    });
}


function fillForm(data, form, filter_condition) {
    data = $.grep(data, function (value, key) {
        return filter_condition(value);
    });
    for (var p  in data) {
        var is_text = /(\w+)(_text)$/ig.test(p);
        if (!is_text) {
            var element = (form + " [name='" + p + "']");
            $(element).val(data[p]);
        }
    }
}
function autoHeight(adjust) {
    adjust = adjust || 220
    topOffset = 100;
    height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
    height = height - 80 - topOffset;
    if (height < 1) height = 1;
    if (height > topOffset) {
        $('.main-container').css("height", (height) + "px");
        $(".main-container").css("min-height", (height) + "px");
        var tableHeight = height - adjust - 30;
        if (tableHeight < 1) {
            tableHeight = 1;
        }
        $('#page_div div.mmGrid').css('min-height', (tableHeight) + 'px');
        $('#page_div div.mmGrid').css('height', (tableHeight) + 'px');
        $('#page_div div.mmg-bodyWrapper').css('height', tableHeight - 20 + 'px');


    }
}

//标记之前选中的行
function showMarkRow(){
	$(".mmg-body tr").removeClass('bg-danger');
	if(marks=$(".mmg-body").attr("data-mark")){
		marks=marks.split(',');
    	var rows=$('.mmg-body').mmGrid().rows();
    	if(rows.length<1) return false;
    	var whatAttribute=$(".mmg-body").attr("data-key")||'assets_id';
    	for (var i=0;i<rows.length;i++){
    		var rowID=rows[i][whatAttribute];
    		if($.inArray(rowID, marks)!==-1){
    			$(".mmg-body tr").eq(i).removeClass('even selected').addClass('bg-danger');
    		}
    	}
	}
}

function markSelectedRows(key){
	var selectedRows = $('.mmg-body').mmGrid().selectedRows();
	var marks = new Array();
	key = key || 'assets_id';
	$(".mmg-body").attr("data-key",key);
	for (row in selectedRows) {
	  marks.push(selectedRows[row][key]);
	}
	marks = marks.join();
	$(".mmg-body").attr("data-mark",marks);
}
$(function () {
    $(window).bind("load resize", function () {
        autoHeight();
    });

    //记录每次查询列表的参数用于导出
    $(document).ajaxComplete(function (event, request, settings) {
    	  //console.info(arguments);
    	  if (settings.url.search(/\/get_list$/i) !== - 1) {
    	    //console.info(' get_list  .');
    	    $('#export_button').attr('data-export', settings.data);
    	  } else {
    	    return;
    	  }
    });


});


