<a onclick="st(this)" data-status="{{ $sections->status }}">
    <i
        id="icon"
        data-id="{{$sections->id}}"
        class="icon {{ $sections->status == 1 ? 'ion-ios-checkmark' : 'ion-ios-close' }}"
        style="color: {{ $sections->status == 1 ? '#00eb1b' : 'red' }}; font-size: 2rem; cursor: pointer;"
    ></i>
</a>
