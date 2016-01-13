/**
 * @author terrydai
 * @desc 输入效果组件
 * @update2012/7/20
 */

var matrixSelectZindex = 100;
jQuery.fn.extend({
	//数量设置器
	amountSetter: function( options ){
		options = options || {};
		
		$(this).each(function(){
			var  obj = $(this), 
				input = $('input:text' , obj),
				adder = $('.add' ,obj),
				reducer = $('.reduce' , obj);
			
			//初始化input
			input.data('old-value', parseInt(input.val()));	
			
			$(obj).bind('click' , function(e){
				e.stopPropagation();	
			});
		
			adder.bind('click', function(){
				var max = parseInt(input.attr('data-max')),
					n = parseInt(input.val()),
					v;
				
				v  = n>= max? n: n+1;
				
				input.val(v);
				if( input.data('old-value') != v && $.isFunction(options.onChange)){
					options.onChange(input);
				}
				input.data('old-value' , v);
			});
			
			reducer.bind('click', function(){
				var min = parseInt(input.attr('data-min')),
				n = parseInt(input.val()),
				v;
				
				v = n<= min? min: n-1;
				input.val(v);
				
				if( v == 0 && $.isFunction(options.onClean)){
					options.onClean(input);
				}
				if( input.data('old-value') != v && $.isFunction(options.onChange)){
					options.onChange(input);
				}
				input.data('old-value' , v);
			});
			
			input.bind('keyup',function(){
				var min = parseInt(input.attr('data-min')),
				max = parseInt(input.attr('data-max')),
				n = input.val(),
				v = n;
				
				if( /^[0-9]+$/.test(n)){
					//去掉前面的0，全是0则置为0
					v = v.replace(/^0+/ , '') || 0; 
					if(n>max){
						v = max;
					}else if(n<min){
						v = min;
					}
				} else{
					v = 0;
				}
				input.val(v);
				
				if( v == 0 && $.isFunction(options.onClean)){
					options.onClean(input);
				}
				if( input.data('old-value') != v && $.isFunction(options.onChange)){
					options.onChange(input);
				}
				input.data('old-value' , v);
			});
		});
	},
	
	// 对普通输入框点击显示下拉框
	multiText: function(){
		$(this).bind('click' , showClipboard);
		function showClipboard(e){
			var obj = $(this),
				offset = obj.offset(),
				width = obj.innerWidth()-3;
			
			if ($('#matrix-multiText').length == 0) {
				$('<div id="matrix-multiText"><textarea onfocus="select()"></textarea></div>').appendTo('body');
			}
			
			// 基础事件绑定
			$('#matrix-multiText>textarea').unbind('blur').blur(function(){
				var  obj = $(this),
					target = obj.data('target');
				
				// 回写
				target.val( $.trim(obj.val()).replace(/\s+/g, ','));
				
				// 重置
				$('#matrix-multiText').hide();
			});
			
			// 重复使用
			$('#matrix-multiText').css(offset).show();
			$('#matrix-multiText>textarea').data('target',obj).val(obj.val().replace(/,/g, '\n')).focus().css({'width': width});
		}
		return this;
	},
	
	dropSelect: function( options){
		var selected = this.find('.selected a'),
			obj = this;
		
		if(typeof  options === 'string'){
			switch(options){
				case 'selected':
					return selected.attr('data-value');
				case 'selected_text':
					return selected.text();
				case 'reset':
					obj.find('a').removeClass('on');
					selected.replaceWith(obj.children('ul').find('a').eq(0).clone());
					break;
				case 'select_default':
					obj.find('a').each(function(){
						if($(this).attr('data-value') == selected.attr('data-value')){
							$(this).addClass('on');
						}
					});
				default:
					break;
				}
		}else if( typeof options === 'object'){
			//matrix-select control
			this.each(function(){
				var thisZindex = matrixSelectZindex--;
				$(this).css({'z-index':thisZindex});
				var selectedWidth = $(this).children('p').width();
				var listWidth = $(this).children('ul').width();
				// 含class 'no-resize'的话不重置宽度
				if($(this).hasClass('no-resize')){
					$(this).children('p').show().css({'z-index':thisZindex});
					$(this).children('ul').css({'z-index':thisZindex-1});
				} else {
					$(this).children('p').width(Math.min(Math.max(selectedWidth, listWidth) + 10, 130)).show().css({'z-index':thisZindex});
					$(this).children('ul').width(Math.max(selectedWidth, listWidth) + 35).css({'z-index':thisZindex-1});
				}
			});
			
			obj.hover(
				function(){
					$(this).addClass('hover').children('ul').show();
				}, function(){
					$(this).removeClass('hover').children('ul').hide();
			});
			
			// 绑定
			obj.find('a').bind('click' , function(){
				var on = $(this),
					selected = obj.find('.selected a');
				// 如果已经选中
				if( on.hasClass('on')){
					return;
				}
								
				// 切换选中
				obj.find('a').removeClass('on');
				on.addClass('on');
				
				// 更新最新
				selected.replaceWith(on.clone());
				
				// 执行动作
				if(options.handler){
					options.handler(on.attr('data-value'), on.text(), on.attr('extend-attr'));	
				}
				
				obj.removeClass('hover').children('ul').hide();
			});
		}
		return this;
	}
});

$(document).ready(function(){
	//日期图标展示
	$('.datebox_arrow').click(function(){
		$(this).siblings('input').datepicker( "show" );
	});
});
