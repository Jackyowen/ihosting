jQuery(document).ready(function($){
	"use strict";
	var total = 0, next_percent = 1 , folder = '', post_index = 0, optionid='';
	function kt_progress_bar_handle(kt_import_percent){
		if( kt_import_percent > 100 )
			kt_import_percent = 100;
		var progress_bar = $('#option-'+optionid).find('.progress-circle .c100');
		var class_percent ='p'+Math.ceil( kt_import_percent );
		progress_bar.addClass(class_percent);
		progress_bar.find('.percent').html( Math.ceil( kt_import_percent ) + '%');
	}
	$(document).on('click','.kt-demo-importer',function(){
		$(this).closest('.option').find('.progress-wapper').show();
		folder = $(this).data('folder');
		optionid = $(this).data('optionid');
		kt_demo_importer();
	});

	function kt_demo_importer(){
		$.ajax({
			type:'POST',
			url: ajaxurl,
			data: {'action':'kt_demo_importer', 'folder':folder, 'post_total': total, 'post_index':post_index},
			dataType:'json',
			cache:false,
			async: false,
			beforeSend: function(){},
			complete: function(){},
			success: function(response){
				if(response.status == 'ok'){
					kt_progress_bar_handle(100);
					$('#option-'+optionid).find('.progress-wapper').addClass('complete');
				}else{
					post_index++;
					if(total == 0)
						total = response.post_total;
					if(total >0){
						next_percent = total/100;
						var percent = post_index/next_percent;
						kt_progress_bar_handle(percent);
					}
					setTimeout(function(){
						kt_demo_importer();
					}, 100);
				}
			}
		});
	}
	function kt_theme_options_exporter(){
		var file_name = $("#export_file_name").val();
		if(file_name == ""){
			alert('Enter file name, please');
			return false;
		}
		var export_file_overwrite = 0;
		if($("#export_file_overwrite").is(':checked')){
			export_file_overwrite = 1;
		}
		var data = {'action':'kt_theme_options_exporter', 'file_name':file_name, 'export_file_overwrite':export_file_overwrite};
		$.post(ajaxurl, data, function(response) {
			alert(response.msg);
			$("#export_file_name").val("");
			$("#kt-dialog-export-theme-options").dialog("close");
		});
	}

	$(".kt-theme-options-export").click(function(event) {
		event.preventDefault();
		//var data = $(this).data(), uniqid = $(this).data('uniqid');
		$("#kt-dialog-export-theme-options").dialog({
			title:  "Theme options exporter",
			dialogClass:'kt-dialog',
			width: 320,
			height: 'auto',
			modal:true,
			buttons: [
				{
					text: "Export",
					click: function() {
						kt_theme_options_exporter();
					}
				},
				{
					text: "Cancel",
					click: function() {
						$(this).dialog( "close" );
					}
				}
			]
		});
	});
	function kt_data_exporter() {
		var folder = $("#export_data_folder").val();
		if(folder == ""){
			alert("Enter folder name, please.");
			return false;
		}
		var data = {'action':'kt_demo_exporter', 'folder':folder};
		$.post(ajaxurl, data, function(response) {
			alert(response);
			$("#export_data_folder").val("");
			$("#kt-dialog-export-data").dialog("close");
		});
	}
	$(".kt-demo-exporter").click(function(event) {
		$("#kt-dialog-export-data").dialog({
			title:  "Data exporter",
			dialogClass:'kt-dialog',
			width: 320,
			height: 'auto',
			modal:true,
			buttons: [
				{
					text: "Export",
					click: function() {
						kt_data_exporter();
					}
				},
				{
					text: "Cancel",
					click: function() {
						$(this).dialog( "close" );
					}
				}
			]
		});
	});

	function kt_load_theme_options_backup() {
		var data = {'action':'kt_load_theme_options_backup'};
		$.post(ajaxurl, data, function(response) {
			$("#kt-dialog-import-theme-options-table > tbody").html(response);
		});
	}
	$(".kt-theme-options-importer").click(function(event) {
		event.preventDefault();
		kt_load_theme_options_backup();
		/*var data = {'action':'kt_load_theme_options_backup'};
		 $.post(ajaxurl, data, function(response) {
		 $("#kt-dialog-import-theme-options-table > tbody").html(response);

		 });*/
		$("#kt-dialog-import-theme-options").dialog({
			title:  "Theme options backup files",
			dialogClass:'kt-dialog',
			width: 768,
			height: 'auto',
			modal:true
		});
	});
	$(document).on('click','.kt-theme-options-backup-delete',function(){
		var file = $(this).data('file'), uniqid = $(this).data('uniqid');
		event.preventDefault();
		var data = {
			'action'    :   'kt_theme_options_backup_delete',
			'file'      :   file,
		};
		$.post(ajaxurl, data, function(response) {
			alert(response);
			$("#"+uniqid).remove();
		});
	});
	$(document).on('click','.kt-theme-options-imported',function(){
		var file = $(this).data('file');
		event.preventDefault();
		var data = {
			'action'    :   'kt_theme_options_importer',
			'file'      :   file,
		};
		$.post(ajaxurl, data, function(response) {
			alert(response);
		});
	});

	if($("#kt_theme_options_uploader").length >0){
		new AjaxUpload($('#kt_theme_options_uploader'), {
			action: ajaxurl,
			name: 'uploader',
			data:{'action':'kt_theme_options_uploader'},
			responseType: 'json',
			onChange: function(file, ext){},
			onSubmit: function(file, ext){
				if (! (ext && /^(txt)$/.test(ext))){
					alert("Support txt file format only." );
					return false;
				}
			},
			onComplete: function(file, response){
				alert(response.msg)
				if(response.status = 1)
					kt_load_theme_options_backup();
				//alert(response);
			}
		});
	}

	// close dialog
	$(".kt-dialog-close").click(function(e){
		event.preventDefault();
		var uniqid = $(this).data('uniqid');
		$("#kt-dialog-"+uniqid).dialog('destroy');
	});
});