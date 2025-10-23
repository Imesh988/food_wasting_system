<h1>Food Expiry Alert</h1>
<p>End of the expire date this food : </p>
<ul>
    @foreach($foodItems as $food)
        <li>{{ $food->name }} (quentity : {{ $food->quantity }})</li>
    @endforeach
</ul>
