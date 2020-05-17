<div class="cd-dropdown-wrapper">
    <a class="cd-dropdown-trigger" style="cursor: pointer;">Категории</a>
    <nav class="cd-dropdown">
        <a style="cursor: pointer;" class="cd-close">Close</a>
        <ul class="cd-dropdown-content">
            @foreach(Category::getTree() as $category)
                @include('includes.categories.view-client', $category)
            @endforeach
            <li><a href="{{ route('categories.index') }}">Все категории</a></li>
        </ul>
    </nav>
</div>
