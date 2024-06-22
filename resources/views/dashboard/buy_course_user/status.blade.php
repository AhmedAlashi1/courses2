
<a onclick="st(this)" data-status="{{ $buy_course_user->status }}">
    <i
        class="icon {{ $buy_course_user->status == 1 ? 'ion-ios-checkmark' : 'ion-ios-close' }}"
        data-id="{{$buy_course_user->id}}"
        style="color: {{ $buy_course_user->status == 1 ? '#00eb1b' : 'red' }}; font-size: 2rem; cursor: pointer;"
    ></i>
</a>
