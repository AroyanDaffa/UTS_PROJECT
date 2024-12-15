<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class OLAPController extends Controller
{
    private $connection = 'olap'; //change to 2nd Database for OLAP
    private $saleFacts;
    private $inventoryFacts;
    private $shippingFacts;
    private $years = [];

    public function __construct()
    {
        $this->saleFacts = DB::connection($this->connection)
            ->select('SELECT * FROM fakta_penjualan');

        $this->inventoryFacts = DB::connection($this->connection)
            ->select('SELECT * FROM fakta_inventory');

        $this->shippingFacts = DB::connection($this->connection)
            ->select('SELECT * FROM fakta_shipping');

        $this->extractYears();
    }

    private function extractYears()
    {
        $years = [];

        foreach ($this->saleFacts as $fact) {
            $year = substr($fact->sk_waktu, 0, 4);
            if (ctype_digit($year) && strlen($year) === 4) {
                $years[] = (int)$year;
            }
        }

        foreach ($this->inventoryFacts as $fact) {
            $year = substr($fact->sk_waktu, 0, 4);
            if (ctype_digit($year) && strlen($year) === 4) {
                $years[] = (int)$year;
            }
        }

        foreach ($this->shippingFacts as $fact) {
            $year = substr($fact->sk_waktu, 0, 4);
            if (ctype_digit($year) && strlen($year) === 4) {
                $years[] = (int)$year;
            }
        }

        $this->years = array_unique($years);
        sort($this->years);
    }

    public function dashboardData()
    {
        $years = $this->years;

        $salesRevenue = []; // Total Sales Revenue per tahun (gada cost manufactur jadi penjualan = revenue)
        $topProducts = []; // Top 5 produk terjual tiap tahun
        $salesRevenueSecondary = []; // Monthly Sales Revenue growth di setiap tahun
        $salesRevenueQ = []; // Q Sales Revenue growth di setiap tahun
        $inventoryStock = []; // Total stock semua produk (dijumlah semua stok produk filternya pakai latest date buat setiap produk (sk_waktu, sk_produk)) pada setiap tahun
        $topLowStockProducts = []; // Top 5 stock paling low di setiap tahun (cara querynya sama kaya yg inventoryStock)
        $categoryStock = []; // Total stock setiap tahun buat setiap kategori (cara querynya sama kaya yg inventoryStock)
        $totalShipping = []; // Total shipping yang terjadi di setiap tahun
        $avgExpressStandard = []; // Average pengiriman metode Express dan Standard di setiap tahun
        $topShippingLocations = []; // Top 5 Kota-Kabupaten yang paling banyak terjadi shipping

        sort($years);

        foreach ($years as $index => $year) {
            // Transaction Facts
            $yearlyRevenue = DB::connection($this->connection)
                ->table('fakta_penjualan')
                ->whereRaw('LEFT(sk_waktu, 4) = ?', [$year])
                ->selectRaw('SUM(total * price) as total_revenue')
                ->value('total_revenue');

            $revenueGrowth = 0;
            if ($index > 0) {
                $previousYearRevenue = DB::connection($this->connection)
                    ->table('fakta_penjualan')
                    ->whereRaw('LEFT(sk_waktu, 4) = ?', [$years[$index - 1]])
                    ->selectRaw('SUM(total * price) as total_revenue')
                    ->value('total_revenue') ?: 0;

                if ($previousYearRevenue > 0) {
                    $revenueGrowth = (($yearlyRevenue - $previousYearRevenue) / $previousYearRevenue) * 100;
                }
            }

            $salesRevenue[$year] = [
                'revenue' => $yearlyRevenue ?: 0,
                'growth' => round($revenueGrowth, 2)
            ];

            $yearlyTopProducts = DB::connection($this->connection)
                ->table('fakta_penjualan')
                ->whereRaw('LEFT(sk_waktu, 4) = ?', [$year])
                ->join('dim_products', 'fakta_penjualan.sk_produk', '=', 'dim_products.sk_produk')
                ->select('dim_products.sk_produk', 'dim_products.nama_produk', 'dim_products.nama_kategori', DB::raw('SUM(fakta_penjualan.total) as order_frequencies'))
                ->groupBy('dim_products.sk_produk', 'dim_products.nama_produk', 'dim_products.nama_kategori')
                ->orderByDesc('order_frequencies')
                ->limit(5)
                ->get();

            $topProducts[$year] = $yearlyTopProducts;

            $monthlyRevenue = [];
            for ($month = 1; $month <= 12; $month++) {
                $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);

                $monthlyRevenueValue = DB::connection($this->connection)
                    ->table('fakta_penjualan')
                    ->whereRaw('LEFT(sk_waktu, 4) = ? AND LEFT(RIGHT(sk_waktu, 4), 2) = ?', [$year, $monthStr])
                    ->selectRaw('SUM(total * price) as total_revenue')
                    ->value('total_revenue');

                $monthlyRevenue[$monthStr] = $monthlyRevenueValue ?: 0;
            }
            $salesRevenueSecondary[$year] = $monthlyRevenue;

            $yearlyRevenueQuarterly = DB::connection($this->connection)
                ->table('fakta_penjualan as fp')
                ->join('dim_waktu as dw', 'fp.sk_waktu', '=', 'dw.sk_waktu')
                ->whereRaw('LEFT(fp.sk_waktu, 4) = ?', [$year])
                ->select(
                    DB::raw('QUARTER(dw.sk_waktu) as quarter'),
                    DB::raw('SUM(fp.total * fp.price) as total_revenue')
                )
                ->groupBy(DB::raw('QUARTER(dw.sk_waktu)'))
                ->orderBy(DB::raw('QUARTER(dw.sk_waktu)'))
                ->get();

            $salesRevenueQ[$year] = $yearlyRevenueQuarterly;

            // Inventory Facts
            $yearlyInventoryStock = DB::connection($this->connection)
                ->table('fakta_inventory as fi')
                ->whereRaw('LEFT(fi.sk_waktu, 4) = ?', [$year])
                ->whereRaw('fi.sk_waktu = (
                    SELECT MAX(sub.sk_waktu)
                    FROM fakta_inventory as sub
                    WHERE sub.sk_produk = fi.sk_produk
                    AND LEFT(sub.sk_waktu, 4) = ?
                )', [$year])
                ->selectRaw('SUM(fi.stock) as total_stock')
                ->value('total_stock');

            $inventoryStock[$year] = $yearlyInventoryStock ?: 0;

            $yearlyTopLowStockProducts = DB::connection($this->connection)
                ->table('fakta_inventory as fi')
                ->join('dim_products as dp', 'fi.sk_produk', '=', 'dp.sk_produk') // Join with the product table
                ->whereRaw('LEFT(fi.sk_waktu, 4) = ?', [$year]) // Filter by the year
                ->whereRaw('fi.sk_waktu = (SELECT MAX(sk_waktu) FROM fakta_inventory WHERE LEFT(sk_waktu, 4) = ? AND sk_produk = fi.sk_produk)', [$year]) // Get the latest stock for each product
                ->select(
                    'dp.sk_produk',
                    'dp.nama_produk', // Product name
                    DB::raw('SUM(fi.stock) as total_stock') // Sum of stocks for the product in the latest record
                )
                ->groupBy('dp.sk_produk', 'dp.nama_produk', 'dp.nama_kategori') // Group by product
                ->orderBy('total_stock', 'asc') // Order by the lowest stock (ascending)
                ->limit(5) // Get the top 5 products with the lowest stock
                ->get();

            $topLowStockProducts[$year] = $yearlyTopLowStockProducts ?: 0;

            $yearlyCategoryStock = DB::connection($this->connection)
                ->table('fakta_inventory as fi')
                ->join('dim_products as dp', 'fi.sk_produk', '=', 'dp.sk_produk') // Join with the dim_products table
                ->whereRaw('LEFT(fi.sk_waktu, 4) = ?', [$year]) // Filter by year
                ->whereRaw('fi.sk_waktu = (SELECT MAX(sk_waktu) FROM fakta_inventory WHERE LEFT(sk_waktu, 4) = ? AND sk_produk = fi.sk_produk)', [$year]) // Get the latest stock per product
                ->select(
                    'dp.id_kategori', // Category ID
                    'dp.nama_kategori', // Category name
                    DB::raw('SUM(fi.stock) as total_stock') // Sum of stocks for each category
                )
                ->groupBy('dp.id_kategori', 'dp.nama_kategori') // Group by category ID and name
                ->orderBy('total_stock', 'desc') // Optional: order by total stock descending
                ->get();

            $categoryStock[$year] = $yearlyCategoryStock ?: 0;

            // Shipping Facts
            $yearlyTotalShipping = DB::connection($this->connection)
                ->table('fakta_shipping')
                ->whereRaw('LEFT(sk_waktu, 4) = ?', [$year])
                ->selectRaw('COUNT(*) as total_shipping')
                ->value('total_shipping');

            $totalShipping[$year] = $yearlyTotalShipping ?: 0;

            for ($month = 1; $month <= 12; $month++) {
                $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);

                $monthlyAvgShippingDuration = DB::connection($this->connection)
                    ->table('fakta_shipping')
                    ->whereRaw('LEFT(sk_waktu, 4) = ? AND LEFT(RIGHT(sk_waktu, 4), 2) = ?', [$year, $monthStr])
                    ->selectRaw('shipping_method, 
                        AVG(DATEDIFF(tanggal_selesai, tanggal)) as avg_shipping_days')
                    ->groupBy('shipping_method')
                    ->get();

                $expressAvgDays = 0;
                $standardAvgDays = 0;

                foreach ($monthlyAvgShippingDuration as $duration) {
                    if ($duration->shipping_method === 'express') {
                        $expressAvgDays = round($duration->avg_shipping_days, 2);
                    } elseif ($duration->shipping_method === 'standard') {
                        $standardAvgDays = round($duration->avg_shipping_days, 2);
                    }
                }

                $avgExpressStandard[$year][$monthStr] = [
                    'express' => $expressAvgDays,
                    'standard' => $standardAvgDays
                ];
            }

            $topShippingLocations[$year] = DB::connection($this->connection)
                ->table('fakta_shipping as fs')
                ->join('dim_lokasi as dl', 'fs.sk_lokasi', '=', 'dl.sk_lokasi')
                ->whereRaw('LEFT(fs.sk_waktu, 4) = ?', [$year])
                ->select(
                    'dl.nama_lokasi',
                    DB::raw('COUNT(*) as shipping_count')
                )
                ->groupBy('dl.nama_lokasi')
                ->orderByDesc('shipping_count')
                ->limit(5)
                ->get();
        }

        return view('dashboard.dashboard', compact(
            'years',
            'salesRevenue',
            'topProducts',
            'salesRevenueSecondary',
            'salesRevenueQ',
            'inventoryStock',
            'topLowStockProducts',
            'categoryStock',
            'totalShipping',
            'avgExpressStandard',
            'topShippingLocations'
        ));
        // return response()->json([
        //     // 'years' => $years,
        //     'salesRevenue' => $salesRevenue,
        //     // 'topProducts' => $topProducts,
        //     // 'salesRevenueSecondary' => $salesRevenueSecondary,
        //     'salesRevenueQ' => $salesRevenueQ,
        //     'inventoryStock' => $inventoryStock,
        //     // 'topLowStockProducts' => $topLowStockProducts,
        //     // 'categoryStock' => $categoryStock,
        //     'totalShipping' => $totalShipping,
        //     // 'avgExpressStandard' => $avgExpressStandard,
        //     // 'topShippingLocations' => $topShippingLocations
        // ]);
    }
}
