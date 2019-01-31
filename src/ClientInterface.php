<?php
namespace Buckaroo;

/**
 * This interface is needed so that the mocked (phpUnit) client will
 * implementthe same interface as the normal api client.
 */
interface ClientInterface {
    public function call(array $data = []);
}
