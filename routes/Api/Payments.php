<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-08-01
 * Time: 20:34
 */

Route::post('available-payments', 'PaymentController@availablePayments')->name('payment.available.payments');
