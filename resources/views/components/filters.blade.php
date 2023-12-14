<div class="filter-wrapper">
    <div class="filter-price">
        <form action="{{ url('url/to/your/indexproduct') }}" method="GET">
            <input type="text" name="min_price"> //User can input minimum price here
            <input type="text" name="max_price"> //User can input maximum price here
            <input type="submit" value="Filter">
        </form>
    </div>

    <div class="filter-size">
        <form action="{{ url('url/to/your/indexproduct') }}" method="GET">
            <input type="checkbox" name="size[]" value="S"> S
            <input type="checkbox" name="size[]" value="M"> M
            <input type="checkbox" name="size[]" value="L"> L
            <input type="checkbox" name="size[]" value="XL"> XL
            <input type="submit" value="Filter">
    </div>
    
