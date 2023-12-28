<?php

namespace App\Models\Treatments\Treatment;

trait PayloadManagement
{
    public function addToPayload(string $key, mixed $value) {
        $payload_arr = [];
        if ( ! is_null($this->payload) ) {
            $payload_arr = json_decode($this->payload, true);
        }
        $payload_arr[$key] = $value;

        $this->payload = json_encode($payload_arr);

        $this->save();
    }
    public function addPayloads(array $payloads): static
    {
        foreach ($payloads as $key => $value) {
            $this->addToPayload($key, $value);
        }
        return $this;
    }

    public function getPayloadEntry(string $key) {
        if ( is_null($this->payload) ) {
            return null;
        }
        $payload_arr = json_decode($this->payload, true);
        if ( ! array_key_exists($key, $payload_arr) ) {
            return null;
        }
        return $payload_arr[$key];
    }
}
