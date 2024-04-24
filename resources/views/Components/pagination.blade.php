@if ($elements->hasPages())
    <div class="pagination-frame">
        {{-- Pagination Elements --}}
        {{$slot}}
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($elements->onFirstPage())
                <div class="previous" aria-label="{{$i18N->getLanguage(ELanguageText::pagination_previous)}}">
                    <a aria-hidden="true">{{$i18N->getLanguage(ELanguageText::pagination_previous)}}</a>
                </div>
            @else
                <div class="previous active">
                    <a href="{{ $elements->previousPageUrl() }}" rel="prev"
                       aria-label="{{$i18N->getLanguage(ELanguageText::pagination_previous)}}">{{$i18N->getLanguage(ELanguageText::pagination_previous)}}</a>
                </div>
            @endif
            @for($i = 1; $i <= $elements->lastPage(); $i++)
                <div class="item">
                    <a href="{{ $elements->url($i) }}">{{ $i }}</a>
                </div>
            @endfor
            <div class="page-info">
                <div>
                    {{$i18N->getLanguage(ELanguageText::pagination_CurrentPage)}}: {{ $elements->currentPage() }}
                </div>
                <div>
                    {{$i18N->getLanguage(ELanguageText::pagination_TotalPages)}}: {{ $elements->lastPage() }}
                </div>
            </div>
            {{-- Next Page Link --}}
            @if ($elements->hasMorePages())
                <div class="next active">
                    <a href="{{ $elements->nextPageUrl() }}" rel="next"
                       aria-label="{{$i18N->getLanguage(ELanguageText::pagination_next)}}">{{$i18N->getLanguage(ELanguageText::pagination_next)}}</a>
                </div>
            @else
                <div class="next" aria-label="{{$i18N->getLanguage(ELanguageText::pagination_next)}}">
                    <a aria-hidden="true">{{$i18N->getLanguage(ELanguageText::pagination_next)}}</a>
                </div>
            @endif
        </div>
    </div>
@else
    <div class="pagination-frame">
        {{$slot}}
    </div>
@endif
