/**
 * Main JS
 * Invludes dynamic modals, preloaders
 */
// Load Bootstrap Modal
function loadModal (data, width) {
	var modalId = "myModal";
	if ($("#myModal").length > 0) {
		//modalId = "subModal";
		unLoadModal();
	}
	var modalElement = '<div class="modal fade" id="' + modalId + '">' + data + '</div>';
	$("body").append(modalElement);
	var myModal = new bootstrap.Modal($("#"+modalId), {backdrop: 'static', keyboard: false });
	myModal.show();
}
// Unload Bootstrap Modal
function unLoadModal () {
	if ($("#subModal").length > 0) {
		$("#subModal").modal("hide");
		$("#subModal").remove();
	}
	else {
		$("#myModal").modal("hide");
		$("#myModal").remove();
		$(".modal-backdrop").remove();
		$("body").css("overflow", "auto");
	}
}
// Pre Loader
function preLoader() {
	var pre_loader = '<div class="spinner"><div class="pre-loader-position"><span class="loader-icon loader-logo"><span class="pre-loader"></span></span></div></div>';
	$('body').append(pre_loader);
	$('body').css('pointer-events', 'none');
}
// Close Pre Loader
function closePreLoader() {
	$('.spinner').remove();
	$('body').css('pointer-events', 'visible');
}
// Loader for every Ajax request
$.ajaxSetup({
    beforeSend: function() {
        preLoader();
    },
    complete: function() {
        closePreLoader();
    }
});