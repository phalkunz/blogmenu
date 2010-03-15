<div id="Content">
	<div class="blogcontent typography">
		<div id="Breadcrumbs">
			<p><% if ClassName = SearchResults %><% else %><a href="home/" title="Go to the homepage">Home</a> &raquo; <% end_if %> $Breadcrumbs</p>
		</div>
		
		<h1>$Title</h1>

		$Content
		
		<% if Tag %>
			<h3><% _t('VIEWINGTAGGED', 'Viewing entries tagged with') %> '$Tag'</h3>
		<% end_if %>
		
		<% if BlogEntries %>
			<% control BlogEntries %>
				<% include BlogSummary %>
			<% end_control %>
		<% else %>
			<h3>There are no entries at present.</h3>
		<% end_if %>
		
		<% include BlogPagination %>
		
		$PageComments
		$Form
		
		<a title="Go to the top of the page" href="#Top"><img src="themes/nzgo/images/icons/top.gif" /></a>
	</div>
</div>
