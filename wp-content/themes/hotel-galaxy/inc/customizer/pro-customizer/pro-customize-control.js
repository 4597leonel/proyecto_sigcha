( function( api ) {
	
	api.sectionConstructor['hotelgalaxy'] = api.Section.extend( {
		
		attachEvents: function () {},
		
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );