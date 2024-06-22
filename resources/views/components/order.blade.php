@foreach($orders as $order)
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading-{{$order->id}}">
            <div class="d-flex justify-content-between align-items-center">

                <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                     data-bs-target="#collapse-{{$order->id}}" aria-expanded="false"
                     aria-controls="collapse-{{$order->id}}">
                    طلب {{$type}} رقم
                    {{$order->id}}
                </div>
                <div class="order-status">
                    <div class="order-date">{{$order->created_at->toDateString()}}</div>
                    <div class="order-type">{{$type}}</div>
                    <div class="order-state">{{__($order->status)}}</div>
                </div>
            </div>
        </h2>
        <div id="collapse-{{$order->id}}" class="accordion-collapse collapse" aria-labelledby="heading-{{$order->id}}"
             data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <a href="{{route('personal-order.show',$order)}}" class="order-details">تفاصيل الطلب</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#reviewModal"
                   class="order-review">تقييم الطلب</a>
            </div>
        </div>
    </div>


@endforeach
