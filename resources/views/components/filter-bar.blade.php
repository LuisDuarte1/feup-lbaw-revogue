<div class="filter-bar">
    <h2>Filters</h2>
    <div class="filter-list">
        <div class="filter-input filter-price">
            <p>Price</p>
            <div class="row">
                <input type="number" id="price_product_from" placeholder="Min">
                <input type="number" id="price_product_to" placeholder="Max">
            </div>
        </div>
        <div class="filter-select filter-category">
            <p>Category</p>
            <select name="category">
                @php
                    $categories = \App\Models\Category::all();
                @endphp
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        @php
            $attributesGrouped = $filterAttributes->groupBy('key');     
        @endphp
        @foreach ($attributesGrouped as $name => $attributes)
        <div class="filter-select filter-attribute" data-attribute-key="{{$name}}">
            <p>{{$name}}</p>
            <select name="{{$name}}">
                <option value=""></option>
                @foreach ($attributes as $attribute)

                <option value="{{$attribute->value}}">{{$attribute->value}}</option>
    
                @endforeach
            </select>
        </div>
        @endforeach
    </div>
</div>