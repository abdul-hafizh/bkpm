<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 8:52 PM ---------
 */

declare(strict_types=1);


namespace SimpleCMS\EloquentViewable\Resolvers;

use Illuminate\Support\Facades\Request;
use SimpleCMS\EloquentViewable\Contracts\IpAddressResolver as IpAddressResolverContract;

class IpAddressResolver implements IpAddressResolverContract
{
    /**
     * Resolve the IP address.
     *
     * @return string
     */
    public function resolve(): string
    {
        return Request::ip();
    }
}
