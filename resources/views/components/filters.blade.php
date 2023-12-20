<div class="filter-wrapper">
    <form action="{{ url('/') }}" method="GET">
        <div class="filter-box">
            <label for="min_price">Min Price</label>
            <input type="text" name="price[min_price]">
            <label for="max_price">Max Price</label>
            <input type="text" name="price[max_price]">
        </div>

        <div class="filter-box">
            <input type="checkbox" name="attribute[size][]" value="S"> S
            <input type="checkbox" name="attribute[size][]" value="M"> M
            <input type="checkbox" name="attribute[size][]" value="L"> L
            <input type="checkbox" name="attribute[size][]" value="XL"> XL
        </div>

        <input type="submit" value="Filter">
    </form>
</div>
