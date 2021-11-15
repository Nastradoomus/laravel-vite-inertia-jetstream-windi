<?php

use App\Http\Middleware\TrustHosts;
use Illuminate\Http\Response;

class TrustedAccess
{

    public function handle($request, Closure $next)
    {
        $trusted_hosts = app(TrustHosts::class)->hosts();
        $clientHostname = gethostbyaddr($request->getClientIp());
        $isTrusted = false;
        foreach ($trusted_hosts as $trusted) {
            if (self::isHostnameMatch($clientHostname, $trusted)) {
                $isTrusted = true;
                break;
            }
        }
        if ($isTrusted) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Unauthorised'], Response::HTTP_UNAUTHORIZED);
        }
    }

    private static function isHostnameMatch($hostname, $trustedHostname)
    {
        if ($trustedHostname == '*' || $hostname == $trustedHostname) {
            return true;
        }
        $subdomainDelimiterPosition = strpos($hostname, '.');
        if (strlen($trustedHostname) < 2 || $subdomainDelimiterPosition === false) {
            return false;
        }
        if (substr($trustedHostname, 0, 2) == '*.') {
            if (substr($trustedHostname, 1) == substr($hostname, $subdomainDelimiterPosition)) {
                return true;
            }
        }
        return false;
    }
}
