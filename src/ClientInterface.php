<?php
namespace Buckaroo;

interface ClientInterface {
    public function call(array $data = []);
}
