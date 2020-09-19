@foreach($posts as $indexKey => $post)
    <tr class="item{{$post->id}} @if($post->is_published) warning @endif">
        <td class="col1">{{ $indexKey+1 }}</td>
        <td>{{$post->title}}</td>
        <td>
            {{App\Post::getExcerpt($post->content)}}
        </td>
        <td class="text-center"><input type="checkbox" class="published" id="" data-id="{{$post->id}}" @if ($post->is_published) checked @endif></td>
        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->updated_at)->diffForHumans() }}</td>
        <td>
            <button class="show-modal btn btn-success" data-id="{{$post->id}}" data-title="{{$post->title}}" data-content="{{$post->content}}">
            <span class="glyphicon glyphicon-eye-open"></span> Show</button>
            <button class="edit-modal btn btn-info" data-id="{{$post->id}}" data-title="{{$post->title}}" data-content="{{$post->content}}">
            <span class="glyphicon glyphicon-edit"></span> Edit</button>
            <button class="delete-modal btn btn-danger" data-id="{{$post->id}}" data-title="{{$post->title}}" data-content="{{$post->content}}">
            <span class="glyphicon glyphicon-trash"></span> Delete</button>
        </td>
    </tr>
@endforeach