<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon" style="background: {{ $menu->status->background_colour }};">@svg('solid/circle')</span>

            <div class="info-box-content">
                <span class="info-box-text">Status</span>
                <span class="info-box-number">{{ $menu->status->name }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary">@svg('regular/utensils-alt')</span>

            <div class="info-box-content">
                <span class="info-box-text">Type</span>
                <span class="info-box-number">{{ $menu->type->name }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary">@svg('regular/eye')</span>

            <div class="info-box-content">
                <span class="info-box-text">Publish At</span>
                <span class="info-box-number">{{ $menu->publish_at > now() && $menu->status_id !== 4 ? \Carbon\Carbon::parse($menu->publish_at)->diffForHumans() :  'Menu is live!' }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary">@svg('regular/user')</span>

            <div class="info-box-content">
                <span class="info-box-text">Created By</span>
                <span class="info-box-number">{{ $menu->author->name }}</span>
            </div>
        </div>
    </div>
</div>
