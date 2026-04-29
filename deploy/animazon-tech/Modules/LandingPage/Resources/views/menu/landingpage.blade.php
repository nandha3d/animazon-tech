<li class="dash-item dash-hasmenu
            {{ (Request::route()->getName() == 'landingpage.index') || (Request::route()->getName() == 'custom_page.index')
            || (Request::route()->getName() == 'homesection.index') || (Request::route()->getName() == 'features.index')
            || (Request::route()->getName() == 'discover.index') || (Request::route()->getName() == 'screenshots.index')
            || (Request::route()->getName() == 'pricing_plan.index') || (Request::route()->getName() == 'faq.index')
            || (Request::route()->getName() == 'testimonials.index') || (Request::route()->getName() == 'portfolio.index')
            || (Request::segment(2) == 'footer')
            || (Request::route()->getName() == 'join_us.index') ? ' active' : '' }}">
    <a href="{{ route('landingpage.index') }}" class="dash-link">
        <span class="dash-micon"><i class="ti ti-license"></i></span><span class="dash-mtext">{{__('Landing Page')}}</span>
    </a>
</li>

<li class="dash-item {{ (Request::route()->getName() == 'portfolio.index') ? 'active' : '' }}">
    <a href="{{ route('portfolio.index') }}" class="dash-link">
        <span class="dash-micon"><i class="ti ti-briefcase"></i></span><span class="dash-mtext">{{__('Portfolio')}}</span>
    </a>
</li>


