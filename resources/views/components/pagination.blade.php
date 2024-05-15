@use(App\Lib\I18N\ELanguageText)
@if ($elements->hasPages())
    <div class="pagination-frame">
        {{-- Pagination Elements --}}
        {{$slot}}
        <div class="pagination">
            <div class="btn-group btn-group-border-2-slate">
                <a class="btn btn-center btn-md btn-dead tracking-widest !break-keep !bg-color1 btn-border-0">{{ $elements->currentPage() }}/{{ $elements->lastPage() }}</a>
                @if ($elements->onFirstPage())
                    <a aria-label="{{$i18N->getLanguage(ELanguageText::pagination_previous)}}"
                       class="btn btn-center btn-dead btn-md btn-border-0"><i class="fa-solid fa-left-long"></i></a>
                @else
                    <a href="{{ $elements->previousPageUrl() }}"
                       rel="prev"
                       aria-label="{{$i18N->getLanguage(ELanguageText::pagination_previous)}}"
                       class="btn btn-center btn-ripple btn-md btn-color1 btn-border-0"><i class="fa-solid fa-left-long"></i></a>
                @endif
                @php
                    $division3=$elements->lastPage()/4;
                    $once=false;
                    $hidestart = $division3;
                    $hideend = $division3*3.5;
                @endphp
                @for($i = 1; $i <= $elements->lastPage(); $i++)
                    @if($elements->lastPage()>=10)
                        @if($elements->currentPage() === $i)
                            <a class="btn btn-center btn-md btn-dead btn-border-0">{{ $i }}</a>
                        @elseif($i <= $division3 || ($i <= $elements->currentPage()+2 && $i >= $elements->currentPage()))
                            @php
                                $once=true;
                            @endphp
                            <a href="{{ $elements->url($i) }}"
                               class="btn btn-center btn-ripple btn-md btn-color1 btn-border-0">{{ $i }}</a>
                        @elseif($i>=$hideend || ($i >= $elements->currentPage()-2 && $i <= $elements->currentPage()))
                            <a href="{{ $elements->url($i) }}"
                               class="btn btn-center btn-ripple btn-md btn-color1 btn-border-0">{{ $i }}</a>
                        @elseif($once===true)
                            @php
                                $once=false;
                            @endphp
                            <a class="btn btn-center btn-md btn-dead btn-border-0">...</a>
                        @endif
                    @else
                        <a href="{{ $elements->url($i) }}"
                           class="btn btn-center btn-ripple btn-md btn-color1 btn-border-0">{{ $i }}</a>
                    @endif
                @endfor
                @if ($elements->hasMorePages())
                    <a href="{{ $elements->nextPageUrl() }}"
                       rel="next"
                       aria-label="{{$i18N->getLanguage(ELanguageText::pagination_next)}}"
                       class="btn btn-center btn-ripple btn-md btn-color1 btn-border-0"><i class="fa-solid fa-right-long"></i></a>
                @else
                    <a aria-label="{{$i18N->getLanguage(ELanguageText::pagination_next)}}"
                       aria-hidden="true"
                       class="btn btn-center btn-dead btn-md btn-border-0"><i class="fa-solid fa-right-long"></i></a>
                @endif
            </div>
        </div>
    </div>
@else
    <div class="pagination-frame">
        {{$slot}}
    </div>
@endif
