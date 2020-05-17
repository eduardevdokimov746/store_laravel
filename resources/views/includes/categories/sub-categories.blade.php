<div>
    <h3 class="w3ls-title">{{ $categoriesTree['title'] }}</h3>
    @if(isset($categoriesTree['child']))
        @foreach($categoriesTree['child'] as $childCat)
            <div class='sub_category'>
                <h3 class="w3ls-title">{{ $childCat['title'] }}</h3>
                <ul style="list-style: none;">
                    @if(isset($childCat['child']))
                        @foreach($childCat['child'] as $child)
                            <li style="">
                                <a href='{{ route('categories.products', $child['slug']) }}'>
                                    <img src='{{ asset('storage/images/'.$child['img']) }}' alt=''>
                                    <p>{{ $child['title'] }}</p>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        @endforeach
    @endif
</div>
