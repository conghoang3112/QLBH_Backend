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
    // try {
    //     $serverName = "192.168.5.95";
    //     $databaseName = "QLBH";
    //     $username = "sa";
    //     $password = "123456";

    //     $dsn = "sqlsrv:server=$serverName;Database=$databaseName";

    //     $conn = new PDO($dsn, $username, $password);
    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //     $sql = "SELECT * FROM tbl_DonViTinh";
    //     $stmt = $conn->query($sql);
    //     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     return response()->json($data);
    // } catch (PDOException $e) {
    //     return 'Failed to connect to database: ' . $e->getMessage();
    // }
});

// try {
//     $serverName = "your_server_name";
//     $connectionOptions = [
//         "Database" => "your_database_name",
//         "UID" => "your_username",
//         "PWD" => "your_password"
//     ];
//     $conn = new PDO("sqlsrv:server=$serverName", $connectionOptions);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $sql = "SELECT * FROM tbl_DonViTinh";
//     $stmt = $conn->query($sql);
//     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     return response()->json($data);
// } catch (PDOException $e) {
//     return 'Failed to connect to database: ' . $e->getMessage();
// }

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