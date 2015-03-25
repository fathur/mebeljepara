/**
 * Class MainMenu
 * Digunakan untuk menentukan behaviour menu 
 * di mobile atau di desktop.
 * @author Fathur Rohman <fathur_rohman17@yahoo.co.id>
 * @credits
 * 		Dropdown on hover and on click: http://stackoverflow.com/questions/24685000/bootstrap-3-dropdowns-on-hover-and-on-click
 */
var MainMenu = MainMenu || {};

var Menu = function() {	
	this.adjust = function() {
		$(window).resize(function() {
			var viewportwidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
			if (!window.isMobile() || viewportwidth > 767) {
				$('.dropdown').on('mouseenter mouseleave', function() {
					$(this).find('.dropdown-menu').slideToggle(200);
				});	
			};
		});

	}
}
MainMenu.Menu = new Menu();
//MainMenu.Menu.adjust();

