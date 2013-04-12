$('a[rel=player_popup]').live('click', function (e) {
    e.preventDefault();
	$.ajax({
		url: '<?php echo site_url(); ?>players/profile_ajax/'+ this.id,
		dataType:  'json',
		success: function(data) {
			var template = _.template($('#popup_template').html());
			$('#player_content').html(template({playerdata: data}));
			$('#player_modal').modal('show');
		},
		error: function (data) {
			console.log(data);
		}
	});
});
$('#player_modal').modal({
	keyboard: false,
	static:true,
	background: true
});