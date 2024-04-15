@php use App\Lib\Type\Array\CGArray;use App\Lib\Type\String\CGString; @endphp
<table {{$attributes}}>
    @if(is_array($slot))
        @foreach($slot as $item)
            <tr>
            @foreach($item as $i)
                <td>{{$i}}</td>
            @endforeach
            </tr>
        @endforeach
    @endif
</table>
