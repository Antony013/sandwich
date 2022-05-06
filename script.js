$(document).ready(function() {
	$("#form-register").hide();
	$("#box-co").hide();
});

$(function() {
	$(".btn-register").click(function(){
		$("#form-login").hide();
		$("#form-register").show();
		$("#box-reg").hide();
		$("#box-co").show();
	});
	$(".btn-log").click(function(){
		$("#form-login").show();
		$("#form-register").hide();
		$("#box-reg").show();
		$("#box-co").hide();
	});
});
