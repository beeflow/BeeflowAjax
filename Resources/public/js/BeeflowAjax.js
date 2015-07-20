/* 
 * 
 * 
 * @author Rafal Przetakowski <rafal.p@beeflow.co.uk>
 * @copyright (c) 2015, Beeflow Ltd
 */


var BeeflowAjax = BeeflowAjax || {};
var pingFunctions = [];

BeeflowAjax.send = function (action, params) {
	$.ajax({
		method: "POST",
		url: action,
		data: {'data': params}
	}).done(function (responseMessage) {
		var msg = JSON.parse(responseMessage);
		BeeflowAjax.ajaxResponseCommands(msg);
	});

};

BeeflowAjax.pingRegister = function (functionName, regFunction) {
	pingFunctions[functionName] = regFunction;
};

BeeflowAjax.pingUnregister = function (functionName) {
	delete pingFunctions[functionName];
};

BeeflowAjax.ping = function () {
	for (var key in pingFunctions) {
		pingFunctions[key]();
	}
};

BeeflowAjax.ajaxResponseCommands = function (msg) {
	for (index = 0, len = msg.length; index < len; ++index) {
		var command = msg[index]['cmd'];
		switch (command) {
			case "alert" :
				alert(msg[index]['data']);
				break;
			case "debug" :
				console.log(msg[index]['data']);
				break;
			case "remove" :
				$("#" + msg[index]['id']).remove();
				break;
			case "append" :
				$('#' + msg[index]['id']).append(msg[index]['data']);
				break;
			case "assign" :
				$('#' + msg[index]['id']).html(msg[index]['data']);
				break;
			case "addClass" :
				$('#' + msg[index]['id']).addClass(msg[index]['data']);
				break;
			case "removeClass" :
				if (msg[index]['data'] == null) {
					$('#' + msg[index]['id']).removeClass();
				} else {
					$('#' + msg[index]['id']).removeClass(msg[index]['data']);
				}
				break;
			case "redirect" :
				window.location.href = msg[index]['url'];
				break;
			case "reloadLocation":
				window.location.reload();
				break;
			case "runScript" :
				jQuery.globalEval(msg[index]['data']);
				break;
			case "modal" :
				$('#' + msg[index]['id']).modal(msg[index]['data']);
				break;
			case "returnJson" :
				break;
		}
	}
};

BeeflowAjax.setFormFeedback = function (elementId, feedbackType) {
	var formGroup = $("#" + elementId).parents('.form-group');
	var glyphicon = formGroup.find('.glyphicon');
	switch (feedbackType) {
		case 'error' :
			formGroup.addClass('has-error').removeClass('has-success').removeClass('has-warning');
			glyphicon.addClass('glyphicon-remove').removeClass('glyphicon-ok').removeClass('glyphicon-warning-sign');
			break;
		case 'warning' :
			formGroup.addClass('has-warning').removeClass('has-success').removeClass('has-error');
			glyphicon.addClass('glyphicon-warning-sign').removeClass('glyphicon-ok').removeClass('glyphicon-remove');
			break;
		case 'success' :
			formGroup.addClass('has-success').removeClass('has-warning').removeClass('has-error');
			glyphicon.addClass('glyphicon-ok').removeClass('glyphicon-warning-sign').removeClass('glyphicon-remove');
			break;
		case 'clear' :
			formGroup.removeClass('has-success').removeClass('has-warning').removeClass('has-error');
			glyphicon.removeClass('glyphicon-ok').removeClass('glyphicon-warning-sign').removeClass('glyphicon-remove');
			break;
	}
};

BeeflowAjax.getFormValues = function (form) {
	if (typeof form === 'string') {
		var objects = $('form[name="' + form + '"]').serializeArray();
	} else {
		var objects = $(form).serializeArray();
	}
	var returnJson = {};
	for (var i = 0, j = objects.length; i < j; i++) {
		returnJson[objects[i].name] = objects[i].value;
	}
	return JSON.stringify(returnJson);
};

BeeflowAjax.initAjaxForms = function () {
	$('.ajax-form').each(function () {
		$(this).unbind('submit');
		$(this).submit(function (e) {
			BeeflowAjax.ajax($(this).attr('action'), BeeflowAjax.getFormValues(this));
			e.preventDefault();
		});
	});
};

BeeflowAjax.initAjaxLinks = function () {
	$('.ajax-link').each(function () {
		$(this).unbind('click');
		$(this).click(function (e) {
			if (typeof $(this).data('confirm') !== 'undefined') {
				if (!confirm($(this).data('confirm'))) {
					e.preventDefault();
					return false;
				}
			}
			BeeflowAjax.send($(this).data('action'), $(this).data());
			e.preventDefault();
		});
	});
};

$(document).ready(function () {
	BeeflowAjax.initAjaxForms();
	BeeflowAjax.initAjaxLinks();
	setInterval(BeeflowAjax.ping, 60000);
});