@foreach(Category::getTree() as $category_id => $category_tree)
    <p class="item-p">
        @if(!Category::hasChild($category_id))
            <a class="list-group-item"
               href="{{ route('admin.categories.edit', $category_id) }}">{{ $category_tree['title'] }}</a>
            <span><a href="{{ route('admin.categories.destroy', $category_id) }}" class='delete'><i
                        class='fa fa-fw fa-close text-danger'></i></a></span>
        @else
            <a class="list-group-item"
               href="{{ route('admin.categories.edit', $category_id) }}">{{ $category_tree['title'] }}</a>
            <span><i class="fa fa-fw fa-close"></i></span>
        @endif
    </p>

    @if(Category::hasChild($category_id))
        <div class="list-group">
            @foreach($category_tree['child'] as $category_id1 => $category_tree1)
                <p class="item-p">
                    @if(!Category::hasChild($category_id))
                        <a class="list-group-item"
                           href="{{ route('admin.categories.edit', $category_id1) }}">{{ $category_tree1['title'] }}</a>
                        <span><a href="{{ route('admin.categories.destroy', $category_id1) }}" class='delete'><i
                                    class='fa fa-fw fa-close text-danger'></i></a></span>
                    @else
                        <a class="list-group-item"
                           href="{{ route('admin.categories.edit', $category_id1) }}">{{ $category_tree1['title'] }}</a>
                        <span><i class="fa fa-fw fa-close"></i></span>
                    @endif
                </p>

                @if(Category::hasChild($category_id1))
                    <div class="list-group">
                        @foreach($category_tree1['child'] as $category_id2 => $category_tree2)
                            <p class="item-p">
                                @if(!Category::hasChild($category_id2))
                                    <a class="list-group-item"
                                       href="{{ route('admin.categories.edit', $category_id2) }}">{{ $category_tree2['title'] }}</a>
                                    <span><a href="{{ route('admin.categories.destroy', $category_id2) }}" class='delete'><i
                                                class='fa fa-fw fa-close text-danger'></i></a></span>
                                @else
                                    <a class="list-group-item"
                                       href="{{ route('admin.categories.edit', $category_id2) }}">{{ $category_tree2['title'] }}</a>
                                    <span><i class="fa fa-fw fa-close"></i></span>
                                @endif
                            </p>

                        @endforeach
                    </div>
                @endif

            @endforeach
        </div>
    @endif
@endforeach


