<table>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>email</th>
        <th>message</th>
    </tr>
    @foreach ($items as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->email}}</td>
            <td>
                <ul>
                    @foreach($item->articles as $obj)
                        <li>{{$obj->getData()}}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    @endforeach
</table>