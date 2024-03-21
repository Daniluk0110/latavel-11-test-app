<?php

use Illuminate\Support\Facades\Artisan;

beforeEach(function () {
    Artisan::call('passport:install');
});

it('user can login', function () {
    $this->post('api/login')
        ->assertStatus(200);
});
