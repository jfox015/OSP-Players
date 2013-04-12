<?php
$inline = <<<EOL
<div id="player_modal" class="modal hide" style="display:none;">
	<div class="modal-body" id="player_content">
	</div>
</div>
<script id="popup_template" type="text/template">
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
                <a href="<%= playerdata.team_link %>" target="_blank"><%= playerdata.team_name %></a>
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
            if (playerdata.stats.headers) {
                _.each(playerdata.stats.headers, function(item,i) {
                    print('<th>' + item.toString().toUpperCase() + '</th>');
                });
            }
            %>
        </tr>
        </thead>
        <% if (playerdata.stats.stats) { %>
        <tbody>
            <%_.each(playerdata.stats.stats[0], function(item,i) {
                print('<td class="stat">' + item + '</td>');
            });
            %>
        </tbody>
        <% }
            if (playerdata.stats.total) {%>
        <tfoot>
            <%
            _.each(playerdata.stats.total, function(item,i) {
                print('<td class="totals stat">' + item + '</td>');
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
    <div class="span12"><a href="<%= playerdata.player_link %>">Complete player profile</a></div>
</div>
</script>
EOL;
echo($inline);