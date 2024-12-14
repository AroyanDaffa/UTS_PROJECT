<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class OLAPController extends Controller
{
    private $connection = 'olap'; //change to 2nd Database for OLAP
    private $saleFacts;
    private $inventoryFacts;
    private $shippingFacts; //TODO
    private $years = [];

    public function __construct()
    {
        $this->saleFacts = DB::connection($this->connection)
            ->select('SELECT * FROM fakta_penjualan');

        //TODO: benerin fact
        $this->inventoryFacts = DB::connection($this->connection)
            ->select('SELECT * FROM fakta_inventory');

        //TODO:
        // $this->shippingFacts = DB::connection($this->connection)
        //     ->select('SELECT * FROM fakta_shipping');

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

        $this->years = array_unique($years);
        sort($this->years);
    }

    // Function to count customers
    public function getCustomerCount()
    {
        // Assuming the 'customers' table exists and contains a column for customer data
        $customerCount = DB::connection($this->connection)
            ->table('customers') // Change 'customers' to the actual table name if needed
            ->count(); // Count the number of rows in the table (customers)

        return $customerCount;
    }

    public function getProductsCount()
    {
        // Assuming the 'customers' table exists and contains a column for customer data
        $productsCount = DB::connection($this->connection)
            ->table('products') // Change 'customers' to the actual table name if needed
            ->count(); // Count the number of rows in the table (customers)

        return $productsCount;
    }

    public function getLocationCount()
    {
        // Assuming the 'customers' table exists and contains a column for customer data
        $locationCount = DB::connection($this->connection)
            ->table('locations') // Change 'customers' to the actual table name if needed
            ->count(); // Count the number of rows in the table (customers)

        return $locationCount;
    }

    public function dashboardData()
    {
        $years = $this->years;

        $salesRevenue = [];
        $topProducts = [];
        $salesRevenueSecondary = [];
        $customerCount = $this->getCustomerCount(); // Get customer count
        $productsCount = $this->getproductsCount(); // Get customer count
        $locationCount = $this->getLocationCount();



        foreach ($years as $year) {
            $yearlyRevenue = DB::connection($this->connection)
                ->table('fakta_penjualan')
                ->whereRaw('LEFT(sk_waktu, 4) = ?', [$year])
                ->selectRaw('SUM(total * price) as total_revenue')
                ->value('total_revenue');

            $salesRevenue[$year] = $yearlyRevenue ?: 0;

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
                // Pad the month with leading zero to match the date format in sk_waktu
                $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);

                $monthlyRevenueValue = DB::connection($this->connection)
                    ->table('fakta_penjualan')
                    ->whereRaw('LEFT(sk_waktu, 4) = ? AND LEFT(RIGHT(sk_waktu, 4), 2) = ?', [$year, $monthStr])
                    ->selectRaw('SUM(total * price) as total_revenue')
                    ->value('total_revenue');

                $monthlyRevenue[$monthStr] = $monthlyRevenueValue ?: 0;
            }

            $salesRevenueSecondary[$year] = $monthlyRevenue;

            foreach ($years as $year) {
                // Change the query to calculate total orders instead of revenue
                $yearlyOrders = DB::connection($this->connection)
                    ->table('fakta_penjualan')
                    ->whereRaw('LEFT(sk_waktu, 4) = ?', [$year])
                    ->selectRaw('COUNT(*) as total_orders') // Count the number of rows for each year
                    ->value('total_orders');
            
                $totalOrders[$year] = $yearlyOrders ?: 0; // Store the total orders for each year
            }
            
        }

        return view('dashboard.dashboard', compact(
            'years',
            'salesRevenue',
            'topProducts',
            'salesRevenueSecondary',
            'customerCount', // Include customer count in the view
            'productsCount',
            'locationCount',
            'totalOrders'

            //Jumlah Stock => faktapenjualan -> diambil setiap product stocknya (ga boleh double) dijumlahin 
            //TODO:
            //Top 5 Kota =>  faktashipping count sk_destinasi / tujuan sama terus diorder by
        ));
        // return response()->json($topProducts);
    }

    public function getData()
    {
        $years = $this->years;

        $salesRevenue = [];
        $topProducts = [];

        foreach ($years as $year) {
            $monthlyRevenue = [];

            for ($month = 1; $month <= 12; $month++) {
                // Pad the month with leading zero to match the date format in sk_waktu
                $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);

                $monthlyRevenueValue = DB::connection($this->connection)
                    ->table('fakta_penjualan')
                    ->whereRaw('LEFT(sk_waktu, 4) = ? AND LEFT(RIGHT(sk_waktu, 4), 2) = ?', [$year, $monthStr])
                    ->selectRaw('SUM(total * price) as total_revenue')
                    ->value('total_revenue');

                $monthlyRevenue[$monthStr] = $monthlyRevenueValue ?: 0;
            }

            $salesRevenue[$year] = $monthlyRevenue;

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
        }

        return response()->json($salesRevenue);
    }
}

