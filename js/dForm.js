(function($) {
	function get_elementClass_by_id(idName) {
		var ClassName = '';
		var name_input = parseInt($('#name_input').val());
		name_input  = name_input + 1;
		$('#name_input').val(name_input);
		
		switch(idName) {
			case 'dForm-heading':
				ClassName = 'dForm_Heading';
				break;
			case 'dForm-textbox':
				ClassName = 'dForm_textbox';
				$('#dForm_lib .'+ClassName+' > div > div > input').attr('name','textbox_'+name_input);
				break;
			case 'dForm-textarea':
				ClassName = 'dForm_textarea';
				$('#dForm_lib .'+ClassName+' > div > div > textarea').attr('name','textarea_'+name_input);
				break;
			case 'dForm-dropdown':
				ClassName = 'dForm_dropdown';
				$('#dForm_lib .'+ClassName+' > div > div > select').attr('name','select_'+name_input);
				break;
			case 'dForm-radio':
				ClassName = 'dForm_radio';
				$('#dForm_lib .'+ClassName+' > div > div input').attr('name','radio_'+name_input);
				break;
			case 'dForm-checkbox':
				ClassName = 'dForm_checkbox';
				$('#dForm_lib .'+ClassName+' > div > div input').attr('name','checkbox_'+name_input+'[]');
				break;
			case 'dForm-matrix':
				ClassName = 'dForm_matrix';
				break;
			case 'dForm-submit':
				ClassName = 'dForm_submit';
				break;
		}
		return ClassName;
	}
	$(document).ready(function(){
		//Disable enter key
		$("input:text").live('keypress',function(event) {
			if (event.keyCode == 13) {
				done_editting_inline();
				event.preventDefault();
				return false;
			}
		});
		
		//Confirm box
		$('#closeDForm').click(function(){
			return confirm('Are you sure want to leave this form ?');
		});
		
		//Button submit
		$('#saveDForm').click(function(){
			$('#your_dForm_form').submit();
		});
		$('#UpdateDForm').click(function(){
			$('#your_dForm_form').submit();
		});
		//Submit save form
		$('#your_dForm').live('submit',function(){
			//Hide all popup
			$('.option_popup').hide();
			
			var text_edit = [];
			var form_html = $(this).html();
			var form_title = $('#rightPanel > div > h3').text();
			var update_F = 0;
			
			$('#your_dForm .lef_label').each(function() {
				var require_= 'no';
				var data_ = 'no';
				var name_ = '';
				var text_edit_ = '';
				
				text_edit_ = $(this).text().replace("'", '');
				
				if($(this).parent().find('.option_popup .requiteField').is(':checked')) {
					require_ = 'require';
				}
				
				if($(this).parent().find('.input_element')) {
					name_ = $(this).parent().find('.input_element:first-child').attr('name');
				}
				
				if($(this).parent().find('.option_popup .data_op')) {
					data_ = $.trim($(this).parent().find('.option_popup .data_op').val());
				}
				
				if($(this).hasClass('matrix_l')) {
					data_ = [];
					data_.push($.trim($(this).parent().find('.option_popup .data_rows').val()));
					data_.push($.trim($(this).parent().find('.option_popup .data_columns').val()));
					name_ = [];
					$(this).parent().find('.dataMatrix tr th').next('td').each(function(){
						name_.push($(this).find('input').attr('name'));
					});
					text_edit.push([name_,data_,text_edit_]);
				}
				else {
					text_edit.push(text_edit_+'|'+name_+'|'+require_+'|'+data_);
				}
				
			});
			
			if($('#UpdateDForm').is(':visible')) {
				update_F = $('#postID').val();
			}
			$.ajax({
				type: "POST",
				url: myAjax.ajaxurl + "/wp-admin/admin-ajax.php",
				async: false,
				data: {
					action:"save_form",
					"update": update_F,
					"html":encodeURIComponent(form_html),
					"formElement":text_edit,
					"formTitle":form_title
				},
				success: function(html){
					if(html != 'ok') {
						alert('Can not save form!');
					}
					else {
						location.href = myAjax.ajaxurl + '/wp-admin/admin.php?page=dForm-x';
					}
								
				}
			});
			return false;
		});
		//Add element to form  by click
		$('#dform_tools a').click(function (){
			var text_action =  $(this).attr('id');
			var ClassName = get_elementClass_by_id(text_action);
			
			if(text_action == 'dForm-matrix') {
				$('#dForm_lib .'+ClassName+' .data_rows').blur();
			}
			
			$('#dForm_lib .'+ClassName).clone().appendTo('#your_dForm form');
			$('.dFormElement').sortable('refresh'); //Refrest sortable when add new element
		});
		//Option popup open
		$('.option_element').live('click', function(){
			if($('.option_popup').is(':visible')) {
				$('.option_popup').fadeOut();
			}
			else {
				$(this).next('.option_popup').fadeIn();
			}
		});
		
		//otherValue option
		$('.otherValue').live('click', function() {
			var dFormElement = $(this).parents('div.dFormElement');
			var name_ = dFormElement.find('.input_element').attr('name');
			if($(this).is(':checked')) {
				dFormElement.find('ul').append('<li><span class="other_element"><input type="radio" value="other_textbox" class="input_element" name="'+name_+'"/><input type="text" name="'+name_+'_other"/></span></li>');
				//Set value to Requite
				$(this).attr('checked','checked');
			} 
			else {
				dFormElement.find('.other_element').parent().remove();
				//Remove value to Requite
				$(this).removeAttr('checked');
			}
		});
		
		//Requite option
		$('.requiteField').live('click', function() {
			var dFormElement = $(this).parents('div.dFormElement');
			if($(this).is(':checked')) {
				dFormElement.find('.lef_label').append('<span class="require_field_char">*</span>');
				//Set value to Requite
				$(this).attr('checked','checked');
			} 
			else {
				dFormElement.find('.require_field_char').remove();
				//Remove value to Requite
				$(this).removeAttr('checked');
			}
		});
		
		//Radio choice option
		$('.radio_choice').live('click', function() {
			var dFormElement = $(this).parents('div.dFormElement');
			var array_val_columns = $(this).parents('div.option_popup').find('.data_columns').val().trim().split('\n');
			var array_val_rows = $(this).parents('div.option_popup').find('.data_rows').val().trim().split('\n');
			var elementHTML = '';
			var type_ = '';
			
			var name_input = parseInt($('#name_input').val());
			name_input  = name_input + 1;
			$('#name_input').val(name_input);
			
			if($(this).is(':checked')) {
				type_ = 'radio';
				
				elementHTML = gen_html_Matrix(array_val_rows,array_val_columns,name_input,type_);
				dFormElement.find('.dataMatrix').replaceWith(elementHTML);
				//Set value to Requite
				$(this).attr('checked','checked');
			} 
			else {
				type_ = 'checkbox';
				
				elementHTML = gen_html_Matrix(array_val_rows,array_val_columns,name_input,type_);
				dFormElement.find('.dataMatrix').replaceWith(elementHTML);
				//Remove value to Requite
				$(this).removeAttr('checked');
			}
		});
		
		//Data option
		$('.data_op').live('blur',function(){
			var dFormElement = $(this).parents('div.dFormElement');
			var class_firt = dFormElement.attr('class').split(' ')[0];
			var type_of_element = class_firt.split('_')[1];
			var value_of_Data = $(this).val().trim();
			var array_val;
			var elementHTML = '';
			var name_input = parseInt($('#name_input').val());
			name_input  = name_input + 1;
			$('#name_input').val(name_input);
					
			//Set value to textarea
			$(this).html(value_of_Data);
			
			switch(type_of_element) {
				case 'Heading':
					break;
				case 'textbox':
					break;
				case 'textarea':
					break;
				case 'dropdown':
					array_val = value_of_Data.split('\n');
					elementHTML = '';
					for(i=0;i<array_val.length;i++) {
						if(array_val[i].trim() == '') continue;
						elementHTML += '<option value="'+array_val[i]+'" name="select_'+name_input+'">'+array_val[i]+'</option>';
					}
					$('div>select',dFormElement).html(elementHTML);
					break;
				case 'radio':
					array_val = value_of_Data.split('\n');
					elementHTML = '';
					
					for(i=0;i<array_val.length;i++) {
						if(array_val[i].trim() == '') continue;
						elementHTML += '<li><input value="'+array_val[i]+'" type="radio" class="input_element" name="radio_'+name_input+'"/>'+array_val[i]+'</li>';
					}
					
					//Other case checked
					if(dFormElement.find('.otherValue').is(':checked')) {
						elementHTML += '<li><span class="other_element"><input type="radio" value="other_textbox" class="input_element" name="radio_'+name_input+'"/><input type="text" name="radio_'+name_input+'_other"/></span></li>';
					}
					
					dFormElement.find('ul').html(elementHTML);
					
					break;
				case 'checkbox':
					array_val = value_of_Data.split('\n');
					elementHTML = '';
					for(i=0;i<array_val.length;i++) {
						if(array_val[i].trim() == '') continue;
						elementHTML += '<li><input value="'+array_val[i]+'" type="checkbox" class="input_element" name="checkbox_'+name_input+'[]"/>'+array_val[i]+'</li>';
					}
					dFormElement.find('ul').html(elementHTML);
					break;
				case 'matrix':
					array_val = value_of_Data.split('\n');
					elementHTML = '';
					var type_ = 'checkbox';
					
					if($(this).parents('div.option_popup').find('.radio_choice').is(':checked')) {
						type_ = 'radio';
					}
					
					if($(this).hasClass('data_rows')) {
						var array_val_columns = $(this).parents('div.option_popup').find('.data_columns').val().trim().split('\n');
						elementHTML = gen_html_Matrix(array_val,array_val_columns,name_input,type_);
					}
					else {
						var array_val_rows = $(this).parents('div.option_popup').find('.data_rows').val().trim().split('\n');
						elementHTML = gen_html_Matrix(array_val_rows,array_val,name_input,type_);
					}
					dFormElement.find('.dataMatrix').replaceWith(elementHTML);
					break;
				case 'submit':
					$('div>input',dFormElement).val(value_of_Data);
					break;
			}
		});
		
		//Remove element
		$('.remove_element').live('click', function() {
			$(this).parent().parent().fadeOut(function(){
				$(this).remove()
			});
		});
		
		//Click to edit
		$('.able_edit').live('click', function() {
			if(!$(this).hasClass('editting')) {
				
				done_editting_inline();
				$(this).addClass('editting');
				var textContent = $(this).text();
				$(this).html('<input type="text" value="'+textContent+'" class="edit_val" />');
			}
		});
		
									 
		//Click to document - done all editting input
		//Done all popup
		$(document).click(function(){
			if(!$('.editting').is(':hover')) {
				done_editting_inline();
			}
			var popupvisible = $('.option_popup:visible');
			if(!popupvisible.is(':hover') && !popupvisible.prev('.option_element').is(':hover')) {
				$('.option_popup').fadeOut();
				$('.data_op:visible').blur();
			}
		});
		
		//Sortable
		$('#your_dForm').sortable({ 
			axis: 'y',
			items: '.dFormElement',
			forcePlaceholderSize: true,
			dropOnEmpty: true,
			opacity: 0.7, 
			placeholder: 'sortable-placeholder'
		});
		//Dragable
		$( '#dform_tools > li' ).draggable({
			connectToSortable: '#your_dForm',
			revert: 'invalid',
			helper: 'clone',
			cursor: 'move',
			stop: function(event,ui){

				var idElement = ui.helper.find('a').attr('id');
				var ClassName = get_elementClass_by_id(idElement);
				
				if(idElement == 'dForm-matrix') {
					$('#dForm_lib .'+ClassName+' .data_rows').blur();
				}
				
				$('#your_dForm li a#'+idElement).parent().replaceWith($('#dForm_lib .'+ClassName).clone());
				$('.dFormElement').sortable('refresh'); //Refrest sortable when add new element
			}
			
		});
		
		
		//In submisstion result page.
		$('#submisstion_t tbody tr').click(function (){
			$('#submisstion_t tbody tr.active').removeClass('active');
			$(this).addClass('active');
			display_detail_row();
		});
		$(document).keydown(function(e) {
			if($('#submisstion_t tbody tr.active')){
				var keyCode = e.keyCode || e.which,
				arrow = {
					left: 37, 
					up: 38, 
					right: 39, 
					down: 40
				};
				switch (keyCode) {
					case arrow.up:
						if($('#submisstion_t tbody tr.active').prev('tr').is(':visible')) {
							$('#submisstion_t tbody tr.active').removeClass('active').prev('tr').addClass('active');
						}
						break;
					case arrow.down:
						if($('#submisstion_t tbody tr.active').next('tr').is(':visible')) {
							$('#submisstion_t tbody tr.active').removeClass('active').next('tr').addClass('active');
						}
						break;
				}
				display_detail_row();
			}
		});
	})
	
	function display_detail_row(){
		var textArray = [];
		$('#submisstion_t tbody tr.active > td').each(function() {
			textArray.push($(this).html());
		});
		$('#submisstion_t_detail td.data_s').each(function(i){
			$(this).html(textArray[i]);
		})
	}
	
	function done_editting_inline(){
		
		if($('.able_edit').hasClass('editting')) {
			//get value from text 
			var textBoxContent = $('.able_edit.editting input.edit_val').val();
			//Set value to element
			$('.able_edit.editting').html(textBoxContent).removeClass('editting');
		}
		
	}
	
	function gen_html_Matrix(dataRows, dataColumns,name_input,type_){
		var html_ = '';
		var dataRows_ = [];
		for(i=0;i<dataRows.length;i++) {
			if(dataRows[i].trim() == '') continue;
			dataRows_.push(dataRows[i]);
		}
		
		html_ += '<table cellspacing="0" cellpadding="4" width="60%" class="dataMatrix"><tr><th style="border:none">&nbsp;</th>';
		var width_percent = parseInt(100/(dataRows_.length+1));
		for(i=0;i<dataRows_.length;i++) {
			if(dataRows_[i].trim() == '') continue;
			html_ += '<th style="width:'+width_percent+'%">'+ dataRows_[i] +'</th>';
		}
		html_ += '</tr><tr>';
		
		for(j=0;j<dataColumns.length;j++) {
			if(dataColumns[j].trim() == '') continue;
			html_ += '<th align="left">'+ dataColumns[j] +'</th>';
			for(i=0;i<dataRows_.length;i++) {
				if(dataRows_[i].trim() == '') continue;
				if(type_ == 'checkbox') {
					html_ += '<td align="center"><input type="'+type_+'" value="'+ dataRows_[i] +'" name="'+j+'_matrix_'+name_input+'[]"></td>';
				} 
				else {
					html_ += '<td align="center"><input type="'+type_+'" value="'+ dataRows_[i] +'" name="'+j+'_matrix_'+name_input+'"></td>';
				}
				
			}
			html_ += '</tr><tr>';
		}
		html_ += '</table>';
		return html_;
	}
})(jQuery); // Call and execute the function immediately passing the jQuery object