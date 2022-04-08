
<section class="bg-slider-option">
    <div class="slider-option slider-three">
        <div id="slider" class="carousel slide wow fadeInDown" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                @foreach($sliders as $key => $slider)
                    <div class="item {{ $key <= 0 ? 'active':'' }}">
                        <div class="slider-item">
                            <img src="{{ $slider->cover }}" alt="bg-slider-1">
                            <div class="slider-content-area">
                                <div class="container">
                                    <div class="slider-content text-center">
                                        {{--@dump(trans($slider->description_transltion))--}}
                                        {!! shortcodes(trans($slider->description)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($sliders->count() >= 2)
                <a class="left carousel-control" href="#slider" role="button" data-slide="prev">
                    <span class="fa fa-angle-left" aria-hidden="true"></span>
                </a>
                <a class="right carousel-control" href="#slider" role="button" data-slide="next">
                    <span class="fa fa-angle-right" aria-hidden="true"></span>
                </a>
            @endif
        </div>
    </div>
</section>
