
$(document).ready(function() {

    __notif_load_data(__basepath + "/");

});

function __notif_show(code = 0, title = "", content = "") {
	try{

		/*
		STYLE CODE:
			> 0   : SUCCESS
			== -1 : WARNING
			< -1  : DANGER
		*/

		if(title.trim() != "" || content.trim() != "") {

			var src = $('#__notif_content_src');
			var id = "#__notif_content";


			var tc = '' +
					    '<div id="__notif_content" class="toastify-content hidden flex">' +
					    '	<div class="font-medium">' + content + '<a class="font-medium text-primary dark:text-slate-400 mt-1 sm:mt-0 sm:ml-40" href=""></a>' +
					    '</div>' +
					 '';

			if(code > 0) {
				tc = '' +
				     '<div id="__notif_content" class="toastify-content hidden flex items-center"> <i class="far fa-check-circle notif_icon_1 text-success text-8xl"></i>' +
				     '	<div class="ml-4 mr-4">' +
				     '		<div class="font-medium">' + title + '</div>' +
				     '		<div class="text-slate-500 mt-1">' + content + '</div>' +
				     '	</div>' +
				     '</div>' +
				 	 '';
			}
			if(code < -1) {
				tc = '' +
				     '<div id="__notif_content" class="toastify-content hidden flex items-center"> <i class="far fa-times-circle notif_icon_1 text-danger text-8xl"></i>' +
				     '	<div class="ml-4 mr-4">' +
				     '		<div class="font-medium">' + title + '</div>' +
				     '		<div class="text-slate-500 mt-1">' + content + '</div>' +
				     '	</div>' +
				     '</div>' +
				 	 '';
			}
			if(code == -1) {
				tc = '' +
				     '<div id="__notif_content" class="toastify-content hidden flex items-center"> <i class="fas fa-exclamation-triangle notif_icon_1 text-warning text-8xl"></i>' +
				     '	<div class="ml-4 mr-4">' +
				     '		<div class="font-medium">' + title + '</div>' +
				     '		<div class="text-slate-500 mt-1">' + content + '</div>' +
				     '	</div>' +
				     '</div>' +
				 	 '';
			}

            if(code == -2) {
                tc = '' +
                    '<div id="__notif_content" class="toastify-content hidden flex items-center"> <i class="fa-solid fa-file-circle-exclamation notif_icon_1 text-warning text-8xl"></i>' +
                    '	<div class="ml-4 mr-4">' +
                    '		<div class="font-medium">' + title + '</div>' +
                    '		<div class="text-slate-500 mt-1">' + content + '</div>' +
                    '	</div>' +
                    '</div>' +
                    '';
            }

			//src.html(tc);

		    Toastify({ node: $(tc) .clone() .removeClass(
		        "hidden")[0],
		        duration: 3000,
		        newWindow: true,
		        close: true,
		        gravity: "top",
		        position: "right",
		        backgroundColor: "#fff",
		        stopOnFocus: true,
		    }).showToast();

		    //src.html("");

		}


	}catch(err){  }
}

function __notif_load_data(bpath = "") {
	try{
		$.ajax({
		url: bpath + 'getnotif',
		type: "GET",
		data: {},
		success: function(data) {
			try{
				var cd = JSON.parse(data);
				var code = parseInt(cd['code']);
				var ttl = cd['title'];
				var cont = cd['content'];
				__notif_show(code,ttl,cont);
			}catch(err){  }
		},
		error: function() {
			try{

			}catch(err){}
		}

		});
	}catch(err){  }
}
