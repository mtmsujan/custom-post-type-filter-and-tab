(function($){

	$(".cat-img-btn").on('click', function(e){

		// let this = $(this);

		let wpmedia = wp.media({
			title: 'Upload Category Image',
            multiple: false,
            button: {
		    	text: 'Use this image'
		    },
		}).open();

		wpmedia.on('select', function( data ){
			let image = wpmedia.state().get('selection').first().toJSON().url;

			$("input.category-image-input").val(image);
		});

		return false;
	});


})(jQuery)