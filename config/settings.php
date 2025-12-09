<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable Balance Check
    |--------------------------------------------------------------------------
    |
    | Khi bật (true): Hệ thống sẽ kiểm tra số dư trước khi cho phép tạo đơn hàng
    | Khi tắt (false): Cho phép tạo đơn hàng mà không cần kiểm tra số dư
    |
    */

    'enable_balance_check' => env('ENABLE_BALANCE_CHECK', false),
];

