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

    public function dashboardData()
    {
        $years = $this->years;

        $salesRevenue = [];
        $topProducts = [];

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
        }

        return view('dashboard.dashboard', compact(
            'years',
            'salesRevenue',
            'topProducts',
            //Jumlah Stock => faktapenjualan -> diambil setiap product stocknya (ga boleh double) dijumlahin 
            //TODO:
            //Top 5 Kota =>  faktashipping count sk_destinasi / tujuan sama terus diorder by
        ));
        // return response()->json($topProducts);
    }
}
