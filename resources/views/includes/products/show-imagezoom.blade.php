<ul class="slides">
    @foreach($product->info->imgsCollection as $img)
        <li data-thumb="{{ asset($img) }}">
            <div class="thumb-image {{ $loop->first ? 'detail_images' : '' }}">
                <img src="{{ asset($img) }}" data-imagezoom="true" class="img-responsive" alt="">
            </div>
        </li>
    @endforeach
</ul>
