<div class="hail-carousel-wrapper">
    <div class="hail-carousel"
         data-showdots="$ShowDots" data-lg-toshow="$LargeToShow" data-lg-toscroll="$LargeToScroll" data-md-break="$MediumBreakpoint" data-md-toshow="$MediumToShow" data-md-toscroll="$MediumToScroll"
         data-sm-break="$SmallBreakpoint" data-sm-toshow="$SmallToShow" data-sm-toscroll="$SmallToScroll"
    >
        <% loop $CarouselItems %>
            <div class="hail-carousel-items card">
                <div class="card-img-top">
                    <a href="$PageLink" class="Link">
                        <% if $HeroVideo %>
                            <img data-lazy="{$HeroVideo.Url500}"/>
                        <% else_if $HeroImage %>
                            <img data-lazy="{$HeroImage.Url500}"/>
                        <% else %>
                            <img data-lazy="resources/vendor/firebrandhq/silverstripe-hail/client/dist/images/placeholder-hero.jpg"/>
                        <% end_if %>
                    </a>
                </div>
                <div class="card-body">
                    <% if $getType == "article" %>
                        <div class="card-tags">
                            <% loop $PublicTags.Limit(2) %>
                                <span class="badge badge-primary">$Name</span>
                            <% end_loop %>
                            <% if $PublicTags.Limit(9999, 2) %>
                                <span class="badge badge-primary">+ $PublicTags.Limit(9999, 2).Count More</span>
                            <% end_if %>
                        </div>
                        <a href="$PageLink" class="Link"><h5 class="card-title" title="$Title">$Title</h5></a>
                        <h6 class="card-subtitle mb-2 text-muted">$Date.Format('eeee MMMM d, yyyy')</h6>
                    <% else %>
                        <a href="$PageLink" class="Link"><h5 class="card-title" title="$Title">$Title</h5></a>
                        <h6 class="card-subtitle mb-2 text-muted">$DueDate.Format('eeee MMMM d, yyyy')</h6>
                    <% end_if %>
                </div>
            </div>
        <% end_loop %>
    </div>
</div>