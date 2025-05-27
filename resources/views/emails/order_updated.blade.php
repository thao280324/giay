@component('mail::message')
# Thông báo cập nhật trạng thái đơn hàng

Đơn hàng của bạn mã **{{ $order->order_code }}** đã được cập nhật trạng thái mới.

**Trạng thái hiện tại:** 
@switch($order->order_status)
    @case(1)
        Đang xử lý
        @break
    @case(2)
        Đang giao hàng
        @break
    @case(3)
        Đã hoàn thành
        @break
    @default
        Trạng thái khác
@endswitch

Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.

@endcomponent
