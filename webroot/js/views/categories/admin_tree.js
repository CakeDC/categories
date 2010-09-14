/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App.pagesAdminIndex = {
	init : function() {
		$('#categorytree').treeview();
		$('#categorytree li span').contextMenu(
			{ menu: 'actions-list' },
			function(action, el, pos) {
				var url = '/' + action + '/' + $(el).attr("id");
				window.location = url;
		    }
		);
		//$('#placeholder').hide().load('/admin/categories/categories/add', function() { $(this).fadeIn(); });
	}
};