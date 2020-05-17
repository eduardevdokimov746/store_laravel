@if($filter->isNotEmpty())
    <div class="col-md-3 rsidebar">
        <div class="rsidebar-top">
            @foreach ($filter->getGroups() as $group)
                <div class="slider-left">
                    <h4>{{ $group->title }}</h4>
                    <div class="row row1 scroll-pane">
                        @foreach($filter->getValuesGroup($group->id) as $value_id => $value_title)
                            <label class="checkbox">
                                <input type="checkbox" name="checkbox"
                                       {{ $filter->isGetFilters($value_id) ? 'checked' : '' }} value="{{ $value_id }}"><i></i>
                                {!! $value_title !!}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
