var overlay = jQuery('<div id="overlay" style="z-index:10000; top:0; left:0;" > </div>'); 
jQuery(document).ready(function(){
	overlay.appendTo(document.body);
});

function setProtectedDivSize(){
	var pageSize = getPageSize();
	overlay.css('width', pageSize[0]);
	overlay.css('height', pageSize[1]);
}

function protecteddiv(){
	setProtectedDivSize();
	jQuery("#overlay").show();
	jQuery('body').css({'overflow': 'hidden'});
}

function hideProtectedDiv(){
	jQuery("#overlay").hide();
	jQuery('#loading-page').hide();
	jQuery('body').css({'overflow': 'visible'});
}

function setLoadingPosition() {
	var loadingHeight = jQuery('#loading-page').height();
	var loadingWidth = jQuery('#loading-page').width();
	var arrayWindowSize = getWindowSize();
	var leftOffset = ((arrayWindowSize[0] - loadingWidth) / 2) + window.scrollX;
	var topOffset = ((arrayWindowSize[1] - loadingHeight) / 2) + window.scrollY;
	jQuery('#loading-page').css('top', topOffset);
	jQuery('#loading-page').css('left', leftOffset);
	jQuery('#loading-page').show();
}

function getWindowSize() {
	var windowWidth, windowHeight;

	if (self.innerHeight) {
		if (document.documentElement.clientWidth) {
			windowWidth = document.documentElement.clientWidth;
		} else {
			windowWidth = self.innerWidth;
		}
		windowHeight = self.innerHeight;
	} else if (document.documentElement
			&& document.documentElement.clientHeight) {
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) {
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}
	return [windowWidth, windowHeight];
}

function getScrollOffset() {
	var xScroll, yScroll;

	if (window.innerHeight && window.scrollMaxY) {
		xScroll = window.innerWidth + window.scrollMaxX;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight) {
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else {
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	return [xScroll, yScroll];
}

function getPageSize() {

	var xScroll, yScroll;

	if (window.innerHeight && window.scrollMaxY) {
		xScroll = window.innerWidth + window.scrollMaxX;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight) {
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else {
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}

	var windowWidth, windowHeight;

	if (self.innerHeight) {
		if (document.documentElement.clientWidth) {
			windowWidth = document.documentElement.clientWidth;
		} else {
			windowWidth = self.innerWidth;
		}
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) {
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) {
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}

	if (yScroll < windowHeight) {
		pageHeight = windowHeight;
	} else {
		pageHeight = yScroll;
	}

	if (xScroll < windowWidth) {
		pageWidth = xScroll;
	} else {
		pageWidth = windowWidth;
	}

	return [pageWidth, pageHeight];
}

function ajax_before(XMLHttpRequest){
	setLoadingPosition();
	protecteddiv();
}

function ajax_complete(XMLHttpRequest, textStatus, url) {
	hideProtectedDiv();
	window.scrollTo(0,0);
	//document.location.hash = url;
	window.history.replaceState('200', 'Back', url);
	if(!XMLHttpRequest.responseText){
		document.location.href = '/admin/users/login';
	} else {
	}
}

function ajax_success(data, textStatus) {
	//alert('success');
}

function ajax_error() {
	//alert('Error');
}

function getPage() {
	var url = '/admin/pages/panel';
	if(url != null) {
		jQuery.ajax({
			type: 'get',
			url : url,
			beforeSend: function(XMLHttpRequest){
				ajax_before(XMLHttpRequest);
			},
			success: function(data){
				jQuery("#main-content").html(data);
			},
			complete: function(XMLHttpRequest, textStatus){
				ajax_complete(XMLHttpRequest, textStatus, url);
			}
		});
	}
}

var editors = null;

function setEditor(id) {
	var instance = null;
	if (editors == null) {
		editors = new Hashtable();
	}
	if (editors.get(id) != undefined) {
		editors.remove(id);
	}
	instance = CKEDITOR.replace(jQuery(id).attr('name'));
	editors.put(id, instance);
}

function getEditor(form) {
	jQuery(form + ' textarea').each(function() {
		var textarea = jQuery(this);
		textarea.val(CKEDITOR.instances[textarea.attr('id')].getData());
		CKEDITOR.instances[textarea.attr('id')].destroy();
		editors.remove(textarea.attr('id'));
	});
	return true;
}
