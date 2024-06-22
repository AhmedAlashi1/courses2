<a onclick="st(this)" data-status="{{ $user->status }}">
    <i
        id="icon"
        data-user-id="{{ $user->id }}"
        class="icon {{ $user->status == 'active' ? 'ion-ios-checkmark' : 'ion-ios-close' }}"
        style="color: {{ $user->status == 1 ? '#00eb1b' : 'red' }}; font-size: 2rem; cursor: pointer;"
    ></i>
</a>
