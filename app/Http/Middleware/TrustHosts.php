<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array
     */
    public function hosts()
    {
        $this->trustedHosts = [];
        if (config("trusted.hosts")) {
            $list = explode("|", config("values.trusted_hosts"));
            if ($list !== false && !empty($list)) {
                array_push($list, $this->allSubdomainsOfApplicationUrl());
                $this->trustedHosts = $list;
                return $this->trustedHosts;
            }
        }
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
