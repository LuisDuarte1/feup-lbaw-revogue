<div class="filter-wrapper">
    <form action="{{ url('url/to/your/indexproduct') }}" method="GET">
        <div class="filter-box">
            <label for="min_price">Min Price</label>
            <input type="text" name="min_price">
            <label for="max_price">Max Price</label>
            <input type="text" name="max_price">
        </div>

        <div class="filter-box">
            <input type="checkbox" name="size[]" value="S"> S
            <input type="checkbox" name="size[]" value="M"> M
            <input type="checkbox" name="size[]" value="L"> L
            <input type="checkbox" name="size[]" value="XL"> XL
        </div>

        <input type="submit" value="Filter">
    </form>
</div>
