@foreach($notEarly as $key => $notify)
    <li id='{{$notify->status}}' style= "border-bottom: solid 1px silver;">
        <div class="v-bar">
        </div>
        <!-- <div class="noti-icon">
            {{substr(@\App\Lead::find($notify->type_id)->first_name,0,1)}}
        </div> -->
        @if($notify->type == 'log')
        <span>
            {{ $notify->user->name ." is " . $notify->en_title }}<br>
            Lead Name: {{@\App\Lead::find(json_decode($notify->old_data)->lead_id)->first_name}} {{@\App\Lead::find(json_decode($notify->old_data)->lead_id)->last_name}}
        </span>
        <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
        @else
        <a id="any" class="notificationElement" nid="{{ $notify->id }}">
            <span>
                {{ $notify->user->name ." is " . $notify->en_title }}<br>
                Lead Name: {{@\App\Lead::find(json_decode($notify->old_data)->lead_id)->first_name}} {{@\App\Lead::find(json_decode($notify->old_data)->lead_id)->last_name}}
            </span>
        </a>
        <div class='timeAgo'>{{time_ago($notify->created_at)}}</div>
        @endif

    </li>
@endforeach

