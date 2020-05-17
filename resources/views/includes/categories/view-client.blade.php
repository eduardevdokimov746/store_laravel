<li class="has-children">
    <a href="{{ route('categories.show', $category['slug']) }}">{{ $category['title'] }}</a>
    <ul class="cd-secondary-dropdown is-hidden" style="width: 800px;">
        <li class="go-back"><a style="cursor: pointer;">Назад</a></li>
        @if(isset($category['child']))
            @foreach ($category['child'] as $key => $value)
                <li class="has-children">
                    <a href="{{ route('categories.show', $value['slug']) }}">{{ $value['title'] }}</a>
                    <ul class="is-hidden">
                        <li class="go-back"><a style="cursor: pointer;">Назад</a></li>
                        @if(isset($value['child']))
                            @foreach ($value['child'] as $key => $value1)
                                <li>
                                    <a href="{{ route('categories.products', $value1['slug']) }}">{{ $value1['title'] }}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
            @endforeach
        @endif
    </ul>
</li>
