<select class="form-control" name="parent_id" id="parent_id">
    <option value="0" selected>
        Самостоятельная категория
    </option>

    @foreach(Category::getTree() as $category_id => $category_tree)
        <option value="{{ $category_id }}" {{ isset($category['id']) && $category['id'] == $category_id ? 'disabled' : '' }}>
            {{ $category_tree['title'] }}
        </option>

        @if(Category::hasChild($category_id))
            @foreach($category_tree['child'] as $category_id1 => $category_tree1)
                <option value="{{ $category_id1 }}" {{ isset($category['id']) && $category['id'] == $category_id1 ? 'disabled' : '' }}>
                    -&nbsp;{{ $category_tree1['title'] }}
                </option>
            @endforeach
        @endif
    @endforeach
</select>



