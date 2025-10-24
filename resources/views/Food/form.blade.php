<div class="card col-6 mt-4 border-primary">
    <div class="card-header">
        <h2 class="card-title text-center ">{{$çardTitle}}</h2>
    </div>

       
        <div class="card-body">
            <div class="p-2 col-4">
                <input class="form-control " name="name" type="text"
                value="{{old('name',$food->name ?? "")}}" placeholder="Enter food name">
            </div>
            <div class="p-2">
                <input class="form-control" name="owner_phone" type="text"
                value="{{old('owner_phone',$food->owner_phone ?? "") }}" placeholder="Enter owner phone">
            </div>
            <div class="p-2">
                <input class="form-control" name="expiry_date" type="date"
                value="{{old('expiry_date',$food->expiry_date ?? "") }}" placeholder="Enter expiry date">
            </div>

           <div class="p-2">
                <input class="form-control" name="quantity" type="number"
                value="{{old('quantity',$food->quantity ?? "") }}" placeholder="Enter quantity">
            </div>

            <div class="p-2">
                <input class="form-control" name="notes" type="text"
                value="{{old('notes',$food->notes ?? "") }}" placeholder="Enter notes">
            </div>


            

            <div class="p-2">
                <button type="submit" class="btn btn-{{$btnColor}}">{{$btnText}}</button>
                <a href="{{route('food.create')}}" class="btn btn-success">Close</a>
            </div>

        </div>
    
   
</div>


</div>
