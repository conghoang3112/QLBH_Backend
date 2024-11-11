<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/view', function () {
    try {
        $data = DB::table('tbl_DonViTinh')->get(); 
        return response()->json($data); 
    } catch (\Exception $e) {
        return 'Failed to connect to database: ' . $e->getMessage();
    }
});

// Route::get('/create', function () {
//     try {
//         DB::table('tbl_DonViTinh')->insert([
//             'MaDVT' => 'DVT001',  
//             'TenDVT' => 'Đơn vị tính A',  
//         ]);

//         return 'Record created successfully!';
//     } catch (\Exception $e) {
//         return 'Failed to create record: ' . $e->getMessage();
//     }
// });

// Route::get('/update/{DonViTinhID}/{MaDVT}/{TenDVT}', function ($DonViTinhID, $MaDVT, $TenDVT) {
//     try {
//         DB::table('tbl_DonViTinh')
//             ->where('DonViTinhID', $DonViTinhID) 
//             ->update([
//                 'MaDVT' => $MaDVT, 
//                 'TenDVT' => $TenDVT, 
//             ]);

//         return 'Record updated successfully!';
//     } catch (\Exception $e) {
//         return 'Failed to update record: ' . $e->getMessage();
//     }
// });

// Route::get('/delete/{DonViTinhID}', function ($DonViTinhID) {
//     try {
//         $deleted = DB::table('tbl_DonViTinh')
//             ->where('DonViTinhID', $DonViTinhID) 
//             ->delete();

//         if ($deleted) {
//             return 'Record deleted successfully!';
//         } else {
//             return 'No record found to delete with DonViTinhID ' . $DonViTinhID;
//         }
//     } catch (\Exception $e) {
//         return 'Failed to delete record: ' . $e->getMessage();
//     }
// });