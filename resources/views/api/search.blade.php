@foreach ($products as $product)
    @php

        $price = $product['product']->price;
        $image = $product['product']->image_paths[0];
        $size = $product['size'];
        $condition = $product['condition'];
        $id = $product['product']->id;
    @endphp
    <x-productCard :price="$price" :image="$image" :size="$size" :id="$id" :shipping="2"
        :condition="$condition" />
@endforeach
