<?php

it('user can login', function () {
    $this->post('api/login')
        ->assertStatus(200);
});
