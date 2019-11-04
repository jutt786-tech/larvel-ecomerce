<li><a href="#">{{ $child_category->title }}</a>
    @if ($child_category->categories)
        <ul>
            @foreach ($child_category->categories as $childCategory)
                @include('layouts.partials.child_category', ['child_category' => $childCategory])
            @endforeach
        </ul>
@endif
</li>



{{--<li>--}}
{{--    <a class="acnav__link acnav__link--level2" href="">{{ $child_category->title }}</a>--}}
{{--</li>--}}
{{--<li class="has-children">--}}
{{--    <div class="acnav__label acnav__label--level2">--}}
{{--        {{ $child_category->title }}--}}
{{--    </div>--}}
{{--@if ($child_category->categories)--}}
{{--    <!-- start level 3 -->--}}

{{--    <ul class="acnav__list acnav__list--level2">--}}
{{--        @foreach ($child_category->categories as $childCategory)--}}
{{--            @include('layouts.partials.child_category', ['child_category' => $childCategory])--}}
{{--        @endforeach--}}
{{--    </ul>--}}
{{--    @endif--}}
{{--</li>--}}
    <!-- end level 3 -->

