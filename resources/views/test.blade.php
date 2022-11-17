

<form method="post" action="/ge/test/filter">
    @csrf

    <input type="number" name="filter[price][]" placeholder="min" value="0">
    <input type="number" name="filter[price][]" placeholder="max" value="{{$maxPrice}}">

    <ul>
        @foreach($categories as $item)
            <li>
                <label>
                    {{$item->title}}
                    <input type="checkbox" name="category" value="{{$item->id}}">
                </label>
            </li>
        @endforeach
    </ul>

    <ul>
        @foreach($attrs as $item)

            <li>
                @if($item->type !== 'boolean')
                <label>
                    {{$item->name}}
                </label>

                <ul>
                    @foreach($item->options as $option)
                        <li>
                            <label>
                                {{$option->label}}
                                <input type="checkbox" name="filter[{{$item->code}}][]" value="{{$option->id}}">
                            </label>
                        </li>
                    @endforeach
                </ul>

                @else

                    <label>
                        {{$item->name}}
                        <input type="checkbox" name="filter[{{$item->code}}]" value="1">
                    </label>

                @endif

            </li>
        @endforeach
    </ul>
    <input type="submit">
</form>



