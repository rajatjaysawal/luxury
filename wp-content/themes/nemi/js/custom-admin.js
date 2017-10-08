(function () {
	jQuery(document).ready(function($) {  
		 
		$('body').delegate(".input_datetime", 'hover', function(e){
	            e.preventDefault();
	            $(this).datepicker({
		               defaultDate: "",
		               dateFormat: "yy-mm-dd",
		               numberOfMonths: 1,
		               showButtonPanel: true,
	            });
         });

		var hides = ['nemi_audio_link','nemi_link_link','nemi_link_text','nemi_video_link','nemi_gallery_files'];
		var shows = {
			audio:['nemi_audio_link'],
			video:['nemi_video_link','nemi_video_text'],
			link:['nemi_link_link'],
			gallery:['nemi_gallery_files']	
		}
		$( '.post-type-post #post-formats-select input' ).click( function(){
			 $(hides).each( function( i, item ){
			 	$("[name="+item+']').parent().parent().hide();
			 } );
			 var s = $(this).val();
			 if( shows[s] != null ){
			 	$(shows[s]).each( function( i, is ){
			 		$("[name="+is+']').parent().parent().show();
				 } );
			 }
		} );
	});	
} )( jQuery );