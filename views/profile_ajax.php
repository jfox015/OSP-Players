<?php
$inline = <<<EOL
<div id="player_modal" class="modal" style="display:none;">
	<div class="modal-body">
		<div class="container-fluid">
			<div class="row-fluid rowbg content">
				<div class="span2">
				<img src="<%= playerdata.player_img %>" />
				</div>
				<div class="span10">
						<!-- PLAYER BIO DETAILS -->
					<div class="player-bio-short">
						<h3><%= playerdata.player_name %></h3>
						<br />
						<%= playerdata.number %></b> <%= playerdata.position %></b>
						<br />
						<a href="<%= playerdata.team_link %> target="_blank"><%= playerdata.team_name %></a>
					</div>
				</div>
			</div>
		</div>
			
		<% if (playerdata.stats) { %>
			<!-- Show Stats -->
		<div class="row-fluid rowbg content">
			<div class="span12">
				<div class="stats-table">
				<table class="table table-striped table-bordered">
				<thead>
				<tr>
					<% 
					_.each(playerdata.stats.headers, function(item,i) {
						print('<th>' + item.toString().toUpperCase() + '</th>');
					});
					%>
				</tr>
				</thead>
				<tbody>
					<% 
					if (playerdata.stats.current) {
						_.each(playerdata.stats.current, function(item,i) {
							print('<td class="stat">' + item.toString().toUpperCase() + '</td>');
						});
					} else {
						print('<td>No stats found.</td>');
					%>
				</tbody>
				<% 
					if (playerdata.stats.total) {%>
				<tfoot> 
					<% 
						_.each(playerdata.stats.total, function(item,i) {
							print('<td class="totals stat">' + item.toString().toUpperCase() + '</td>');
						});
					%>
				</tfoot>
				<% } %>
				</table>
				</div>
			</div>
		</div>
		<% } %>
		<div class="row-fluid rowbg content">
			<div class="span12"><%= playerdata.player_link %></div>
		</div>
	</div>
</div>
EOL;
echo($inline);