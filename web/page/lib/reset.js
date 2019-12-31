var docEl = document.documentElement || document.body;
var resizeEvt = 'orientation' in window ? 'orientationchange' : 'resize';
var recalc = function() {
	var clientWidth = docEl.clientWidth;
	if(!clientWidth) {
		return
	}
	docEl.style.fontSize = 100 * clientWidth / 750 + "px"
};
recalc();