<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;
use App\Nova\Metrics\TotalOrders;
use App\Nova\Metrics\TotalRevenue;
use App\Nova\Metrics\LowStockProducts;
use App\Nova\Metrics\OrdersByStatus;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new TotalOrders,
            new TotalRevenue,
            new LowStockProducts,
            new OrdersByStatus,
        ];
    }
}
