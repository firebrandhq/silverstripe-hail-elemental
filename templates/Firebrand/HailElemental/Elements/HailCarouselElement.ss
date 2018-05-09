<div id="hail-carousel-previews">
    <% loop $HailPage.HailList %>
        <% if $getType == "article" %>
            <% include HailArticlePreview %>
        <% else %>
            <% include HailPublicationPreview %>
        <% end_if %>
    <% end_loop %>
</div>
